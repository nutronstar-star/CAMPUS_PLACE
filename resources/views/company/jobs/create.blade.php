@extends('layouts.company')
@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Post a New Job</h1>
            <p class="text-gray-500">Create a listing and select which colleges can see it.</p>
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-8">
            <form action="{{ route('company.jobs.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                        <input type="text" name="title" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Job Type</label>
                        <select name="job_type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                            <option value="full_time">Full Time</option>
                            <option value="internship">Internship</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Min Package (?)</label>
                        <input type="number" name="package_min" required class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Package (?)</label>
                        <input type="number" name="package_max" required class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" name="location" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Application Deadline</label>
                        <input type="date" name="deadline" required class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Job Description</label>
                    <textarea name="description" rows="4" required class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 border-t pt-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Minimum CGPA</label>
                        <input type="number" step="0.1" name="cgpa" placeholder="e.g. 7.0" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Allowed Backlogs</label>
                        <input type="number" name="backlogs" placeholder="e.g. 0" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Colleges (Hold Ctrl/Cmd to select multiple)</label>
                    <select name="colleges[]" multiple required class="w-full border-gray-300 rounded-md shadow-sm h-32">
                        @foreach($colleges as $college)
                            <option value="{{ $college->id }}">{{ $college->name }} ({{ $college->state->name }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-6 rounded shadow transition">Publish Job</button>
                </div>
            </form>
        </div>
    </div>
@endsection

