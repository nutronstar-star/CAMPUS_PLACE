<?php
namespace App\Http\Controllers\CollegeAdmin;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Student;
use App\Models\Application;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = auth()->user()->collegeAdminProfile;
        if (!$admin) { abort(403, 'College Admin profile not found.'); }
        
        $collegeId = $admin->college_id;

        $stats = [
            'total_students' => Student::where('college_id', $collegeId)->count(),
            'placed_students' => Student::where('college_id', $collegeId)->where('status', 'placed')->count(),
            'total_jobs' => Job::whereHas('colleges', function($q) use ($collegeId) { $q->where('college_id', $collegeId); })->count(),
            'pending_approvals' => Job::whereHas('colleges', function($q) use ($collegeId) { $q->where('college_id', $collegeId)->where('approval_status', 'pending'); })->count(),
        ];

        return view('college-admin.dashboard', compact('admin', 'stats'));
    }
}
