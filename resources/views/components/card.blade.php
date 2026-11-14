@props(['title' => null, 'description' => null])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3 overflow-hidden']) }}>
    @if($title || isset($header))
        <div class="flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 sm:py-5 border-b border-gray-100 dark:border-gray-800">
            <div>
                @if($title)
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">{{ $title }}</h3>
                @endif
                @if($description)
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $description }}</p>
                @endif
            </div>
            @if(isset($headerActions))
                <div class="flex items-center gap-3">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
    @endif

    <div class="p-5 sm:p-6">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="flex items-center justify-end gap-3 border-t border-gray-100 px-5 py-4 sm:px-6 dark:border-gray-800">
            {{ $footer }}
        </div>
    @endif
</div>
