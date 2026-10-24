<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResumeVersion;

class ProfileController extends Controller
{
    public function edit()
    {
        $student = auth()->user()->studentProfile->load('college', 'department', 'resumes');
        return view('student.profile.edit', compact('student'));
    }

    public function update(Request $request)
    {
        $student = auth()->user()->studentProfile;
        
        // Removed CGPA, Backlogs, Passing Year from validation
        $request->validate([
            'skills' => 'nullable|string',
            'bio' => 'nullable|string|max:1000',
        ]);

        $student->update([
            'skills' => $request->skills ? array_map('trim', explode(',', $request->skills)) : [],
            'bio' => $request->bio,
        ]);

        return back()->with('success', 'Profile updated successfully. (Academic details must be updated by your TPO).');
    }

    public function uploadResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf|max:5120',
        ]);

        $student = auth()->user()->studentProfile;
        $path = $request->file('resume')->store('resumes', 'public');
        ResumeVersion::where('student_id', $student->id)->update(['is_default' => false]);
        $version = ResumeVersion::where('student_id', $student->id)->count() + 1;

        ResumeVersion::create([
            'student_id' => $student->id,
            'resume_url' => $path,
            'version' => $version,
            'is_default' => true,
        ]);

        return back()->with('success', 'Resume uploaded successfully (Version ' . $version . ').');
    }
}
