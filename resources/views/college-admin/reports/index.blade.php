@extends('layouts.college-admin')
@section('content')
    <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">College Placement Reports</h1>
            <p class="text-gray-500">Department-wise, company-wise, and package analytics for your college.</p>
        </div>
        <form method="GET" class="flex items-center gap-2">
            <label class="text-sm text-gray-600">Year:</label>
            <select name="year" onchange="this.form.submit()" class="border-gray-300 rounded-md text-sm">
                <option value="">All Years</option>
                @foreach($years as $y)
                    <option value="{{ $y }}" @selected($year == $y)>{{ $y }}</option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-sky-500">
            <p class="text-sm text-gray-500 font-medium">Total Students</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_students'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-emerald-500">
            <p class="text-sm text-gray-500 font-medium">Placed Students</p>
            <p class="text-3xl font-bold text-gray-800">{{ $stats['placed_students'] }}</p>
            <p class="text-xs text-emerald-600 mt-1">{{ $stats['placement_rate'] }}% placement rate</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-amber-500">
            <p class="text-sm text-gray-500 font-medium">Highest Package</p>
            <p class="text-2xl font-bold text-gray-800">₹{{ number_format($stats['highest_package']) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 border-l-4 border-indigo-500">
            <p class="text-sm text-gray-500 font-medium">Average / Median</p>
            <p class="text-xl font-bold text-gray-800">₹{{ number_format($stats['average_package']) }}</p>
            <p class="text-xs text-gray-500 mt-1">Median ₹{{ number_format($stats['median_package']) }}</p>
        </div>
    </div>

    {{-- Export buttons --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h3 class="font-bold text-gray-800">Export Reports</h3>
                <p class="text-sm text-gray-500 mt-1">Download CSV files. Open directly in Excel, Google Sheets, or LibreOffice.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('college.reports.export', ['year' => $year]) }}"
                   class="inline-flex items-center gap-2 bg-sky-600 text-white px-5 py-2 rounded shadow hover:bg-sky-700 transition font-medium text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M4 12l8 8m0 0l8-8m-8 8V4" />
                    </svg>
                    Placement Records CSV
                </a>
                <a href="{{ route('college.reports.export-departments', ['year' => $year]) }}"
                   class="inline-flex items-center gap-2 bg-emerald-600 text-white px-5 py-2 rounded shadow hover:bg-emerald-700 transition font-medium text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Department Summary CSV
                </a>
            </div>
        </div>
    </div>

    {{-- Department-wise + Company-wise --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="font-bold text-gray-800">Department-wise Placement</h2>
            </div>
            <div class="overflow-x-auto w-full pb-4"><table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="p-3 font-semibold">Department</th>
                        <th class="p-3 font-semibold text-right">Students</th>
                        <th class="p-3 font-semibold text-right">Placed</th>
                        <th class="p-3 font-semibold text-right">Rate</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($deptStats as $d)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-medium text-gray-900">{{ $d['name'] }} <span class="text-xs text-gray-500">({{ $d['code'] }})</span></td>
                            <td class="p-3 text-right text-gray-700">{{ $d['total'] }}</td>
                            <td class="p-3 text-right text-gray-900 font-bold">{{ $d['placed'] }}</td>
                            <td class="p-3 text-right">
                                <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $d['rate'] >= 50 ? 'bg-emerald-100 text-emerald-800' : ($d['rate'] > 0 ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-600') }}">
                                    {{ $d['rate'] }}%
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-6 text-center text-gray-500">No departments</td></tr>
                    @endforelse
                </tbody>
            </table></div>
        </div>

        <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="font-bold text-gray-800">Company-wise Hiring</h2>
            </div>
            <div class="overflow-x-auto w-full pb-4"><table class="w-full text-left border-collapse text-sm">
                <thead class="bg-gray-50 border-b text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="p-3 font-semibold">Company</th>
                        <th class="p-3 font-semibold text-right">Hires</th>
                        <th class="p-3 font-semibold text-right">Avg Package</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($companyStats as $c)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-medium text-gray-900">{{ $c['name'] }}</td>
                            <td class="p-3 text-right text-gray-900 font-bold">{{ $c['hires'] }}</td>
                            <td class="p-3 text-right text-gray-700">₹{{ number_format($c['avg_package']) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="p-6 text-center text-gray-500">No hiring yet</td></tr>
                    @endforelse
                </tbody>
            </table></div>
        </div>
    </div>

    {{-- Placement records --}}
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
        <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
            <h2 class="font-bold text-gray-800">Placement Records</h2>
            <span class="text-xs text-gray-500">{{ $placements->count() }} record{{ $placements->count() === 1 ? '' : 's' }}</span>
        </div>
        <div class="overflow-x-auto w-full pb-4"><table class="w-full text-left border-collapse text-sm">
            <thead class="bg-gray-50 border-b text-gray-600 uppercase tracking-wider">
                <tr>
                    <th class="p-3 font-semibold">Student</th>
                    <th class="p-3 font-semibold">Dept</th>
                    <th class="p-3 font-semibold">Company</th>
                    <th class="p-3 font-semibold">Job</th>
                    <th class="p-3 font-semibold text-right">Package</th>
                    <th class="p-3 font-semibold text-right">Year</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($placements as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3">
                            <div class="font-medium text-gray-900">{{ $p->student->user->name ?? '—' }}</div>
                            <div class="text-xs text-gray-500">{{ $p->student->enrollment_no ?? '' }}</div>
                        </td>
                        <td class="p-3 text-gray-700">{{ $p->student->department->code ?? '—' }}</td>
                        <td class="p-3 text-gray-700">{{ $p->company->name ?? '—' }}</td>
                        <td class="p-3 text-gray-700">{{ $p->job->title ?? '—' }}</td>
                        <td class="p-3 text-right font-semibold text-gray-900">₹{{ number_format($p->package) }}</td>
                        <td class="p-3 text-right text-gray-600">{{ $p->placement_year }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">
                            No placement records yet. Records appear automatically when a student accepts an offer.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table></div>
    </div>
@endsection