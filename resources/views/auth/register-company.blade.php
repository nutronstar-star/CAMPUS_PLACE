<x-guest-layout>
    <form method="POST" action="{{ url('/register/company') }}">
        @csrf
        <h2 class="text-xl font-bold mb-4 text-gray-800">Company Registration</h2>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="company_name" value="Company Name" />
                <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" required />
            </div>
            <div>
                <x-input-label for="industry" value="Industry (e.g., IT, Finance)" />
                <x-text-input id="industry" class="block mt-1 w-full" type="text" name="industry" required />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="hr_name" value="HR Contact Name" />
                <x-text-input id="hr_name" class="block mt-1 w-full" type="text" name="hr_name" required />
            </div>
            <div>
                <x-input-label for="hr_phone" value="HR Phone" />
                <x-text-input id="hr_phone" class="block mt-1 w-full" type="text" name="hr_phone" required />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="name" value="Login Name (Your Name)" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required />
            </div>
            <div>
                <x-input-label for="email" value="Company Email" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>
            <div>
                <x-input-label for="password_confirmation" value="Confirm Password" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            </div>
        </div>

        <div class="mb-6">
            <label class="inline-flex items-center">
                <input type="checkbox" name="dpdp_consent" class="rounded border-gray-300 text-indigo-600 shadow-sm" required>
                <span class="ms-2 text-sm text-gray-600">I consent to the DPDP Act 2023 data collection policy.</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-orange-600 text-white py-2 rounded shadow hover:bg-orange-700">Register as Company</button>
    </form>
</x-guest-layout>
