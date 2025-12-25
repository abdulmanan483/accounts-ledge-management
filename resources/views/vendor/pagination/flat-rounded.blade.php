@if ($paginator->hasPages())
<nav class="d-flex justify-content-start mx-3 my-3">
    <ul class="pagination">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link border-0 border-0 rounded-start-pill">←</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link border-0 border-0 rounded-start-pill" href="{{ $paginator->previousPageUrl() }}" rel="prev">←</a>
            </li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link border-0">{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active " aria-current="page">
                            <span class="page-link rounded border-0">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item"><a class="page-link border-0" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link border-0 border-0 rounded-end-pill" href="{{ $paginator->nextPageUrl() }}" rel="next">→</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link border-0 border-0 rounded-end-pill">→</span>
            </li>
        @endif
    </ul>
</nav>
@endif
