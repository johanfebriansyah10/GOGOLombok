<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-[#34C759] dark:bg-[#34C759] border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-[#2a9f47] dark:hover:bg-[#2a9f47] focus:bg-[#34C759] dark:focus:bg-{#34C759} active:bg-[#2a9f47] dark:active:bg-[#34C759] focus:outline-none focus:ring-2 focus:ring-[#34C759] focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
