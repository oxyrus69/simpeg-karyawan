@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg shadow-sm transition-colors duration-200'
            : 'flex items-center px-4 py-2.5 text-sm font-medium text-gray-400 rounded-lg hover:bg-gray-700 hover:text-white transition-colors duration-200 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @isset($icon)
    <span class="mr-3 text-gray-400 group-hover:text-gray-300 {{ ($active ?? false) ? 'text-white' : '' }}">
        {{ $icon }}
    </span>
    @endisset
    <span class="truncate">{{ $slot }}</span>
</a>