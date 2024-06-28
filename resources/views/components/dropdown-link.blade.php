@props(['hover_bg' => 'hover:bg-gray-800'])
<a
    {{ $attributes->merge(['class' => $hover_bg . ' block w-full px-4 py-2 text-start text-sm leading-5 text-gray-300 focus:outline-none focus:bg-gray-800 transition duration-150 ease-in-out']) }}>{{ $slot }}</a>
