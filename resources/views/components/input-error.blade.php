@props(['messages'])

@if ($messages)
    <ul
        {{ $attributes->merge(['class' => 'text-sm text-red-400 bg-gray-700 p-3 rounded-md dark:text-red-400 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
