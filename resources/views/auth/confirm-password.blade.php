<x-guest-layout>
    <div class="motion-reveal is-visible" data-motion="hero">
        <p class="cf-kicker">Security check</p>
        <h2 class="cf-heading mt-3 text-4xl">Confirm your password.</h2>
        <p class="cf-help mt-4">
            This helps keep your account secure before a sensitive action.
        </p>
    </div>

    <div class="motion-reveal mt-6 rounded-[20px] border border-[var(--cf-border)] bg-[var(--cf-bg-soft)] px-5 py-4" data-motion="hero" data-motion-delay="110">
        <p class="text-sm font-semibold text-[var(--cf-ink)]">Security reminder</p>
        <p class="cf-help mt-2">Only continue if this is your device and your account session.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="motion-reveal mt-8 space-y-5" data-motion="hero" data-motion-delay="170">
        @csrf

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

        <div class="pt-2">
            <x-primary-button class="w-full">
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
