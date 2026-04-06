@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center rounded-2xl border border-[rgba(15,118,110,0.12)] bg-[rgba(15,118,110,0.12)] px-4 py-2.5 text-sm font-semibold text-[var(--cf-accent-deep)]'
            : 'inline-flex items-center rounded-2xl px-4 py-2.5 text-sm font-medium text-[var(--cf-muted)] hover:bg-[var(--cf-bg-soft)] hover:text-[var(--cf-ink)]';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
