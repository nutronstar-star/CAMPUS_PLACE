@extends('layouts.super-admin')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Welcome, Super Admin</h1>
        <p class="text-gray-500">Here is the national overview of the placement platform.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Colleges -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-500">
            <p class="text-sm text-gray-500 font-medium">Total Colleges</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_colleges'] }}</p>
            <p class="text-sm text-yellow-600 mt-2">{{ $stats['pending_colleges'] }} pending verification</p>
        </div>

        <!-- Companies -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <p class="text-sm text-gray-500 font-medium">Total Companies</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_companies'] }}</p>
            <p class="text-sm text-yellow-600 mt-2">{{ $stats['pending_companies'] }} pending approval</p>
        </div>

        <!-- Students -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <p class="text-sm text-gray-500 font-medium">Total Students</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_students'] }}</p>
            <p class="text-sm text-gray-400 mt-2">Across all colleges</p>
        </div>

        <!-- Jobs & Applications -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
            <p class="text-sm text-gray-500 font-medium">Active Jobs</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_jobs'] }}</p>
            <p class="text-sm text-gray-400 mt-2">{{ $stats['total_applications'] }} total applications</p>
        </div>
    </div>
@endsection
