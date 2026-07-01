@if ($paginator->hasPages())
    <div style="display: flex; justify-content: center; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
        
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="btn btn-outline" style="opacity: 0.5; cursor: not-allowed; border-radius: 9999px; font-size: 0.9rem; padding: 0.6rem 1.5rem; border: 2px solid var(--brand-dark); color: var(--brand-dark);">
                &laquo; Prev
            </span>
        @else
            <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" class="btn btn-outline" style="border-radius: 9999px; font-size: 0.9rem; padding: 0.6rem 1.5rem; cursor: pointer; border: 2px solid var(--brand-dark); color: var(--brand-dark); background: transparent;">
                &laquo; Prev
            </button>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span style="padding: 0.6rem 1rem; color: var(--brand-dark); font-weight: bold;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="btn btn-gold" style="border-radius: 9999px; font-size: 0.9rem; padding: 0.6rem 1rem; cursor: default;">
                            {{ $page }}
                        </span>
                    @else
                        <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" class="btn btn-outline" style="border-radius: 9999px; font-size: 0.9rem; padding: 0.6rem 1rem; cursor: pointer; border: 2px solid var(--brand-dark); color: var(--brand-dark); background: transparent;">
                            {{ $page }}
                        </button>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" class="btn btn-outline" style="border-radius: 9999px; font-size: 0.9rem; padding: 0.6rem 1.5rem; cursor: pointer; border: 2px solid var(--brand-dark); color: var(--brand-dark); background: transparent;">
                Next &raquo;
            </button>
        @else
            <span class="btn btn-outline" style="opacity: 0.5; cursor: not-allowed; border-radius: 9999px; font-size: 0.9rem; padding: 0.6rem 1.5rem; border: 2px solid var(--brand-dark); color: var(--brand-dark);">
                Next &raquo;
            </span>
        @endif
    </div>
@endif
