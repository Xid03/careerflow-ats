@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-[18px] border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium leading-6 text-emerald-800']) }}>
        {{ $status }}
    </div>
@endif
