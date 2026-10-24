<?php
namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user()->studentProfile;
        if (!$student) { abort(403, 'Student profile not found.'); }

        $stats = [
            'total_applications' => $student->applications()->count(),
            'shortlisted' => $student->applications()->where('status', 'shortlisted')->count(),
            'interviews' => $student->applications()->where('status', 'interview')->count(),
            'offers' => \App\Models\Offer::where('student_id', $student->id)->count(),
        ];

        return view('student.dashboard', compact('student', 'stats'));
    }
}
