<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\CustomRegistrationController;
use App\Http\Controllers\Shared\NotificationController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use App\Http\Controllers\SuperAdmin\CollegeVerificationController;
use App\Http\Controllers\SuperAdmin\CompanyApprovalController;
use App\Http\Controllers\SuperAdmin\ReportController;
use App\Http\Controllers\SuperAdmin\AuditLogController;
use App\Http\Controllers\SuperAdmin\BlacklistController as SuperBlacklistController;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Student\JobController as StudentJobController;
use App\Http\Controllers\Student\ApplicationController as StudentApplicationController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use App\Http\Controllers\Company\DashboardController as CompanyDashboard;
use App\Http\Controllers\Company\JobController as CompanyJobController;
use App\Http\Controllers\Company\InterviewController as CompanyInterviewController;
use App\Http\Controllers\CollegeAdmin\DashboardController as CollegeDashboard;
use App\Http\Controllers\CollegeAdmin\JobController as CollegeJobController;
use App\Http\Controllers\CollegeAdmin\StudentController as CollegeStudentController;
use App\Http\Controllers\CollegeAdmin\BlacklistController as CollegeBlacklistController;
use App\Http\Controllers\CollegeAdmin\ReportController as CollegeReportController;

Route::get('/', function () { return view('welcome'); });

Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    return match ($role) {
        'super_admin' => redirect()->route('super.dashboard'),
        'college_admin' => redirect()->route('college.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        'company' => redirect()->route('company.dashboard'),
        default => abort(403),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', function() { return view('auth.register-hub'); })->name('register');
    Route::get('/register/student', [CustomRegistrationController::class, 'showStudentForm'])->name('register.student');
    Route::post('/register/student', [CustomRegistrationController::class, 'registerStudent']);
    Route::get('/register/company', [CustomRegistrationController::class, 'showCompanyForm'])->name('register.company');
    Route::post('/register/company', [CustomRegistrationController::class, 'registerCompany']);
    Route::get('/register/college', [CustomRegistrationController::class, 'showCollegeForm'])->name('register.college');
    Route::post('/register/college', [CustomRegistrationController::class, 'registerCollege']);
});

Route::middleware(['auth', 'role:super_admin'])->prefix('super')->name('super.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/colleges', [CollegeVerificationController::class, 'index'])->name('colleges.index');
    Route::post('/colleges/{college}/approve', [CollegeVerificationController::class, 'approve'])->name('colleges.approve');
    Route::post('/colleges/{college}/reject', [CollegeVerificationController::class, 'reject'])->name('colleges.reject');
    Route::get('/companies', [CompanyApprovalController::class, 'index'])->name('companies.index');
    Route::post('/companies/{company}/approve', [CompanyApprovalController::class, 'approve'])->name('companies.approve');
    Route::post('/companies/{company}/reject', [CompanyApprovalController::class, 'reject'])->name('companies.reject');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/national', [ReportController::class, 'exportNationalSummary'])->name('reports.export.national');
    Route::get('/reports/export/placements', [ReportController::class, 'exportPlacements'])->name('reports.export.placements');
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit.index');
    Route::get('/blacklist', [SuperBlacklistController::class, 'index'])->name('blacklist.index');
    Route::post('/blacklist/colleges/{college}', [SuperBlacklistController::class, 'blacklistCollege'])->name('blacklist.colleges');
    Route::post('/blacklist/companies/{company}', [SuperBlacklistController::class, 'blacklistCompany'])->name('blacklist.companies');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('dashboard');
    Route::get('/jobs', [StudentJobController::class, 'index'])->name('jobs.index');
    Route::post('/jobs/{job}/apply', [StudentJobController::class, 'apply'])->name('jobs.apply');
    Route::get('/applications', [StudentApplicationController::class, 'index'])->name('applications.index');
    Route::post('/applications/{application}/withdraw', [StudentApplicationController::class, 'withdraw'])->name('applications.withdraw');
    Route::post('/offers/{offer}/respond', [StudentApplicationController::class, 'respondToOffer'])->name('offers.respond');
    Route::get('/profile', [StudentProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [StudentProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/resume', [StudentProfileController::class, 'uploadResume'])->name('profile.resume');
});

Route::middleware(['auth', 'role:company'])->prefix('company')->name('company.')->group(function () {
    Route::get('/dashboard', [CompanyDashboard::class, 'index'])->name('dashboard');
    Route::get('/jobs', [CompanyJobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/create', [CompanyJobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [CompanyJobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{job}/applicants', [CompanyJobController::class, 'applicants'])->name('jobs.applicants');
    Route::post('/applications/{application}/status', [CompanyJobController::class, 'updateApplicationStatus'])->name('applications.status');
    Route::post('/applications/{application}/blacklist', [CompanyJobController::class, 'blacklistStudent'])->name('students.blacklist');
    Route::get('/applications/{application}/interview', [CompanyInterviewController::class, 'create'])->name('interviews.create');
    Route::post('/applications/{application}/interview', [CompanyInterviewController::class, 'store'])->name('interviews.store');
    Route::post('/applications/{application}/offer', [CompanyInterviewController::class, 'releaseOffer'])->name('offers.release');
});

Route::middleware(['auth', 'role:college_admin'])->prefix('college')->name('college.')->group(function () {
    Route::get('/dashboard', [CollegeDashboard::class, 'index'])->name('dashboard');
    Route::get('/jobs', [CollegeJobController::class, 'index'])->name('jobs.index');
    Route::post('/jobs/{job}/status', [CollegeJobController::class, 'updateStatus'])->name('jobs.status');
    Route::get('/students', [CollegeStudentController::class, 'index'])->name('students.index');
    Route::get('/students/{student}/edit', [CollegeStudentController::class, 'edit'])->name('students.edit');
    Route::post('/students/{student}', [CollegeStudentController::class, 'update'])->name('students.update');
    Route::get('/blacklist', [CollegeBlacklistController::class, 'index'])->name('blacklist.index');
    Route::post('/blacklist', [CollegeBlacklistController::class, 'store'])->name('blacklist.store');
    Route::get('/notifications/create', [\App\Http\Controllers\CollegeAdmin\NotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications', [\App\Http\Controllers\CollegeAdmin\NotificationController::class, 'store'])->name('notifications.store');
    Route::get('/reports', [CollegeReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [CollegeReportController::class, 'exportPlacements'])->name('reports.export');
    Route::get('/reports/export-departments', [CollegeReportController::class, 'exportDepartments'])->name('reports.export-departments');
});

Route::get('/demo-login/{role}', function ($role) {
    $emails = [
        'super_admin' => 'super@campusplace.in',
        'college_admin' => 'admin.a@collegea.edu',
        'student' => 'student1@collegea.edu',
        'company' => 'hr@techcorp.com',
    ];
    if (!array_key_exists($role, $emails)) abort(404);
    $user = \App\Models\User::where('email', $emails[$role])->first();
    if ($user) {
        \Illuminate\Support\Facades\Auth::login($user);
        return redirect()->route('dashboard');
    }
    return redirect()->route('login')->with('error', 'Demo user not found.');
})->name('demo.login');

Route::get('/force-logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('force.logout');

require __DIR__.'/auth.php';