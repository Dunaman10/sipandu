@if ($paginator->hasPages())
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-wrap items-center gap-1.5">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}" class="flex h-9 w-9 cursor-not-allowed items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-300 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900 dark:text-gray-600">
                    <svg class="h-4 w-4 stroke-current" fill="none" viewBox="0 0 20 20">
                        <path d="M12.5 15L7.5 10L12.5 5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('pagination.previous') }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-600 shadow-theme-xs transition hover:bg-gray-50 hover:text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-200">
                    <svg class="h-4 w-4 stroke-current" fill="none" viewBox="0 0 20 20">
                        <path d="M12.5 15L7.5 10L12.5 5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span aria-disabled="true" class="flex h-9 min-w-9 items-center justify-center rounded-lg border border-gray-200 bg-white px-2.5 text-sm font-medium text-gray-500 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="flex h-9 min-w-9 items-center justify-center rounded-lg bg-brand-500 px-3 text-sm font-medium text-white shadow-theme-xs">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}" class="flex h-9 min-w-9 items-center justify-center rounded-lg border border-gray-200 bg-white px-3 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 hover:text-gray-900 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-white">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}" class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-600 shadow-theme-xs transition hover:bg-gray-50 hover:text-gray-800 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-200">
                    <svg class="h-4 w-4 stroke-current" fill="none" viewBox="0 0 20 20">
                        <path d="M7.5 15L12.5 10L7.5 5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}" class="flex h-9 w-9 cursor-not-allowed items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-300 shadow-theme-xs dark:border-gray-800 dark:bg-gray-900 dark:text-gray-600">
                    <svg class="h-4 w-4 stroke-current" fill="none" viewBox="0 0 20 20">
                        <path d="M7.5 15L12.5 10L7.5 5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            @endif
        </nav>

        <p class="text-theme-xs text-gray-500 dark:text-gray-400">
            Menampilkan <span class="font-medium text-gray-700 dark:text-gray-200">{{ $paginator->firstItem() ?? 0 }}</span>
            sampai <span class="font-medium text-gray-700 dark:text-gray-200">{{ $paginator->lastItem() ?? 0 }}</span>
            dari <span class="font-medium text-gray-700 dark:text-gray-200">{{ $paginator->total() }}</span> data
        </p>
    </div>
@endif
