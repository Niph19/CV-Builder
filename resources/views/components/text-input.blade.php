@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-forest/25 bg-white text-ink focus:border-moss focus:ring-moss rounded-lg shadow-sm']) }}>
