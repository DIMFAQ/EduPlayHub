@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" style="display:flex;justify-content:center;align-items:center;gap:10px;flex-wrap:wrap;margin-top:20px;color:var(--muted)">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span style="padding:0.65rem 1rem;border-radius:999px;border:1px solid var(--card-border);background:rgba(255,255,255,0.04);color:var(--muted);opacity:.5;display:inline-flex;align-items:center;gap:6px;">
            <span aria-hidden="true">‹</span>
            Previous
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="padding:0.65rem 1rem;border-radius:999px;border:1px solid var(--card-border);background:rgba(255,255,255,0.04);color:var(--text);text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:0.2s;">
            <span aria-hidden="true">‹</span>
            Previous
        </a>
    @endif

    <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;justify-content:center">
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span style="padding:0.45rem 0.2rem;color:var(--muted)">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" style="min-width:2.2rem;height:2.2rem;padding:0 0.75rem;border-radius:999px;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;display:inline-flex;align-items:center;justify-content:center;font-weight:700;box-shadow:0 8px 24px rgba(79,70,229,0.24)">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="min-width:2.2rem;height:2.2rem;padding:0 0.75rem;border-radius:999px;border:1px solid var(--card-border);background:rgba(255,255,255,0.04);color:var(--text);text-decoration:none;display:inline-flex;align-items:center;justify-content:center;transition:0.2s">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="padding:0.65rem 1rem;border-radius:999px;border:1px solid var(--card-border);background:rgba(255,255,255,0.04);color:var(--text);text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:0.2s;">
            Next
            <span aria-hidden="true">›</span>
        </a>
    @else
        <span style="padding:0.65rem 1rem;border-radius:999px;border:1px solid var(--card-border);background:rgba(255,255,255,0.04);color:var(--muted);opacity:.5;display:inline-flex;align-items:center;gap:6px;">
            Next
            <span aria-hidden="true">›</span>
        </span>
    @endif
</nav>
@endif
