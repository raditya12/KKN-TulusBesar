@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-2 mt-8">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 rounded-xl border border-outline-variant/30 text-on-surface-variant/50 bg-surface-container-lowest cursor-not-allowed font-label-md">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-4 py-2 rounded-xl border border-outline-variant/50 text-on-surface hover:bg-surface-variant hover:text-primary transition-colors font-label-md">Previous</a>
        @endif

        {{-- Pagination Elements --}}
        <div class="flex flex-wrap items-center justify-center gap-1 mx-2">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-3 py-2 text-on-surface-variant font-label-md">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm shadow-md">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="w-10 h-10 rounded-full border border-outline-variant/50 text-on-surface hover:bg-surface-variant hover:text-primary transition-colors flex items-center justify-center font-bold text-sm">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-4 py-2 rounded-xl border border-outline-variant/50 text-on-surface hover:bg-surface-variant hover:text-primary transition-colors font-label-md">Next</a>
        @else
            <span class="px-4 py-2 rounded-xl border border-outline-variant/30 text-on-surface-variant/50 bg-surface-container-lowest cursor-not-allowed font-label-md">Next</span>
        @endif
    </nav>
@endif
