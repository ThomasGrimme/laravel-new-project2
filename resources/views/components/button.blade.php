@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'submit',
])

@php
    $sizes = [
        'sm' => 'px-2.5 py-1.5 text-xs',
        'md' => 'px-3.5 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-sm',
    ];

    $variants = [
        'primary' => 'bg-gray-900 text-white hover:bg-gray-700',
        'secondary' => 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50',
        'ghost' => 'text-gray-600 hover:text-gray-900 hover:bg-gray-100',
        'danger' => 'bg-red-600 text-white hover:bg-red-500',
        'danger-ghost' => 'text-red-600 hover:text-red-700 hover:bg-red-50',
    ];

    $classes = implode(' ', [
        'inline-flex items-center justify-center gap-2 rounded-md font-medium whitespace-nowrap',
        'transition-colors duration-150 select-none',
        'focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-900 focus-visible:ring-offset-2',
        'disabled:opacity-50 disabled:pointer-events-none',
        $sizes[$size] ?? $sizes['md'],
        $variants[$variant] ?? $variants['primary'],
    ]);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}>{{ $slot }}</button>
@endif
