<?php
namespace App\Http\Controllers\CollegeAdmin;
use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $admin = auth()->user()->collegeAdminProfile;
        $collegeId = $admin->college_id;

        $jobs = Job::whereHas('colleges', function($q) use ($collegeId) {
            $q->where('college_id', $collegeId);
        })->with(['company', 'colleges'])->latest()->paginate(10);

        return view('college-admin.jobs.index', compact('jobs', 'collegeId'));
    }

    public function updateStatus(Request $request, Job $job)
    {
        $request->validate(['status' => 'required|in:approved,rejected']);
        $admin = auth()->user()->collegeAdminProfile;
        
        $job->colleges()->updateExistingPivot($admin->college_id, [
            'approval_status' => $request->status,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', "Job {$request->status} for your college.");
    }
}

