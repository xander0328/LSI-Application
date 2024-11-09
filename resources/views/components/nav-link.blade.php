@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'group dark:text-white text-black flex items-center rounded-lg p-2 hover:bg-sky-100 bg-sky-300 dark:bg-sky-600'
            : 'group flex items-center rounded-lg p-2 text-gray-900 hover:bg-sky-100 dark:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
