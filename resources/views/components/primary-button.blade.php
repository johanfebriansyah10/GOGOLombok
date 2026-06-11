<button {{ $attributes->merge(['type' => 'submit', 'class' => 'flex-1 bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white font-bold py-2.5 px-4 rounded-lg transition-all duration-300 transform group-hover:shadow-lg text-sm uppercase tracking-wider']) }}>
    {{ $slot }}
</button>
