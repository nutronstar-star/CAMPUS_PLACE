<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Company;
use App\Models\Student;
use App\Models\Job;
use App\Models\Application;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_colleges' => College::count(),
            'pending_colleges' => College::where('status', 'pending')->count(),
            'total_companies' => Company::count(),
            'pending_companies' => Company::where('status', 'pending')->count(),
            'total_students' => Student::count(),
            'total_jobs' => Job::count(),
            'total_applications' => Application::count(),
        ];

        return view('super-admin.dashboard', compact('stats'));
    }
}
