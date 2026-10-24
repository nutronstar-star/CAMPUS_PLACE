@extends('layouts.student')
@section('content')
    <div class="max-w-5xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">My Profile</h1>
            <p class="text-gray-500">Update your skills and resume. Academic details are locked by your TPO.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm">
                <ul class="list-disc ml-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Left Column: Basic Info & Resume -->
            <div class="space-y-6">
                <!-- Academic Info Card (Read-Only) -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Academic Info <span class="text-xs font-normal text-gray-400 ml-2">(Locked)</span></h2>
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-gray-500 block">College</span>
                            <span class="font-medium text-gray-900">{{ $student->college->name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block">Department</span>
                            <span class="font-medium text-gray-900">{{ $student->department->name }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <span class="text-gray-500 block">CGPA</span>
                                <span class="font-bold text-gray-900 text-lg">{{ $student->cgpa }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 block">Backlogs</span>
                                <span class="font-bold text-gray-900 text-lg">{{ $student->backlogs }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resume Card -->
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Resume</h2>
                    
                    @php $activeResume = $student->resumes->where('is_default', true)->first(); @endphp
                    
                    @if($activeResume)
                        <div class="bg-blue-50 text-blue-800 p-3 rounded text-sm mb-4 flex justify-between items-center border border-blue-100">
                            <span>Resume v{{ $activeResume->version }} uploaded</span>
                            <a href="{{ asset('storage/' . $activeResume->resume_url) }}" target="_blank" class="underline font-medium hover:text-blue-900">View</a>
                        </div>
                    @else
                        <div class="bg-yellow-50 text-yellow-800 p-3 rounded text-sm mb-4 border border-yellow-100">
                            No resume uploaded yet.
                        </div>
                    @endif

                    <form action="{{ route('student.profile.resume') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload New Resume (PDF)</label>
                        <input type="file" name="resume" accept=".pdf" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 mb-3">
                        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-medium py-2 rounded shadow transition text-sm">Upload Resume</button>
                    </form>
                </div>
            </div>

            <!-- Right Column: Edit Form -->
            <div class="md:col-span-2">
                <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-8">
                    <h2 class="text-lg font-bold text-gray-800 mb-6 border-b pb-2">Edit Personal Details</h2>
                    <form action="{{ route('student.profile.update') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Skills (Comma separated)</label>
                            @php $skillsString = $student->skills ? implode(', ', $student->skills) : ''; @endphp
                            <input type="text" name="skills" value="{{ old('skills', $skillsString) }}" placeholder="e.g. Python, Java, React, SQL" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bio / Short Introduction</label>
                            <textarea name="bio" rows="6" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tell companies about yourself...">{{ old('bio', $student->bio) }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded shadow transition">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
