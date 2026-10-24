<?php
namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function index()
    {
        $company = auth()->user()->companyProfile;
        
        // Get all applications for jobs posted by this company
        $applications = Application::whereHas('job', function($q) use ($company) {
            $q->where('company_id', $company->id);
        })->with(['student.user', 'student.college', 'job'])->latest()->paginate(10);

        return view('company.applicants.index', compact('applications'));
    }

    public function shortlist(Application $application)
    {
        $application->update(['status' => 'shortlisted']);
        return back()->with('success', 'Candidate shortlisted successfully.');
    }
}
