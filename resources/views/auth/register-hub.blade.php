<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Join CampusPlace</h2>
        <p class="text-gray-500 text-sm">Select your role to get started</p>
    </div>
    <div class="space-y-4">
        <a href="{{ route('register.student') }}" class="block p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition">
            <h3 class="font-bold text-blue-900">I am a Student</h3>
            <p class="text-xs text-blue-700">Apply to jobs from your college.</p>
        </a>
        <a href="{{ route('register.company') }}" class="block p-4 bg-orange-50 border border-orange-200 rounded-lg hover:bg-orange-100 transition">
            <h3 class="font-bold text-orange-900">I am a Company</h3>
            <p class="text-xs text-orange-700">Post jobs and hire top talent.</p>
        </a>
        <a href="{{ route('register.college') }}" class="block p-4 bg-sky-50 border border-sky-200 rounded-lg hover:bg-sky-100 transition">
            <h3 class="font-bold text-sky-900">I am a College (TPO)</h3>
            <p class="text-xs text-sky-700">Register your college placement cell.</p>
        </a>
    </div>
</x-guest-layout>
