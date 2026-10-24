<?php
namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\College;
use App\Models\Application;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $company = auth()->user()->companyProfile;
        $jobs = $company->jobs()->latest()->paginate(10);
        return view('company.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $colleges = College::where('status', 'verified')->get();
        return view('company.jobs.create', compact('colleges'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'job_type' => 'required|in:full_time,internship',
            'package_min' => 'required|numeric',
            'package_max' => 'required|numeric',
            'deadline' => 'required|date|after:today',
            'colleges' => 'required|array|min:1|max:1000',
            'colleges.*' => 'exists:colleges,id',
        ]);

        $company = auth()->user()->companyProfile;

        $requiredSkills = [];
        if ($request->required_skills) {
            $requiredSkills = array_map('trim', explode(',', $request->required_skills));
        }

        $job = Job::create([
            'company_id' => $company->id,
            'title' => $request->title,
            'description' => $request->description,
            'job_type' => $request->job_type,
            'package_min' => $request->package_min,
            'package_max' => $request->package_max,
            'location' => $request->location,
            'eligibility' => [
                'cgpa' => $request->cgpa ?? 0,
                'backlogs' => $request->backlogs ?? 99,
                'passing_year' => $request->passing_year,
                'departments' => $request->departments ?? [],
                'skills' => $requiredSkills,
            ],
            'deadline' => $request->deadline,
            'status' => 'active',
        ]);

        // FIX: jobs start as PENDING for each college - TPO must approve
        $job->colleges()->attach($request->colleges, ['approval_status' => 'pending']);

        return redirect()->route('company.jobs.index')->with('success', 'Job posted. Waiting for each college TPO to approve.');
    }

    public function applicants(Job $job)
    {
        if ($job->company_id !== auth()->user()->companyProfile->id) { abort(403); }
        $applications = $job->applications()->with(['student.user', 'student.college', 'student.department', 'resume'])->latest()->paginate(15);
        return view('company.jobs.applicants', compact('job', 'applications'));
    }

    public function updateApplicationStatus(Request $request, Application $application)
    {
        $request->validate(['status' => 'required|in:shortlisted,rejected']);
        $application->update(['status' => $request->status]);

        \App\Models\Notification::create([
            'user_id' => $application->student->user_id,
            'title' => 'Application Update: ' . ucfirst($request->status),
            'message' => 'Your application for ' . $application->job->title . ' at ' . $application->job->company->name . ' has been marked as ' . $request->status . '.',
            'type' => 'shortlist',
            'is_critical' => true,
        ]);

        return back()->with('success', "Application marked as {$request->status}.");
    }
}
