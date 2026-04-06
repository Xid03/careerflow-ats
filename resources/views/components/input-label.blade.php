@props(['value'])

<label {{ $attributes->merge(['class' => 'cf-label']) }}>
    {{ $value ?? $slot }}
</label>
