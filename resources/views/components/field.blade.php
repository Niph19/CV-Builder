@props([
    'label',
    'for' => null,
    'error' => null,
    'required' => false,
])

<div {{ $attributes->only('class') }}>
    <label @if ($for) for="{{ $for }}" @endif class="mb-1.5 block text-sm font-medium text-forest">
        {{ $label }}@if ($required)<span class="text-clay"> *</span>@endif
    </label>

    {{ $slot }}

    @if ($error)
        <p class="mt-1.5 text-sm text-clay">{{ $error }}</p>
    @endif
</div>
