<x-guest-layout>
    <div class="motion-reveal is-visible" data-motion="hero">
        <p class="cf-kicker">Verify your email</p>
        <h2 class="cf-heading mt-3 text-4xl">Check your inbox.</h2>
        <p class="cf-help mt-4">
            We sent a verification link to your email. Open it to continue.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="motion-reveal mt-6 rounded-[18px] border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium leading-6 text-emerald-800" data-motion="hero" data-motion-delay="110">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="motion-reveal mt-6 rounded-[20px] border border-[var(--cf-border)] bg-[var(--cf-bg-soft)] px-5 py-4" data-motion="hero" data-motion-delay="130">
        <p class="text-sm font-semibold text-[var(--cf-ink)]">Did not get it?</p>
        <p class="cf-help mt-2">Check spam first, then resend the link below if needed.</p>
    </div>

    <div class="motion-reveal mt-8 flex flex-col gap-4" data-motion="hero" data-motion-delay="180">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf

            <div class="w-full">
                <x-primary-button class="w-full">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf

            <button type="submit" class="text-sm font-semibold text-[var(--cf-accent)] hover:text-[var(--cf-accent-deep)]">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
