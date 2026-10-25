@extends('layouts.college-admin')
@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Company Blacklist</h1>
        <p class="text-gray-500">Block companies from recruiting on your campus.</p>
    </div>

    @if(session('success')) <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">{{ session('error') }}</div> @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="font-bold text-gray-800 mb-4 border-b pb-2">Blacklist a Company</h2>
            <form action="{{ route('college.blacklist.store') }}" method="POST">
                @csrf
                <select name="company_id" class="w-full border-gray-300 rounded-md mb-4" required>
                    <option value="">Select Company...</option>
                    @foreach($companies as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
                <textarea name="reason" placeholder="Reason for blacklisting (min 10 chars)" class="w-full border-gray-300 rounded-md mb-4" rows="2" required></textarea>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 w-full">Blacklist for My College</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b bg-gray-50"><h2 class="font-bold text-gray-800">Locally Blacklisted Companies</h2></div>
            <div class="overflow-x-auto w-full pb-4"><table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b"><tr><th class="p-3">Company</th><th class="p-3">Reason</th></tr></thead>
                <tbody class="divide-y">
                    @forelse($blacklisted as $bl)
                        <tr><td class="p-3 font-medium">{{ $bl->company->name }}</td><td class="p-3 text-red-600">{{ $bl->reason }}</td></tr>
                    @empty
                        <tr><td colspan="2" class="p-4 text-center text-gray-500">No companies blacklisted.</td></tr>
                    @endforelse
                </tbody>
            </table></div>
        </div>
    </div>
@endsection
