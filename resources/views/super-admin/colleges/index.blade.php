@extends('layouts.super-admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">College Verification</h1>
            <p class="text-gray-500">Review and manage college registrations.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert"><p>{{ session('success') }}</p></div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert"><p>{{ session('error') }}</p></div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto w-full pb-4"><table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b text-sm text-gray-600 uppercase tracking-wider">
                    <th class="p-4 font-semibold">College Name</th>
                    <th class="p-4 font-semibold">State</th>
                    <th class="p-4 font-semibold">Status</th>
                    <th class="p-4 font-semibold">AICTE Document</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($colleges as $college)
                <tr class="hover:bg-gray-50">
                    <td class="p-4">
                        <div class="font-medium text-gray-900">{{ $college->name }}</div>
                        <div class="text-sm text-gray-500">{{ $college->email }} | Code: {{ $college->code }}</div>
                    </td>
                    <td class="p-4 text-gray-700">{{ $college->state->name ?? 'N/A' }}</td>
                    <td class="p-4">
                        @if($college->status === 'verified')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Verified</span>
                        @elseif($college->status === 'pending')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @elseif($college->status === 'rejected')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($college->status) }}</span>
                        @endif
                    </td>
                    <td class="p-4">
                        @php $doc = $college->aicteVerifications->first(); @endphp
                        @if($doc)
                            <a href="{{ asset('storage/' . $doc->certificate_url) }}" target="_blank" class="text-indigo-600 hover:underline text-sm font-medium bg-indigo-50 px-3 py-1 rounded">View PDF</a>
                        @else
                            <span class="text-xs text-gray-400">No Document</span>
                        @endif
                    </td>
                    <td class="p-4 text-right space-x-2">
                        @if($college->status === 'pending')
                            <form action="{{ route('super.colleges.approve', $college) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm transition">Approve</button>
                            </form>
                            <form action="{{ route('super.colleges.reject', $college) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">Reject</button>
                            </form>
                        @else
                            <span class="text-sm text-gray-400 italic">No actions available</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-8 text-center text-gray-500">No colleges found.</td></tr>
                @endforelse
            </tbody>
        </table></div>
    </div>
    <div class="mt-4">{{ $colleges->links() }}</div>
@endsection
