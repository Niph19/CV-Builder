<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-lg border border-transparent bg-moss px-5 py-2.5 text-sm font-semibold text-white transition duration-150 ease-in-out hover:bg-forest focus:outline-none focus:ring-2 focus:ring-mint focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
