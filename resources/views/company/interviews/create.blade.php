@extends('layouts.company')
@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Schedule Interview</h1>
            <p class="text-gray-500">Candidate: <strong>{{ $application->student->user->name }}</strong> ({{ $application->job->title }})</p>
        </div>

        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-8">
            <form action="{{ route('company.interviews.store', $application) }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Interview Date & Time</label>
                    <input type="datetime-local" name="scheduled_at" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mode</label>
                    <select name="mode" id="mode" class="w-full border-gray-300 rounded-md shadow-sm" onchange="toggleLinkFields()">
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>

                <div class="mb-6" id="online_fields">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meeting Link (Google Meet / Zoom)</label>
                    <input type="url" name="meeting_link" placeholder="https://meet.google.com/..." class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-6 hidden" id="offline_fields">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Venue Address</label>
                    <input type="text" name="venue" placeholder="Company Office Address" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('company.jobs.applicants', $application->job_id) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-6 rounded transition">Cancel</a>
                    <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-6 rounded shadow transition">Send Invite</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleLinkFields() {
            const mode = document.getElementById('mode').value;
            document.getElementById('online_fields').classList.toggle('hidden', mode !== 'online');
            document.getElementById('offline_fields').classList.toggle('hidden', mode !== 'offline');
        }
    </script>
@endsection
