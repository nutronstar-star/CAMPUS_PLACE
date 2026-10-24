@extends('layouts.college-admin')
@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Academic Record</h1>
                <p class="text-gray-500">Student: <strong>{{ $student->user->name }}</strong> ({{ $student->enrollment_no }})</p>
            </div>
            <a href="{{ route('college.students.index') }}" class="text-sky-600 hover:text-sky-800 font-medium">&larr; Back to List</a>
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-8">
            <form action="{{ route('college.students.update', $student) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Official CGPA</label>
                        <input type="number" step="0.01" name="cgpa" value="{{ old('cgpa', $student->cgpa) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring-sky-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Active Backlogs</label>
                        <input type="number" name="backlogs" value="{{ old('backlogs', $student->backlogs) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring-sky-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Passing Year</label>
                        <input type="number" name="passing_year" value="{{ old('passing_year', $student->passing_year) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring-sky-500">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white font-medium py-2 px-6 rounded shadow transition">Save Official Record</button>
                </div>
            </form>
        </div>
    </div>
@endsection
