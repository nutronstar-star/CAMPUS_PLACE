@extends('layouts.company')
@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Applicants for: {{ $job->title }}</h1>
            <p class="text-gray-500">Review candidates and update their status.</p>
        </div>
        <a href="{{ route('company.jobs.index') }}" class="text-orange-600 hover:text-orange-800 font-medium">&larr; Back to Jobs</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b text-sm text-gray-600 uppercase tracking-wider">
                    <th class="p-4 font-semibold">Student Name</th>
                    <th class="p-4 font-semibold">College / Dept</th>
                    <th class="p-4 font-semibold">CGPA</th>`r`n                    <th class="p-4 font-semibold">Resume</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($applications as $app)
                <tr class="hover:bg-gray-50">
                    <td class="p-4">
                        <div class="font-medium text-gray-900">{{ $app->student->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $app->student->enrollment_no }}</div>
                    </td>
                    <td class="p-4">
                        <div class="text-gray-900">{{ $app->student->college->name }}</div>
                        <div class="text-sm text-gray-500">{{ $app->student->department->name }}</div>
                    </td>
                    <td class="p-4 text-gray-700 font-bold">{{ $app->student->cgpa }}</td>
                    <td class="p-4">
                        @if($app->resume)
                            <a href="{{ asset('storage/' . $app->resume->resume_url) }}" target="_blank" class="bg-slate-200 text-slate-800 px-3 py-1 rounded text-sm hover:bg-slate-300 transition inline-block">
                                View PDF
                            </a>
                        @else
                            <span class="text-xs text-gray-400 italic">Not uploaded</span>
                        @endif
                    </td>
                    <td class="p-4">
                        @if($app->status === 'applied')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Applied</span>
                        @elseif($app->status === 'shortlisted')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Shortlisted</span>
                        @elseif($app->status === 'interview')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Interview Scheduled</span>
                        @elseif($app->status === 'selected')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Selected / Offered</span>
                        @elseif($app->status === 'rejected')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($app->status) }}</span>
                        @endif
                    </td>
                    <td class="p-4 text-right space-x-2">
                        @if($app->status === 'applied')
                            <form action="{{ route('company.applications.status', $app) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="shortlisted">
                                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded text-sm transition">Shortlist</button>
                            </form>
                        @endif

                        @if($app->status === 'shortlisted')
                            <a href="{{ route('company.interviews.create', $app) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm transition inline-block">Schedule Interview</a>
                        @endif

                        @if($app->status === 'interview')
                            <form action="{{ route('company.offers.release', $app) }}" method="POST" enctype="multipart/form-data" class="inline-flex items-center gap-1">
                                @csrf
                                <input type="file" name="offer_letter" accept=".pdf" title="Offer Letter PDF (optional)" class="text-xs w-24">
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm transition">Release Offer</button>
                            </form>
                        @endif

                        @if(in_array($app->status, ['applied', 'shortlisted', 'interview']))
                            <form action="{{ route('company.applications.status', $app) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">Reject</button>
                            </form>
                        @endif
                        
                        @if($app->status === 'selected')
                            <span class="text-sm text-green-600 font-medium italic">Hired!</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-8 text-center text-gray-500">No applications received yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

