@extends('layouts.college-admin')
@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Welcome, {{ $admin->college->name }} TPO</h1>
        <p class="text-gray-500">Manage your campus placements and approve company job postings.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-sky-500">
            <p class="text-sm text-gray-500 font-medium">Total Students</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_students'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-green-500">
            <p class="text-sm text-gray-500 font-medium">Placed Students</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['placed_students'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-indigo-500">
            <p class="text-sm text-gray-500 font-medium">Total Company Jobs</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_jobs'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-yellow-500">
            <p class="text-sm text-gray-500 font-medium">Pending Approvals</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['pending_approvals'] }}</p>
        </div>
    </div>
@endsection
