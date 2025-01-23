@if ($paginator->hasPages())
    <div class="pagination">
        @if (!$paginator->onFirstPage())
            <a href="{{ $paginator->previousPageUrl() }}" class="prev">
                <svg class="icon">
                    <use xlink:href="#right"></use>
                </svg>
            </a>

        @endif
        @foreach ($elements as $element)
            @if (is_string($element))
                <a href="javascript:void(0)">{{ $element }}</a>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="javascript:void(0)" class="active-page">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="next">
                <svg class="icon">
                    <use xlink:href="#left"></use>
                </svg>
            </a>
        @endif
    </div>
@endif
