@if ($paginator->hasPages())

<style>

    .pagination {
        display: flex;
        float: right;
        margin: 1rem;
    }
    .pagination li a {
        border: none;
        font-size: 1rem;
        min-width: 30px;
        min-height: 30px;
        color: white;
        margin: 0 2px;
        line-height: 30px;
        border-radius: 2px !important;
        text-align: center;
        padding: .25rem .5rem .25rem .5rem;
    }
    .pagination li a:hover {
        color: var(--secondary-color);;
    }	
    .pagination li.active a, .pagination li.active a.page-link {
        background: var(--secondary-color);
    }
    .pagination li.active a:hover {        
        background: var(--secondary-color);;
    }
    .pagination li.disabled i {
        color: #ccc;
    }
    .pagination li i {
        font-size: 16px;
        padding-top: 6px
    }
    .hint-text {
        float: left;
        margin-top: 10px;
        font-size: 13px;
    }    

</style>

    <ul class="pagination justify-content-end">

        @if ($paginator->onFirstPage())

            <li class="page-item disabled">

                <a class="page-link" href="#" tabindex="-1"><i class="fa-solid fa-chevron-left"></i></a>

            </li>

        @else

            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i class="fa-solid fa-chevron-left"></i></a></li>

        @endif

      

        @foreach ($elements as $element)

            @if (is_string($element))

                <li class="page-item disabled">{{ $element }}</li>

            @endif

            @if (is_array($element))

                @foreach ($element as $page => $url)

                    @if ($page == $paginator->currentPage())

                        <li class="page-item active">

                            <a class="page-link">{{ $page }}</a>

                        </li>

                    @else

                        <li class="page-item">

                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>

                        </li>

                    @endif

                @endforeach

            @endif

        @endforeach

        

        @if ($paginator->hasMorePages())

            <li class="page-item">

                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa-solid fa-chevron-right"></i></a>

            </li>

        @else

            <li class="page-item disabled">

                <a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a>

            </li>

        @endif

    </ul>

@endif