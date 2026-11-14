@props(['variant' => 'primary'])

@php
    $classes = 'shadow-theme-xs inline-flex items-center justify-center gap-2 rounded-lg px-4 py-2.5 text-sm font-medium transition focus:outline-hidden ';
    
    if ($variant === 'primary') {
        $classes .= 'bg-brand-500 text-white hover:bg-brand-600';
    } elseif ($variant === 'secondary') {
        $classes .= 'border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/3 dark:hover:text-gray-200';
    } elseif ($variant === 'danger') {
        $classes .= 'bg-error-500 text-white hover:bg-error-600';
    } elseif ($variant === 'success') {
        $classes .= 'bg-success-500 text-white hover:bg-success-600';
    }
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => $classes]) }}>
    {{ $slot }}
</button>
