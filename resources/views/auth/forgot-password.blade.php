<x-guest-layout>
    <div class="motion-reveal is-visible" data-motion="hero">
        <p class="cf-kicker">Password help</p>
        <h2 class="cf-heading mt-3 text-4xl">Reset your password.</h2>
        <p class="cf-help mt-4">
            Enter your email and we will send you a reset link.
        </p>
    </div>

    <div class="motion-reveal mt-6 rounded-[20px] border border-[var(--cf-border)] bg-[var(--cf-bg-soft)] px-5 py-4" data-motion="hero" data-motion-delay="110">
        <p class="text-sm font-semibold text-[var(--cf-ink)]">What happens next</p>
        <p class="cf-help mt-2">Open the email we send and follow the link to create a new password.</p>
    </div>

    <x-auth-session-status class="motion-reveal mt-6" :status="session('status')" data-motion="hero" data-motion-delay="140" />

    <form method="POST" action="{{ route('password.email') }}" class="motion-reveal mt-8 space-y-5" data-motion="hero" data-motion-delay="180">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="space-y-4 pt-2">
            <x-primary-button class="w-full">
                {{ __('Send reset link') }}
            </x-primary-button>

            <p class="text-center text-sm text-[var(--cf-muted)]">
                Remembered it?
                <a class="font-semibold text-[var(--cf-accent)] hover:text-[var(--cf-accent-deep)]" href="{{ route('login') }}">
                    Back to login
                </a>
            </p><br>
        </div>
    </form>
</x-guest-layout>
