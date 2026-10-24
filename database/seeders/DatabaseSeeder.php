<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\State;
use App\Models\College;
use App\Models\Department;
use App\Models\CollegeAdmin;
use App\Models\Student;
use App\Models\Company;
use App\Models\Job;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. STATES
        $states = collect([
            ['name' => 'Maharashtra',   'code' => 'MH'],
            ['name' => 'Delhi',         'code' => 'DL'],
            ['name' => 'Karnataka',     'code' => 'KA'],
            ['name' => 'Uttar Pradesh', 'code' => 'UP'],
            ['name' => 'Tamil Nadu',    'code' => 'TN'],
        ])->map(fn ($s) => State::create($s));

        // 2. SUPER ADMIN
        User::create([
            'name' => 'Super Admin',
            'email' => 'super@campusplace.in',
            'password' => Hash::make('Admin@123'),
            'role' => 'super_admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // 3. COLLEGES + ADMINS + DEPARTMENTS
        $collegeData = [
            ['name' => 'College A', 'code' => 'MH001', 'state' => $states[0], 'city' => 'Mumbai'],
            ['name' => 'College B', 'code' => 'DL001', 'state' => $states[1], 'city' => 'New Delhi'],
            ['name' => 'College C', 'code' => 'KA001', 'state' => $states[2], 'city' => 'Bengaluru'],
            ['name' => 'College D', 'code' => 'UP001', 'state' => $states[3], 'city' => 'Lucknow'],
            ['name' => 'College E', 'code' => 'TN001', 'state' => $states[4], 'city' => 'Chennai'],
        ];

        $colleges = collect();
        $departmentsByCollege = [];

        foreach ($collegeData as $i => $data) {
            $letter = strtolower(chr(65 + $i));

            $college = College::create([
                'state_id' => $data['state']->id,
                'name' => $data['name'],
                'code' => $data['code'],
                'email' => 'info@college' . $letter . '.edu',
                'city' => $data['city'],
                'tpo_name' => 'TPO ' . $data['name'],
                'status' => 'verified',
                'total_students' => 2,
            ]);
            $colleges->push($college);

            $adminUser = User::create([
                'name' => 'Admin ' . $data['name'],
                'email' => 'admin.' . $letter . '@college' . $letter . '.edu',
                'password' => Hash::make('Admin@123'),
                'role' => 'college_admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
            CollegeAdmin::create([
                'user_id' => $adminUser->id,
                'college_id' => $college->id,
                'designation' => 'TPO',
            ]);

            $departmentsByCollege[$college->id] = collect([
                Department::create(['college_id' => $college->id, 'name' => 'Computer Science', 'code' => 'CSE']),
                Department::create(['college_id' => $college->id, 'name' => 'Information Technology', 'code' => 'IT']),
                Department::create(['college_id' => $college->id, 'name' => 'Electronics', 'code' => 'ECE']),
            ]);
        }

        // 4. STUDENTS (2 per college)
        foreach ($colleges as $i => $college) {
            $letter = strtolower(chr(65 + $i));
            $cse = $departmentsByCollege[$college->id]->firstWhere('code', 'CSE');

            for ($j = 1; $j <= 2; $j++) {
                $isDemo = ($i === 0 && $j === 1);
                $email = $isDemo
                    ? 'student1@collegea.edu'
                    : 'student' . (($i * 2) + $j) . '@college' . $letter . '.edu';

                $user = User::create([
                    'name' => 'Student ' . $college->name . ' #' . $j,
                    'email' => $email,
                    'password' => Hash::make('Student@123'),
                    'role' => 'student',
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]);

                Student::create([
                    'user_id' => $user->id,
                    'college_id' => $college->id,
                    'department_id' => $cse->id,
                    'enrollment_no' => $college->code . '2026' . str_pad((string)$j, 3, '0', STR_PAD_LEFT),
                    'cgpa' => $j === 1 ? 8.5 : 7.5,
                    'backlogs' => 0,
                    'passing_year' => 2026,
                    'skills' => ['Python', 'Java', 'SQL'],
                    'status' => 'active',
                ]);
            }
        }

        // 5. DEMO COMPANY
        $companyUser = User::create([
            'name' => 'TechCorp HR',
            'email' => 'hr@techcorp.com',
            'password' => Hash::make('Company@123'),
            'role' => 'company',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        $techcorp = Company::create([
            'user_id' => $companyUser->id,
            'name' => 'TechCorp',
            'industry' => 'IT Services',
            'hr_name' => 'TechCorp HR',
            'hr_email' => 'hr@techcorp.com',
            'hr_phone' => '9876543210',
            'status' => 'approved',
            'global_approved_by' => 1,
            'global_approved_at' => now(),
        ]);

        // 6. DEMO JOBS (mapped to College A only)
        $job1 = Job::create([
            'company_id' => $techcorp->id,
            'title' => 'Software Engineer',
            'description' => 'Develop and maintain web applications using Laravel and Vue.',
            'job_type' => 'full_time',
            'package_min' => 1000000,
            'package_max' => 1200000,
            'location' => 'Mumbai',
            'eligibility' => [
                'cgpa' => 7.0,
                'backlogs' => 0,
                'passing_year' => 2026,
                'departments' => ['CSE', 'IT'],
                'skills' => ['Python', 'Java'],
            ],
            'deadline' => now()->addDays(30),
            'status' => 'active',
        ]);

        $job2 = Job::create([
            'company_id' => $techcorp->id,
            'title' => 'Summer Intern - Data Science',
            'description' => '3-month internship with the data science team.',
            'job_type' => 'internship',
            'package_min' => 20000,
            'package_max' => 25000,
            'stipend' => 25000,
            'location' => 'Remote',
            'eligibility' => [
                'cgpa' => 6.5,
                'backlogs' => 1,
                'passing_year' => 2027,
                'departments' => ['CSE'],
                'skills' => [],
            ],
            'deadline' => now()->addDays(20),
            'status' => 'active',
        ]);

        $job1->colleges()->attach($colleges[0]->id, [
            'approval_status' => 'approved',
            'approved_by' => 2,
            'approved_at' => now(),
        ]);
        $job2->colleges()->attach($colleges[0]->id, [
            'approval_status' => 'approved',
            'approved_by' => 2,
            'approved_at' => now(),
        ]);

        $this->command->info('Seeded: 5 states, 5 colleges, 5 admins, 10 students, 1 company, 2 jobs');
    }
}
