@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-md border-gray-300 shadow-sm transition focus:border-gray-900 focus:ring-gray-900']) }}>
