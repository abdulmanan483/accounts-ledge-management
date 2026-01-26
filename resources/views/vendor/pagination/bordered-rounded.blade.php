@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between" style="padding-left: 10px; padding-right: 10px; padding-bottom: 10px;">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination" style="padding-left: 10px; padding-right: 10px; padding-bottom: 10px;">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <a href="#" class="page-link rounded-start-pill">←</a>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link rounded-start-pill" href="{{ $paginator->previousPageUrl() }}" rel="prev">←</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><a href="#" class="page-link">{{ $element }}</a></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><a href="#" class="page-link">{{ $page }}</a></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link rounded-end-pill" href="{{ $paginator->nextPageUrl() }}" rel="next">→</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <a href="#" class="page-link rounded-end-pill">→</a>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <div>
                <p>
                    {!! __('Showing') !!}
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    {!! __('of') !!}
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <ul class="pagination" style="padding-left: 10px; padding-right: 10px; padding-bottom: 10px;">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                            <a href="#" class="page-link rounded-start-pill" aria-hidden="true">←</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link rounded-start-pill" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">←</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><a href="#" class="page-link">{{ $element }}</a></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><a href="#" class="page-link">{{ $page }}</a></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link rounded-end-pill" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">→</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                            <a href="#" class="page-link rounded-end-pill" aria-hidden="true">→</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
