<x-guest-layout>
    <form method="POST" action="{{ url('/register/student') }}">
        @csrf
        <h2 class="text-xl font-bold mb-4 text-gray-800">Student Registration</h2>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-sm text-red-700">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="name" value="Full Name" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
            </div>
            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="college_id" value="College" />
                <select name="college_id" id="college_id" required
                        class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                        onchange="filterDepartments()">
                    <option value="">Select College...</option>
                    @foreach($colleges as $c)
                        <option value="{{ $c->id }}" @selected(old('college_id') == $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <x-input-label for="department_id" value="Department" />
                <select name="department_id" id="department_id" required
                        class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Select college first...</option>
                    @foreach($colleges as $c)
                        @foreach($c->departments as $d)
                            <option value="{{ $d->id }}" data-college="{{ $c->id }}" @selected(old('department_id') == $d->id)>
                                {{ $d->name }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-4">
            <x-input-label for="enrollment_no" value="Enrollment Number" />
            <x-text-input id="enrollment_no" class="block mt-1 w-full" type="text" name="enrollment_no" :value="old('enrollment_no')" required />
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="password" value="Password" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                <p class="text-xs text-gray-500 mt-1">Min 6 chars, 1 uppercase, 1 number</p>
            </div>
            <div>
                <x-input-label for="password_confirmation" value="Confirm Password" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            </div>
        </div>

        <div class="mb-6">
            <label class="inline-flex items-start">
                <input type="checkbox" name="dpdp_consent" class="rounded border-gray-300 text-indigo-600 shadow-sm mt-1" required>
                <span class="ms-2 text-sm text-gray-600">
                    I consent to the collection and processing of my personal data in accordance with the DPDP Act, 2023.
                </span>
            </label>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded shadow hover:bg-blue-700">Register as Student</button>
    </form>

    <script>
        function filterDepartments() {
            const collegeId = document.getElementById('college_id').value;
            const deptSelect = document.getElementById('department_id');
            const options = deptSelect.querySelectorAll('option[data-college]');

            options.forEach(opt => {
                opt.hidden = (opt.dataset.college !== collegeId);
            });

            const placeholder = deptSelect.querySelector('option[value=""]');
            if (placeholder) {
                placeholder.textContent = collegeId ? 'Select Department...' : 'Select college first...';
            }

            const selected = deptSelect.options[deptSelect.selectedIndex];
            if (selected && selected.dataset.college && selected.dataset.college !== collegeId) {
                deptSelect.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            filterDepartments();
            const collegeId = document.getElementById('college_id').value;
            const oldDept = "{{ old('department_id') }}";
            if (collegeId && oldDept) {
                const deptSelect = document.getElementById('department_id');
                const opt = deptSelect.querySelector('option[value="' + oldDept + '"]');
                if (opt && !opt.hidden) deptSelect.value = oldDept;
            }
        });
    </script>
</x-guest-layout>