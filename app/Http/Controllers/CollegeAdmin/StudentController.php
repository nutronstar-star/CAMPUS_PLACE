<?php
namespace App\Http\Controllers\CollegeAdmin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $collegeId = auth()->user()->collegeAdminProfile->college_id;
        $students = Student::where('college_id', $collegeId)
            ->with(['user', 'department'])
            ->latest()
            ->paginate(15);
            
        return view('college-admin.students.index', compact('students'));
    }

    public function edit(Student $student)
    {
        // Security check
        if ($student->college_id !== auth()->user()->collegeAdminProfile->college_id) { abort(403); }
        return view('college-admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        if ($student->college_id !== auth()->user()->collegeAdminProfile->college_id) { abort(403); }

        $request->validate([
            'cgpa' => 'required|numeric|between:0,10',
            'backlogs' => 'required|integer|min:0',
            'passing_year' => 'required|integer|min:2024|max:2030',
        ]);

        $student->update([
            'cgpa' => $request->cgpa,
            'backlogs' => $request->backlogs,
            'passing_year' => $request->passing_year,
        ]);

        return redirect()->route('college.students.index')->with('success', 'Student academic record updated.');
    }
}
