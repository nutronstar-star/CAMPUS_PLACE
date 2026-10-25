@extends('layouts.company')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">My Job Postings</h1>
        <a href="{{ route('company.jobs.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded shadow transition">+ Post New Job</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
        <div class="overflow-x-auto w-full pb-4"><table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b text-sm text-gray-600 uppercase tracking-wider">
                    <th class="p-4 font-semibold">Job Title</th>
                    <th class="p-4 font-semibold">Type</th>
                    <th class="p-4 font-semibold">Package (Max)</th>
                    <th class="p-4 font-semibold">Deadline</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($jobs as $job)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 font-medium text-gray-900">{{ $job->title }}</td>
                    <td class="p-4 text-gray-700 capitalize">{{ str_replace('_', ' ', $job->job_type) }}</td>
                    <td class="p-4 text-gray-700">?{{ number_format($job->package_max) }}</td>
                    <td class="p-4 text-gray-700">{{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}</td>
                    <td class="p-4 text-right">
                        <a href="{{ route('company.jobs.applicants', $job) }}" class="bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded text-sm transition">View Applicants</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-8 text-center text-gray-500">You haven't posted any jobs yet.</td></tr>
                @endforelse
            </tbody>
        </table></div>
    </div>
    <div class="mt-4">{{ $jobs->links() }}</div>
@endsection
