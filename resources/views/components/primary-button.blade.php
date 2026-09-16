<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center gap-2 px-4 py-2 bg-primary border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-light active:scale-[0.97] focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition duration-150']) }}>
    {{ $slot }}
</button>
