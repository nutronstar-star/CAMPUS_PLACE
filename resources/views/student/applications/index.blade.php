@extends('layouts.student')
@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">My Applications</h1>
        <p class="text-gray-500">Track your job applications, interviews, and offers.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm">{{ session('error') }}</div>
    @endif

    <!-- Active Offers Section -->
    @if($offers->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4">?? Action Required: Pending Offers</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($offers as $offer)
                <div class="bg-white border-2 border-green-500 rounded-lg shadow-sm p-6 relative">
                    <div class="absolute top-0 right-0 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">Offer Released</div>
                    <h3 class="text-lg font-bold text-gray-900">{{ $offer->job->title }}</h3>
                    <p class="text-sm text-gray-600 font-medium mb-4">{{ $offer->company->name }}</p>
                    
                    <div class="text-sm text-gray-600 space-y-1 mb-6">
                        <p><strong>Package:</strong> ?{{ number_format($offer->package) }} / annum</p>
                        <p><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($offer->acceptance_deadline)->format('d M Y') }}</p>
                    </div>

                    <div class="flex space-x-3">
                        <form action="{{ route('student.offers.respond', $offer) }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="action" value="accept">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 rounded shadow transition">Accept Offer</button>
                        </form>
                        <form action="{{ route('student.offers.respond', $offer) }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 rounded transition">Decline</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Application History Table -->
    <h2 class="text-lg font-bold text-gray-800 mb-4">Application History</h2>
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b text-sm text-gray-600 uppercase tracking-wider">
                    <th class="p-4 font-semibold">Company & Job</th>
                    <th class="p-4 font-semibold">Applied On</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold">Interview Details</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($applications as $app)
                <tr class="hover:bg-gray-50">
                    <td class="p-4">
                        <div class="font-medium text-gray-900">{{ $app->job->title }}</div>
                        <div class="text-sm text-gray-500">{{ $app->job->company->name }}</div>
                    </td>
                    <td class="p-4 text-gray-700">{{ $app->created_at->format('d M Y') }}</td>
                    <td class="p-4">
                        @if($app->status === 'applied')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Applied</span>
                        @elseif($app->status === 'shortlisted')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Shortlisted</span>
                        @elseif($app->status === 'interview')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Interview Scheduled</span>
                        @elseif($app->status === 'selected')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Selected</span>
                        @elseif($app->status === 'rejected')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($app->status) }}</span>
                        @endif
                    </td>
                    <td class="p-4">
                        @if($app->interviews->count() > 0)
                            @foreach($app->interviews as $interview)
                                <div class="text-sm text-gray-700 bg-gray-50 p-2 rounded border border-gray-200 mb-1">
                                    <strong>{{ $interview->mode === 'online' ? 'Online' : 'Offline' }}:</strong> 
                                    {{ \Carbon\Carbon::parse($interview->scheduled_at)->format('d M Y, h:i A') }}
                                    @if($interview->meeting_link) <br><a href="{{ $interview->meeting_link }}" target="_blank" class="text-blue-600 underline">Join Link</a> @endif
                                </div>
                            @endforeach
                        @else
                            <span class="text-sm text-gray-400">-</span>
                        @endif
                        @if(!in_array($app->status, ['withdrawn', 'selected', 'rejected']) && !\Carbon\Carbon::parse($app->job->deadline)->isPast())
                            <form action="{{ route('student.applications.withdraw', $app) }}" method="POST" class="mt-2 inline-block">
                                @csrf
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800 underline" onclick="return confirm('Are you sure you want to withdraw this application?')">Withdraw Application</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-8 text-center text-gray-500">You haven't applied to any jobs yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $applications->links() }}</div>
@endsection

