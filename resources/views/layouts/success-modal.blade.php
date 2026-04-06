@php
    $successModal = session('success_modal');
    if (! $successModal && session('status')) {
        $successModal = [
            'label' => 'Success',
            'title' => 'Action completed.',
            'message' => session('status'),
            'button' => 'Continue',
            'duration' => 3000,
        ];
    }
    $successDuration = (int) ($successModal['duration'] ?? 3200);
@endphp

@if ($successModal)
    <div
        x-data="{ show: true }"
        x-cloak
        x-init="
            document.body.classList.add('overflow-hidden');
            setTimeout(() => { show = false }, {{ $successDuration }});
        "
        x-effect="document.body.classList.toggle('overflow-hidden', show)"
        x-show="show"
        x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-220"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="cf-success-overlay"
        role="dialog"
        aria-modal="true"
        aria-labelledby="cf-success-title"
    >
        <div class="absolute inset-0" @click="show = false"></div>

        <div
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-[0.96]"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-220"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-3 scale-[0.97]"
            class="cf-panel cf-success-card"
        >
            <button type="button" class="cf-modal-close" @click="show = false" aria-label="Close success message">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="M6 6l12 12" />
                    <path d="M18 6l-12 12" />
                </svg>
            </button>

            <div class="cf-success-glow">
                <svg class="cf-success-timer" viewBox="0 0 44 44" aria-hidden="true">
                    <circle class="cf-success-timer-track" cx="22" cy="22" r="18" pathLength="100"></circle>
                    <circle
                        class="cf-success-timer-progress"
                        cx="22"
                        cy="22"
                        r="18"
                        pathLength="100"
                        style="animation-duration: {{ $successDuration }}ms;"
                    ></circle>
                </svg>
                <span class="cf-success-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path d="M5.5 12.5l4.2 4.2L18.5 8.8" />
                    </svg>
                </span>
            </div>

            <p class="cf-kicker mt-8">{{ $successModal['label'] ?? 'Success' }}</p>
            <h2 id="cf-success-title" class="cf-heading mt-3 text-3xl sm:text-4xl">
                {{ $successModal['title'] ?? 'Done successfully.' }}
            </h2>
            <p class="cf-help mx-auto mt-4 max-w-md">
                {{ $successModal['message'] ?? session('status') }}
            </p>
            <p class="mt-3 text-xs font-semibold uppercase tracking-[0.22em] text-[var(--cf-muted)]">
                Closes automatically in a few seconds
            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                <button type="button" class="cf-button-primary" @click="show = false">
                    {{ $successModal['button'] ?? 'Continue' }}
                </button>
            </div>
        </div>
    </div>
@endif
