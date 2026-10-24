<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Company;
use App\Models\BlacklistCollege;
use App\Models\BlacklistCompany;
use Illuminate\Http\Request;

class BlacklistController extends Controller
{
    public function index()
    {
        $blacklistedColleges = BlacklistCollege::with('college')->latest()->get();
        $blacklistedCompanies = BlacklistCompany::with('company')->where('scope', 'national')->latest()->get();
        
        return view('super-admin.blacklist.index', compact('blacklistedColleges', 'blacklistedCompanies'));
    }

    public function blacklistCollege(Request $request, College $college)
    {
        $request->validate(['reason' => 'required|string|min:10']);
        
        $college->update(['status' => 'blacklisted']);
        BlacklistCollege::create([
            'college_id' => $college->id,
            'reason' => $request->reason,
            'blacklisted_by' => auth()->id()
        ]);

        \App\Models\AuditLog::create(['user_id' => auth()->id(), 'action' => 'College Blacklisted', 'entity_type' => 'College', 'entity_id' => $college->id, 'ip_address' => request()->ip()]);

        return back()->with('success', 'College blacklisted successfully.');
    }

    public function blacklistCompany(Request $request, Company $company)
    {
        $request->validate(['reason' => 'required|string|min:10']);
        
        $company->update(['status' => 'blacklisted']);
        BlacklistCompany::create([
            'company_id' => $company->id,
            'reason' => $request->reason,
            'scope' => 'national',
            'blacklisted_by' => auth()->id()
        ]);

        \App\Models\AuditLog::create(['user_id' => auth()->id(), 'action' => 'Company Blacklisted', 'entity_type' => 'Company', 'entity_id' => $company->id, 'ip_address' => request()->ip()]);

        return back()->with('success', 'Company blacklisted nationally successfully.');
    }
}
