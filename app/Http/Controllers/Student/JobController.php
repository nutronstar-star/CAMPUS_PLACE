<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Application;
use App\Models\ResumeVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function index()
    {
        $student = auth()->user()->studentProfile;

        $jobs = Job::whereHas('colleges', function($query) use ($student) {
            $query->where('college_id', $student->college_id)
                  ->where('approval_status', 'approved');
        })->where('status', 'active')->latest()->paginate(10);

        return view('student.jobs.index', compact('jobs', 'student'));
    }

    public function apply(Request $request, Job $job)
    {
        $student = auth()->user()->studentProfile;

        // 1. Duplicate check
        $exists = Application::where('student_id', $student->id)->where('job_id', $job->id)->exists();
        if ($exists) {
            return back()->with('error', 'You have already applied to this job.');
        }

        // 2. Eligibility
        $eligibility = $job->eligibility;
        if ($eligibility) {
            if (isset($eligibility['cgpa']) && $student->cgpa < $eligibility['cgpa']) {
                return back()->with('error', "Ineligible: Required CGPA is {$eligibility['cgpa']}, yours is {$student->cgpa}.");
            }
            if (isset($eligibility['backlogs']) && $student->backlogs > $eligibility['backlogs']) {
                return back()->with('error', "Ineligible: Maximum allowed backlogs is {$eligibility['backlogs']}.");
            }
            if (!empty($eligibility['passing_year']) && $student->passing_year != $eligibility['passing_year']) {
                return back()->with('error', "Ineligible: This job is for the {$eligibility['passing_year']} passing year.");
            }
            if (!empty($eligibility['departments'])) {
                $studentDept = $student->department->code;
                if (!in_array($studentDept, $eligibility['departments'])) {
                    return back()->with('error', "Ineligible: Your department ({$studentDept}) is not allowed for this job.");
                }
            }
            if (!empty($eligibility['skills'])) {
                $studentSkills = array_map('strtolower', $student->skills ?? []);
                foreach ($eligibility['skills'] as $reqSkill) {
                    if (!in_array(strtolower($reqSkill), $studentSkills)) {
                        return back()->with('error', "Ineligible: You are missing the required skill: {$reqSkill}.");
                    }
                }
            }
        }

        // 3. Create Application
        $application = Application::create([
            'student_id' => $student->id,
            'job_id' => $job->id,
            'college_id' => $student->college_id,
            'status' => 'applied'
        ]);

        // FIX: attach the student's default resume to this application
        $defaultResume = ResumeVersion::where('student_id', $student->id)
            ->where('is_default', true)
            ->first();

        if ($defaultResume) {
            DB::table('application_resumes')->insert([
                'application_id' => $application->id,
                'resume_url' => $defaultResume->resume_url,
                'resume_version' => $defaultResume->version,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Notify company
        \App\Models\Notification::create([
            'user_id' => $job->company->user_id,
            'title' => 'New Application Received',
            'message' => $student->user->name . ' applied for ' . $job->title,
            'type' => 'announcement',
            'is_critical' => false,
        ]);

        return back()->with('success', 'Successfully applied for ' . $job->title);
    }
}
