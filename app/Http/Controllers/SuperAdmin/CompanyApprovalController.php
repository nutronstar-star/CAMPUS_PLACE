<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyApprovalController extends Controller
{
    public function index()
    {
        $companies = Company::latest()->paginate(10);
        return view('super-admin.companies.index', compact('companies'));
    }

    public function approve(Company $company)
    {
        $company->update([
            'status' => 'approved',
            'global_approved_by' => auth()->id(),
            'global_approved_at' => now(),
        ]);

        \App\Models\AuditLog::create(['user_id' => auth()->id(), 'action' => 'Company Approved', 'entity_type' => 'Company', 'entity_id' => $company->id, 'ip_address' => request()->ip()]);
        return back()->with('success', 'Company approved successfully.');
    }

    public function reject(Company $company)
    {
        $company->update([
            'status' => 'rejected',
            'global_approved_by' => auth()->id(),
            'global_approved_at' => now(),
        ]);

        \App\Models\AuditLog::create(['user_id' => auth()->id(), 'action' => 'Company Rejected', 'entity_type' => 'Company', 'entity_id' => $company->id, 'ip_address' => request()->ip()]);
        return back()->with('error', 'Company rejected.');
    }
}

