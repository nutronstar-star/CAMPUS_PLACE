@extends('layouts.student')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Browse Jobs</h1>
            <p class="text-gray-500">Jobs specifically approved for {{ $student->college->name }}.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm"><p>{{ session('success') }}</p></div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm"><p>{{ session('error') }}</p></div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($jobs as $job)
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg p-6 flex flex-col justify-between hover:shadow-md transition">
            <div>
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-lg font-bold text-gray-900">{{ $job->title }}</h3>
                    <span class="bg-blue-50 text-blue-700 border border-blue-100 text-xs font-semibold px-2 py-1 rounded">{{ ucfirst($job->job_type) }}</span>
                </div>
                <p class="text-sm text-gray-600 font-medium mb-4">{{ $job->company->name }}</p>
                
                <div class="text-sm text-gray-500 space-y-1 mb-4">
                    <p><strong>Package:</strong> ?{{ number_format($job->package_max) }} / annum</p>
                    <p><strong>Location:</strong> {{ $job->location ?? 'Not specified' }}</p>
                    <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}</p>
                </div>
            </div>
            
            <form action="{{ route('student.jobs.apply', $job) }}" method="POST" class="mt-4 pt-4 border-t border-gray-100">
                @csrf
                <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-medium py-2 rounded shadow transition">Apply Now</button>
            </form>
        </div>
        @empty
        <div class="col-span-2 bg-white shadow-sm border border-gray-200 rounded-lg p-12 text-center text-gray-500">
            No jobs available for your college right now.
        </div>
        @endforelse
    </div>
@endsection
