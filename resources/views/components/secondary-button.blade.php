<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/5 transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500/40 disabled:opacity-50']) }}>
    {{ $slot }}
</button>
