@extends('layouts.college-admin')
@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Send Announcement</h1>
            <p class="text-gray-500">Send a notification to all registered students in your college.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">{{ session('success') }}</div>
        @endif

        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-8">
            <form action="{{ route('college.notifications.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notification Title</label>
                    <input type="text" name="title" required placeholder="e.g., Google Placement Drive" class="w-full border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring-sky-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                    <textarea name="message" rows="5" required placeholder="Type your announcement here..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-sky-500 focus:ring-sky-500"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-sky-600 hover:bg-sky-700 text-white font-medium py-2 px-6 rounded shadow transition">Send to All Students</button>
                </div>
            </form>
        </div>
    </div>
@endsection