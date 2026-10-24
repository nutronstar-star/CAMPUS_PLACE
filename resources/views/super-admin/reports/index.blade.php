@extends('layouts.super-admin')
@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">National Placement Reports</h1>
        <p class="text-gray-500">Aggregated placement statistics across all registered colleges in India.</p>
    </div>

    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-indigo-500">
            <p class="text-sm text-gray-500 font-medium">Total Students Placed</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalPlaced }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-green-500">
            <p class="text-sm text-gray-500 font-medium">Highest Package</p>
            <p class="text-3xl font-bold text-gray-800">?{{ number_format($highestPackage) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-blue-500">
            <p class="text-sm text-gray-500 font-medium">Average Package</p>
            <p class="text-3xl font-bold text-gray-800">?{{ number_format($averagePackage) }}</p>
        </div>
    </div>

    <!-- State-wise Table -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200 mb-8">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800">State-Wise Breakdown</h2>
        </div>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white border-b text-sm text-gray-600 uppercase tracking-wider">
                    <th class="p-4 font-semibold">State</th>
                    <th class="p-4 font-semibold">Colleges</th>
                    <th class="p-4 font-semibold">Total Students</th>
                    <th class="p-4 font-semibold">Placed</th>
                    <th class="p-4 font-semibold">Placement Rate</th>
                    <th class="p-4 font-semibold">Avg Package</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($stateStats as $stat)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 font-medium text-gray-900">{{ $stat['state'] }}</td>
                    <td class="p-4 text-gray-700">{{ $stat['total_colleges'] }}</td>
                    <td class="p-4 text-gray-700">{{ $stat['total_students'] }}</td>
                    <td class="p-4 text-gray-700 font-bold text-indigo-600">{{ $stat['placed_students'] }}</td>
                    <td class="p-4 text-gray-700">{{ $stat['placement_rate'] }}%</td>
                    <td class="p-4 text-gray-700">?{{ number_format($stat['avg_package']) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h3 class="font-bold text-gray-800">Export Data</h3>
                <p class="text-sm text-gray-500 mt-1">Download CSV reports. Both open directly in Excel, Google Sheets, or LibreOffice.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('super.reports.export.national') }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2 rounded shadow hover:bg-indigo-700 transition font-medium text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M4 12l8 8m0 0l8-8m-8 8V4" />
                    </svg>
                    State-Wise CSV
                </a>
                <a href="{{ route('super.reports.export.placements') }}"
                   class="inline-flex items-center gap-2 bg-green-600 text-white px-5 py-2 rounded shadow hover:bg-green-700 transition font-medium text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Placement Records CSV
                </a>
            </div>
        </div>
    </div>
@endsection
