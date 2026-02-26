<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-semibold transition-all hover:shadow-lg hover:shadow-red-500/30 focus:outline-none focus:ring-2 focus:ring-red-500/40']) }}>
    {{ $slot }}
</button>
