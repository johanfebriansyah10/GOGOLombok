@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 text-lg font-large leading-5 text-gray-100 focus:outline-none transition duration-150 ease-in-out '
            : 'inline-flex items-center px-1 pt-1 text-lg font-medium leading-5 text-gray-100 dark:text-gray-300 hover:text-gray-400 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
