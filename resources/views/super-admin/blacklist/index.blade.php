@extends('layouts.super-admin')
@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Global Blacklist</h1>
        <p class="text-gray-500">Manage fraudulent colleges and companies.</p>
    </div>

    @if(session('success')) <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">{{ session('error') }}</div> @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Blacklist College Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b bg-gray-50"><h2 class="font-bold text-gray-800">Blacklist a College</h2></div>
            <div class="p-6">
                <form action="{{ route('super.blacklist.colleges', 1) }}" method="POST" id="collegeForm" onsubmit="updateCollegeAction()">
                    @csrf
                    <select id="collegeSelect" class="w-full border-gray-300 rounded-md mb-4" required>
                        <option value="">Select Active College...</option>
                        @foreach(\App\Models\College::where('status', 'verified')->get() as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <textarea name="reason" placeholder="Reason for blacklisting (min 10 chars)" class="w-full border-gray-300 rounded-md mb-4" rows="2" required></textarea>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 w-full">Blacklist College</button>
                </form>
            </div>
            <!-- List -->
            <div class="border-t">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50"><tr><th class="p-3">College</th><th class="p-3">Reason</th></tr></thead>
                    <tbody class="divide-y">
                        @foreach($blacklistedColleges as $bl)
                            <tr><td class="p-3 font-medium">{{ $bl->college->name }}</td><td class="p-3 text-red-600">{{ $bl->reason }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Blacklist Company Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b bg-gray-50"><h2 class="font-bold text-gray-800">Nationally Blacklist a Company</h2></div>
            <div class="p-6">
                <form action="{{ route('super.blacklist.companies', 1) }}" method="POST" id="companyForm" onsubmit="updateCompanyAction()">
                    @csrf
                    <select id="companySelect" class="w-full border-gray-300 rounded-md mb-4" required>
                        <option value="">Select Approved Company...</option>
                        @foreach(\App\Models\Company::where('status', 'approved')->get() as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <textarea name="reason" placeholder="Reason for blacklisting (min 10 chars)" class="w-full border-gray-300 rounded-md mb-4" rows="2" required></textarea>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 w-full">Blacklist Company</button>
                </form>
            </div>
            <!-- List -->
            <div class="border-t">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50"><tr><th class="p-3">Company</th><th class="p-3">Reason</th></tr></thead>
                    <tbody class="divide-y">
                        @foreach($blacklistedCompanies as $bl)
                            <tr><td class="p-3 font-medium">{{ $bl->company->name }}</td><td class="p-3 text-red-600">{{ $bl->reason }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function updateCollegeAction() {
            const id = document.getElementById('collegeSelect').value;
            if(id) document.getElementById('collegeForm').action = `/super/blacklist/colleges/${id}`;
        }
        function updateCompanyAction() {
            const id = document.getElementById('companySelect').value;
            if(id) document.getElementById('companyForm').action = `/super/blacklist/companies/${id}`;
        }
    </script>
@endsection
