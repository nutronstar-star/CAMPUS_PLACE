@extends('layouts.super-admin')
@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">System Audit Logs</h1>
        <p class="text-gray-500">Track critical actions and login attempts for security and compliance.</p>
    </div>

    {{-- ================================================== --}}
    {{-- LOGIN ATTEMPT STATS                               --}}
    {{-- ================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-slate-500">
            <p class="text-sm text-gray-500 font-medium">Total Attempts</p>
            <p class="text-3xl font-bold text-gray-800">{{ $attemptsTotal }}</p>
            <p class="text-xs text-gray-400 mt-1">All-time</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-emerald-500">
            <p class="text-sm text-gray-500 font-medium">Successful</p>
            <p class="text-3xl font-bold text-gray-800">{{ $attemptsSuccess }}</p>
            <p class="text-xs text-emerald-600 mt-1">
                {{ $attemptsTotal > 0 ? round(($attemptsSuccess / $attemptsTotal) * 100, 1) : 0 }}% success rate
            </p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-rose-500">
            <p class="text-sm text-gray-500 font-medium">Failed</p>
            <p class="text-3xl font-bold text-gray-800">{{ $attemptsFailed }}</p>
            <p class="text-xs text-rose-600 mt-1">All-time</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-amber-500">
            <p class="text-sm text-gray-500 font-medium">Failed (24h)</p>
            <p class="text-3xl font-bold text-gray-800">{{ $failed24h }}</p>
            <p class="text-xs text-amber-600 mt-1">Watch for spikes</p>
        </div>
    </div>

    {{-- ================================================== --}}
    {{-- LOGIN ATTEMPTS TABLE                              --}}
    {{-- ================================================== --}}
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200 mb-8">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-800">Recent Login Attempts</h2>
            <span class="text-xs text-gray-500">{{ $loginAttempts->total() }} record{{ $loginAttempts->total() === 1 ? '' : 's' }}</span>
        </div>
        <div class="overflow-x-auto w-full pb-4"><table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white border-b text-sm text-gray-600 uppercase tracking-wider">
                    <th class="p-4 font-semibold">Time</th>
                    <th class="p-4 font-semibold">Email</th>
                    <th class="p-4 font-semibold">IP Address</th>
                    <th class="p-4 font-semibold text-right">Result</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($loginAttempts as $attempt)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($attempt->attempted_at)->format('d M Y, h:i A') }}
                        </td>
                        <td class="p-4 font-medium text-gray-900">{{ $attempt->email ?? '—' }}</td>
                        <td class="p-4 text-sm text-gray-600 font-mono">{{ $attempt->ip_address ?? '—' }}</td>
                        <td class="p-4 text-right">
                            @if($attempt->success)
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">Success</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-800">Failed</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="p-8 text-center text-gray-500">No login attempts recorded yet.</td></tr>
                @endforelse
            </tbody>
        </table></div>
    </div>
    <div class="mb-8">{{ $loginAttempts->links() }}</div>

    {{-- ================================================== --}}
    {{-- EXISTING AUDIT LOGS (system actions)              --}}
    {{-- ================================================== --}}
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800">System Actions</h2>
        </div>
        <div class="overflow-x-auto w-full pb-4"><table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white border-b text-sm text-gray-600 uppercase tracking-wider">
                    <th class="p-4 font-semibold">Time</th>
                    <th class="p-4 font-semibold">User</th>
                    <th class="p-4 font-semibold">Action</th>
                    <th class="p-4 font-semibold">Entity</th>
                    <th class="p-4 font-semibold">IP Address</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-sm text-gray-500">{{ $log->created_at->format('d M Y, h:i A') }}</td>
                        <td class="p-4 font-medium text-gray-900">{{ $log->user->name ?? 'System' }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-800">{{ $log->action }}</span>
                        </td>
                        <td class="p-4 text-gray-700">{{ $log->entity_type }} #{{ $log->entity_id }}</td>
                        <td class="p-4 text-sm text-gray-500 font-mono">{{ $log->ip_address }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="p-8 text-center text-gray-500">No audit logs found.</td></tr>
                @endforelse
            </tbody>
        </table></div>
    </div>
    <div class="mt-4">{{ $logs->links() }}</div>
@endsection