@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-2xl border border-[rgba(15,118,110,0.12)] bg-[rgba(15,118,110,0.12)] px-4 py-3 text-start text-base font-semibold text-[var(--cf-accent-deep)]'
            : 'block w-full rounded-2xl px-4 py-3 text-start text-base font-medium text-[var(--cf-ink)] hover:bg-[var(--cf-bg-soft)]';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
