<?php
namespace App\Http\Controllers\CollegeAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyCollegeBlacklist;
use Illuminate\Http\Request;

class BlacklistController extends Controller
{
    public function index()
    {
        $collegeId = auth()->user()->collegeAdminProfile->college_id;
        
        // Get all companies that are globally approved
        $companies = Company::where('status', 'approved')->get();
        
        // Get companies blacklisted by this college
        $blacklisted = CompanyCollegeBlacklist::where('college_id', $collegeId)->with('company')->latest()->get();
        
        return view('college-admin.blacklist.index', compact('companies', 'blacklisted'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'reason' => 'required|string|min:10'
        ]);

        $collegeId = auth()->user()->collegeAdminProfile->college_id;

        // Check if already blacklisted by this college
        $exists = CompanyCollegeBlacklist::where('company_id', $request->company_id)->where('college_id', $collegeId)->exists();
        if ($exists) {
            return back()->with('error', 'Company is already blacklisted for your college.');
        }

        CompanyCollegeBlacklist::create([
            'company_id' => $request->company_id,
            'college_id' => $collegeId,
            'reason' => $request->reason,
            'blacklisted_by' => auth()->id()
        ]);

        return back()->with('success', 'Company blacklisted for your college successfully.');
    }
}
