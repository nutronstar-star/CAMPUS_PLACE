<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Company;
use App\Models\College;
use App\Models\AicteVerification;
use App\Models\DpdpConsent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class CustomRegistrationController extends Controller
{
    // ==========================================
    // STUDENT REGISTRATION
    // ==========================================
    public function showStudentForm()
    {
        // Eager load departments so the blade can group them by college
        $colleges = College::where('status', 'verified')
            ->with('departments')
            ->orderBy('name')
            ->get();

        return view('auth.register-student', compact('colleges'));
    }

    public function registerStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'dpdp_consent' => 'required|accepted',
            'college_id' => 'required|exists:colleges,id',
            'enrollment_no' => 'required|string|unique:students,enrollment_no',
            // FIX: department must belong to the selected college
            'department_id' => [
                'required',
                Rule::exists('departments', 'id')->where('college_id', $request->college_id),
            ],
        ], [
            'department_id.exists' => 'The selected department does not belong to the selected college.',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'student',
                'status' => 'active',
            ]);

            DpdpConsent::create([
                'user_id' => $user->id,
                'consent_type' => 'data_collection',
                'consented' => true,
                'ip_address' => $request->ip(),
                'consented_at' => now(),
            ]);

            Student::create([
                'user_id' => $user->id,
                'college_id' => $request->college_id,
                'department_id' => $request->department_id,
                'enrollment_no' => $request->enrollment_no,
                'status' => 'active',
            ]);

            event(new Registered($user));
            Auth::login($user);
        });

        return redirect()->route('student.dashboard')->with('success', 'Registration successful. Welcome!');
    }

    // ==========================================
    // COMPANY REGISTRATION
    // ==========================================
    public function showCompanyForm()
    {
        return view('auth.register-company');
    }

    public function registerCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'dpdp_consent' => 'required|accepted',
            'company_name' => 'required|string|max:255',
            'industry' => 'required|string',
            'hr_name' => 'required|string',
            'hr_phone' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'company',
                'status' => 'active',
            ]);

            DpdpConsent::create([
                'user_id' => $user->id,
                'consent_type' => 'data_collection',
                'consented' => true,
                'ip_address' => $request->ip(),
                'consented_at' => now(),
            ]);

            Company::create([
                'user_id' => $user->id,
                'name' => $request->company_name,
                'industry' => $request->industry,
                'hr_name' => $request->hr_name,
                'hr_email' => $request->email,
                'hr_phone' => $request->hr_phone,
                'status' => 'pending',
            ]);

            event(new Registered($user));
            Auth::login($user);
        });

        return redirect()->route('company.dashboard')->with('success', 'Registration successful. Please wait for Super Admin approval.');
    }

    // ==========================================
    // COLLEGE REGISTRATION (Apply)
    // ==========================================
    public function showCollegeForm()
    {
        $states = \App\Models\State::all();
        return view('auth.register-college', compact('states'));
    }

    public function registerCollege(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|unique:colleges,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'college_name' => 'required|string|max:255',
            'college_code' => 'required|string|unique:colleges,code',
            'state_id' => 'required|exists:states,id',
            'city' => 'required|string',
            'tpo_name' => 'required|string',
            'aicte_certificate' => 'required|mimes:pdf|max:5120',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'college_admin',
                'status' => 'active',
            ]);

            $path = $request->file('aicte_certificate')->store('verification-docs', 'public');

            $college = College::create([
                'state_id' => $request->state_id,
                'name' => $request->college_name,
                'code' => $request->college_code,
                'email' => $request->email,
                'city' => $request->city,
                'tpo_name' => $request->tpo_name,
                'status' => 'pending',
            ]);

            AicteVerification::create([
                'college_id' => $college->id,
                'certificate_url' => $path,
                'registration_number' => $request->college_code,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('login')->with('status', 'College application submitted. Please wait for Super Admin verification.');
    }
}