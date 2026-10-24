<x-guest-layout>
    <form method="POST" action="{{ url('/register/college') }}" enctype="multipart/form-data">
        @csrf
        <h2 class="text-xl font-bold mb-4 text-gray-800">College Registration (TPO)</h2>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="college_name" value="College Name" />
                <x-text-input id="college_name" class="block mt-1 w-full" type="text" name="college_name" required />
            </div>
            <div>
                <x-input-label for="college_code" value="AICTE/UGC Code" />
                <x-text-input id="college_code" class="block mt-1 w-full" type="text" name="college_code" required />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="state_id" value="State" />
                <select name="state_id" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Select State...</option>
                    @foreach($states as $s) <option value="{{ $s->id }}">{{ $s->name }}</option> @endforeach
                </select>
            </div>
            <div>
                <x-input-label for="city" value="City" />
                <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" required />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="tpo_name" value="TPO Name" />
                <x-text-input id="tpo_name" class="block mt-1 w-full" type="text" name="tpo_name" required />
            </div>
            <div>
                <x-input-label for="name" value="Login Name" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="email" value="Official Email" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required />
            </div>
            <div>
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>
        </div>

        <div class="mb-6">
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
        </div>

                <div class="mb-6">
            <x-input-label for="aicte_certificate" value="Upload AICTE/UGC Certificate (PDF only, max 5MB)" />
            <input id="aicte_certificate" type="file" name="aicte_certificate" accept=".pdf" required class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
        </div>

        <button type="submit" class="w-full bg-sky-600 text-white py-2 rounded shadow hover:bg-sky-700">Apply for Verification</button>
    </form>
</x-guest-layout>

