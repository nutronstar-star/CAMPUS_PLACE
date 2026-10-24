<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $email = (string) $this->string('email');
        $ip = (string) $this->ip();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            // FIX: log failed attempt to login_attempts table
            $this->recordAttempt($email, $ip, false);

            RateLimiter::hit($this->throttleKey(), 900);

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        if (Auth::user()->status === 'suspended' || Auth::user()->status === 'blacklisted') {
            $this->recordAttempt($email, $ip, false); // they can't actually access
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Your account has been suspended or blacklisted. Please contact support.',
            ]);
        }

        if (Auth::user()->role === 'college_admin') {
            $profile = Auth::user()->collegeAdminProfile;
            if (! $profile) {
                $this->recordAttempt($email, $ip, false); // pending approval = no access
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Your college registration is still pending Super Admin approval.',
                ]);
            }
        }

        // FIX: log successful attempt
        $this->recordAttempt($email, $ip, true);

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }

    /**
     * Insert a row into the login_attempts audit table.
     */
    private function recordAttempt(string $email, string $ip, bool $success): void
    {
        try {
            DB::table('login_attempts')->insert([
                'email' => $email,
                'ip_address' => $ip,
                'success' => $success,
                'attempted_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Never let audit logging break login
            \Log::warning('login_attempts insert failed: ' . $e->getMessage());
        }
    }
}