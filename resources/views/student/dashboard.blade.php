@extends('layouts.student')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Welcome, {{ $student->user->name }}</h1>
        <p class="text-gray-500">{{ $student->college->name }} | CGPA: {{ $student->cgpa }} | Backlogs: {{ $student->backlogs }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-blue-500">
            <p class="text-sm text-gray-500 font-medium">Total Applications</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_applications'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-indigo-500">
            <p class="text-sm text-gray-500 font-medium">Shortlisted</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['shortlisted'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-yellow-500">
            <p class="text-sm text-gray-500 font-medium">Interviews</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['interviews'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-green-500">
            <p class="text-sm text-gray-500 font-medium">Offers Received</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['offers'] }}</p>
        </div>
    </div>
    <!-- AdSense Placeholder -->
    <div class="mt-8 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
        <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-2">Advertisement</p>
        <div class="h-24 bg-gray-200 rounded flex items-center justify-center text-gray-500">
            Google AdSense Space (Student Dashboard)
        </div>
    </div>
@endsection

