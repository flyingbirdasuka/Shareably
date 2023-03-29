@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 border-indigo-400 text-indigo-700 bg-indigo-50 hover:bg-gray-100 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
