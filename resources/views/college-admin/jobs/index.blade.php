@extends('layouts.college-admin')
@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Job Approvals</h1>
            <p class="text-gray-500">Review jobs posted by companies targeting your college.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b text-sm text-gray-600 uppercase tracking-wider">
                    <th class="p-4 font-semibold">Company & Job</th>
                    <th class="p-4 font-semibold">Package</th>
                    <th class="p-4 font-semibold">Deadline</th>
                    <th class="p-4 font-semibold">Approval Status</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($jobs as $job)
                @php
                    $pivot = $job->colleges->where('id', $collegeId)->first()->pivot;
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="p-4">
                        <div class="font-medium text-gray-900">{{ $job->title }}</div>
                        <div class="text-sm text-gray-500">{{ $job->company->name }}</div>
                    </td>
                    <td class="p-4 text-gray-700">?{{ number_format($job->package_max) }}</td>
                    <td class="p-4 text-gray-700">{{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}</td>
                    <td class="p-4">
                        @if($pivot->approval_status === 'approved')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                        @elseif($pivot->approval_status === 'pending')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                        @endif
                    </td>
                    <td class="p-4 text-right space-x-2">
                        @if($pivot->approval_status === 'pending')
                            <form action="{{ route('college.jobs.status', $job) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm transition">Approve</button>
                            </form>
                            <form action="{{ route('college.jobs.status', $job) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">Reject</button>
                            </form>
                        @else
                            <span class="text-sm text-gray-400 italic">No actions available</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-8 text-center text-gray-500">No jobs posted for your college yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
