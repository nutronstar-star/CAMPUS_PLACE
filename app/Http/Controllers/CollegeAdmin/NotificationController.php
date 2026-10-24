<?php
namespace App\Http\Controllers\CollegeAdmin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function create()
    {
        return view('college-admin.notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        $collegeId = auth()->user()->collegeAdminProfile->college_id;
        
        // Get all user IDs for students in this college
        $students = Student::where('college_id', $collegeId)->get();

        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->user_id,
                'college_id' => $collegeId,
                'title' => $request->title,
                'message' => $request->message,
                'type' => 'announcement',
                'is_critical' => false,
            ]);
        }

        return back()->with('success', 'Announcement sent to all ' . $students->count() . ' students successfully.');
    }
}