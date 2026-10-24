<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\User;
use App\Models\CollegeAdmin;
use App\Models\Department;
use App\Models\AicteVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollegeVerificationController extends Controller
{
    public function index()
    {
        $colleges = College::with(['state', 'aicteVerifications'])->latest()->paginate(10);
        return view('super-admin.colleges.index', compact('colleges'));
    }

    public function approve(College $college)
    {
        DB::transaction(function () use ($college) {
            $college->update([
                'status' => 'verified',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);

            $user = User::where('email', $college->email)->first();
            if ($user) {
                CollegeAdmin::firstOrCreate([
                    'user_id' => $user->id,
                    'college_id' => $college->id,
                ], [
                    'designation' => 'TPO',
                ]);
            }

            if ($college->departments()->count() === 0) {
                Department::create(['college_id' => $college->id, 'name' => 'Computer Science', 'code' => 'CSE']);
                Department::create(['college_id' => $college->id, 'name' => 'Information Technology', 'code' => 'IT']);
            }

            \App\Models\AuditLog::create(['user_id' => auth()->id(), 'action' => 'College Verified', 'entity_type' => 'College', 'entity_id' => $college->id, 'ip_address' => request()->ip()]);
        });

        return back()->with('success', 'College verified successfully and Admin account activated.');
    }

    public function reject(College $college)
    {
        $college->update([
            'status' => 'rejected',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        \App\Models\AuditLog::create(['user_id' => auth()->id(), 'action' => 'College Rejected', 'entity_type' => 'College', 'entity_id' => $college->id, 'ip_address' => request()->ip()]);

        return back()->with('error', 'College rejected.');
    }
}
