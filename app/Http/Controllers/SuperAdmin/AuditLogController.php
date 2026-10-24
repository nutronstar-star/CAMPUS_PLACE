<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;

class AuditLogController extends Controller
{
    public function index()
    {
        // Existing: audit logs (system actions)
        $logs = AuditLog::with('user')
            ->latest()
            ->paginate(20, ['*'], 'audit_page');

        // New: login attempt statistics
        $attemptsTotal = DB::table('login_attempts')->count();
        $attemptsSuccess = DB::table('login_attempts')->where('success', true)->count();
        $attemptsFailed = $attemptsTotal - $attemptsSuccess;
        $failed24h = DB::table('login_attempts')
            ->where('success', false)
            ->where('attempted_at', '>=', now()->subDay())
            ->count();

        // New: paginated list of login attempts (separate page param)
        $loginAttempts = DB::table('login_attempts')
            ->orderByDesc('attempted_at')
            ->orderByDesc('id')
            ->paginate(15, ['*'], 'attempts_page');

        return view('super-admin.audit.index', compact(
            'logs', 'loginAttempts',
            'attemptsTotal', 'attemptsSuccess', 'attemptsFailed', 'failed24h'
        ));
    }
}