<x-guest-layout>
    <div class="motion-reveal is-visible" data-motion="hero">
        <p class="cf-kicker">Welcome back</p>
        <h2 class="cf-heading mt-3 max-w-[11ch] text-3xl leading-[1.02] sm:text-4xl">Sign in to your workspace.</h2>
        <p class="cf-help mt-3 max-w-sm">
            Pick up where you left off and keep your job search moving.
        </p>
    </div>

    <x-auth-session-status class="mt-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="motion-reveal mt-7 space-y-4" data-motion="hero" data-motion-delay="140">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />

            <div x-data="{ show: false }" class="cf-password-wrap mt-2">
                <x-text-input id="password" class="block w-full"
                                x-bind:type="show ? 'text' : 'password'"
                                type="password"
                                name="password"
                                required autocomplete="current-password"
                                placeholder="Enter your password" />
                <button type="button" class="cf-password-toggle" x-on:click="show = !show" x-bind:aria-label="show ? 'Hide password' : 'Show password'">
                    <svg x-show="!show" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12Z" />
                        <circle cx="12" cy="12" r="3.25" />
                    </svg>
                    <svg x-show="show" x-cloak viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path d="M3 3l18 18" />
                        <path d="M10.6 5.4A10.6 10.6 0 0 1 12 5.25c6 0 9.75 6.75 9.75 6.75a18.8 18.8 0 0 1-3.18 3.95" />
                        <path d="M6.53 6.53C4.34 8.03 2.75 12 2.75 12s3.75 6.75 9.75 6.75c1.66 0 3.14-.39 4.45-1.02" />
                        <path d="M9.88 9.88A3 3 0 0 0 14.12 14.12" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4 pt-1">
            <label for="remember_me" class="inline-flex items-center gap-3 text-sm font-medium text-[var(--cf-muted)]">
                <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-[var(--cf-border-strong)] text-[var(--cf-accent)] focus:ring-[var(--cf-accent)]" name="remember">
                <span>{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-[var(--cf-accent)] hover:text-[var(--cf-accent-deep)]" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="space-y-3 pt-2">
            <x-primary-button class="w-full">
                {{ __('Log in') }}
            </x-primary-button>

            <p class="pt-1 text-center text-sm text-[var(--cf-muted)]">
                New here?
                <a class="font-semibold text-[var(--cf-accent)] hover:text-[var(--cf-accent-deep)]" href="{{ route('register') }}">
                    Create an account
                </a>
            </p><br>
        </div>
    </form>
</x-guest-layout>
