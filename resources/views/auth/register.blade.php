<x-guest-layout>
    <div class="motion-reveal is-visible mb-5 flex justify-center" data-motion="hero">
        <a href="{{ route('login') }}" class="inline-flex">
            <x-application-logo />
        </a>
    </div>

    <div class="motion-reveal is-visible" data-motion="hero">
        <p class="cf-kicker">Create your workspace</p>
        <h2 class="cf-heading mt-3 max-w-[11ch] text-3xl leading-[1.02] sm:text-4xl">Create your account.</h2>
        <p class="cf-help mt-3 max-w-sm">
            Start tracking applications, interviews, and reminders in one simple workspace.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="motion-reveal mt-7 space-y-4" data-motion="hero" data-motion-delay="120">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="mt-2 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Your full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />

            <div x-data="{ show: false }" class="cf-password-wrap mt-2">
                <x-text-input id="password" class="block w-full"
                                x-bind:type="show ? 'text' : 'password'"
                                type="password"
                                name="password"
                                required autocomplete="new-password"
                                placeholder="Create a secure password" />
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

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <div x-data="{ show: false }" class="cf-password-wrap mt-2">
                <x-text-input id="password_confirmation" class="block w-full"
                                x-bind:type="show ? 'text' : 'password'"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="Repeat your password" />
                <button type="button" class="cf-password-toggle" x-on:click="show = !show" x-bind:aria-label="show ? 'Hide password confirmation' : 'Show password confirmation'">
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

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="space-y-3 pt-2">
            <x-primary-button class="w-full">
                {{ __('Create account') }}
            </x-primary-button>

            <p class="pt-1 text-center text-sm text-[var(--cf-muted)]">
                Already registered?
                <a class="font-semibold text-[var(--cf-accent)] hover:text-[var(--cf-accent-deep)]" href="{{ route('login') }}">
                    Log in
                </a>
            </p><br>
        </div>
    </form>
</x-guest-layout>
