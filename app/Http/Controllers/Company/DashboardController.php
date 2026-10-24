<?php
namespace App\Http\Controllers\Company;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $company = auth()->user()->companyProfile;
        if (!$company) { abort(403, 'Company profile not found.'); }

        $stats = [
            'active_jobs' => $company->jobs()->where('status', 'active')->count(),
            'total_applications' => \App\Models\Application::whereIn('job_id', $company->jobs()->pluck('id'))->count(),
            'shortlisted' => \App\Models\Application::whereIn('job_id', $company->jobs()->pluck('id'))->where('status', 'shortlisted')->count(),
            'offers' => \App\Models\Offer::where('company_id', $company->id)->count(),
        ];

        return view('company.dashboard', compact('company', 'stats'));
    }
}
