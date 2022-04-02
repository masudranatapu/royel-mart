@if ($categories->lastPage() > 1)
    <div class="row">
        <div class="col-12 px-2">
            <div class="pagination-wrapper mt-40 mb-40">
                <ul class="pagination">
                    @if ($paginator->currentPage() > 1)
                        <li><a href="{{ $paginator->url($paginator->currentPage()-1) }}"><i class="bi bi-arrow-left-short"></i></a></li>
                    @endif
                    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                        <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}"><a href="{{ $paginator->url($i) }}"><span>{{ $i }}</span></a></li>
                    @endfor
                    @if ($paginator->currentPage() < $paginator->lastPage())
                        <li><a href="{{ $paginator->url($paginator->currentPage()+1) }}"><i class="bi bi-arrow-right-short"></i></a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endif
