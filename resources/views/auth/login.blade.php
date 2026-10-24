<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Quick Evaluator Login -->
    <div class="mb-8 p-4 bg-indigo-50 border border-indigo-200 rounded-lg shadow-sm">
        <h3 class="text-center text-sm font-bold text-indigo-900 mb-3 uppercase tracking-wide">Quick Demo Login (For Evaluators)</h3>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('demo.login', 'super_admin') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-center text-sm font-medium py-2 rounded transition shadow-sm">Super Admin</a>
            <a href="{{ route('demo.login', 'college_admin') }}" class="bg-sky-600 hover:bg-sky-700 text-white text-center text-sm font-medium py-2 rounded transition shadow-sm">College Admin</a>
            <a href="{{ route('demo.login', 'student') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-center text-sm font-medium py-2 rounded transition shadow-sm">Student</a>
            <a href="{{ route('demo.login', 'company') }}" class="bg-orange-600 hover:bg-orange-700 text-white text-center text-sm font-medium py-2 rounded transition shadow-sm">Company</a>
        </div>
        <div class="relative flex py-4 items-center">
            <div class="flex-grow border-t border-indigo-200"></div>
            <span class="flex-shrink-0 mx-4 text-indigo-400 text-xs">Or login manually</span>
            <div class="flex-grow border-t border-indigo-200"></div>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Registration Link -->
    <div class="mt-8 pt-6 border-t border-gray-200 text-center">
        <p class="text-sm text-gray-600 mb-4">Don't have an account yet?</p>
        <a href="{{ route('register') }}" class="w-full inline-block bg-slate-800 hover:bg-slate-900 text-white font-medium py-2 px-4 rounded-md shadow transition">
            Create a New Account
        </a>
    </div>
</x-guest-layout>
