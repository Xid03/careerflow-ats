<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-3']) }}>
    <span class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-[18px] bg-white shadow-[0_18px_36px_rgba(30,52,66,0.18)] ring-1 ring-[var(--cf-border)]">
        <img
            src="{{ asset('images/logoicon.png') }}"
            alt="CareerFlow logo"
            class="h-full w-full object-cover"
        >
    </span>
    <span class="flex flex-col leading-none">
        <span class="font-display text-[1.1rem] font-semibold tracking-[-0.03em] text-[var(--cf-ink)]">CareerFlow</span>
        <span class="mt-1 text-[0.68rem] font-semibold uppercase tracking-[0.24em] text-[var(--cf-muted)]">Personal ATS</span>
    </span>
</div>
