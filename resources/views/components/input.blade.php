@props(['disabled' => false, 'error' => false])

@php
$classes = 'shadow-theme-xs h-11 w-full rounded-lg border bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 ';
if ($error) {
    $classes .= 'border-error-300 focus:border-error-300 focus:ring-error-500/10 dark:border-error-700 dark:focus:border-error-800';
} else {
    $classes .= 'border-gray-300 focus:border-brand-300 focus:ring-brand-500/10 dark:border-gray-700 dark:focus:border-brand-800';
}
@endphp

@if($attributes->get('type') === 'password')
<div class="relative" x-data="{ show: false }">
    <input :type="show ? 'text' : 'password'" {{ $disabled ? 'disabled' : '' }} {!! $attributes->except('type')->merge(['class' => $classes . ' pr-11']) !!}>
    <button type="button" @click="show = !show" class="absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-hidden dark:text-gray-400">
        <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
        <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.51-3.14m2.164-2.164A9.97 9.97 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.06 10.06 0 01-2.16 3.14M15 12a3 3 0 01-3 3m-3-3a3 3 0 013-3m0 0L2 2l20 20" />
        </svg>
    </button>
</div>
@else
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => $classes]) !!}>
@endif
