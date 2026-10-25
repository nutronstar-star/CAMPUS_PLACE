@extends('layouts.college-admin')
@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manage Students</h1>
            <p class="text-gray-500">View and update official academic records for your college.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
        <div class="overflow-x-auto w-full pb-4"><table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b text-sm text-gray-600 uppercase tracking-wider">
                    <th class="p-4 font-semibold">Student Name</th>
                    <th class="p-4 font-semibold">Dept & Enrollment</th>
                    <th class="p-4 font-semibold">CGPA</th>
                    <th class="p-4 font-semibold">Backlogs</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($students as $student)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 font-medium text-gray-900">{{ $student->user->name }}</td>
                    <td class="p-4 text-gray-700">
                        {{ $student->department->code }}<br>
                        <span class="text-sm text-gray-500">{{ $student->enrollment_no }}</span>
                    </td>
                    <td class="p-4 text-gray-700 font-bold">{{ $student->cgpa }}</td>
                    <td class="p-4 text-gray-700">{{ $student->backlogs }}</td>
                    <td class="p-4">
                        @if($student->status === 'placed')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Placed</span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Active</span>
                        @endif
                    </td>
                    <td class="p-4 text-right">
                        <a href="{{ route('college.students.edit', $student) }}" class="bg-sky-600 hover:bg-sky-700 text-white px-3 py-1 rounded text-sm transition">Edit Academic Data</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-8 text-center text-gray-500">No students found.</td></tr>
                @endforelse
            </tbody>
        </table></div>
    </div>
    <div class="mt-4">{{ $students->links() }}</div>
@endsection
