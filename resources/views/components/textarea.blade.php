@props(['disabled' => false])

<textarea @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full rounded-xl border-forest/20 bg-white text-ink shadow-sm placeholder:text-forest/35 focus:border-moss focus:ring-moss']) }}>{{ $slot }}</textarea>
