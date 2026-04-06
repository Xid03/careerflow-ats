<button {{ $attributes->merge(['type' => 'button', 'class' => 'cf-button-secondary disabled:opacity-25']) }}>
    {{ $slot }}
</button>
