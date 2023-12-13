@if ($paginator->hasPages())
    <div class="erp-pagination-wrapper d-flex justify-content-between align-items-center">
        <div class="erp-pagi-item">
            <div class="showing-date-box">
                <p>Showing {{$paginator->firstItem()}} to {{$paginator->lastItem()}} of {{$paginator->total()}} entries
                </p>
            </div>
        </div>
        <div class="erp-pagi-item">
            <ul class="pagination">

                @if ($paginator->onFirstPage())
                    <li class="page-item disabled"> <a href="#" class="page-link" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" data-href="{{ $paginator->previousPageUrl() }}" onclick="getPaginatedData(this)" rel="prev">«</a>
                    </li>
                @endif

                @if($paginator->lastPage() <= 7)
                    @for($i=1;$i<=$paginator->lastPage();$i++)
                        @if ($i == $paginator->currentPage())
                            <li class="page-item active"><a class="page-link" href="#">{{ $i }}</a></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0)" data-href="{{ $paginator->url($i) }}" onclick="getPaginatedData(this)">
                                    {{ $i }}
                                </a>
                            </li>
                        @endif
                    @endfor
                @else
                    @if($paginator->currentPage() <=3)
                        @for($i=1;$i<=4;$i++)
                            @if ($i == $paginator->currentPage())
                                <li class="page-item active"><a class="page-link" href="#">{{ $i }}</a></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0)" data-href="{{ $paginator->url($i) }}" onclick="getPaginatedData(this)">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endif
                        @endfor
                        <li class="page-item">
                            <a class="page-link disabled" href="#">...</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" data-href="{{ $paginator->url($paginator->lastPage() - 1) }}" onclick="getPaginatedData(this)">
                                {{ $paginator->lastPage() - 1 }}
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" data-href="{{ $paginator->url($paginator->lastPage()) }}" onclick="getPaginatedData(this)">
                                {{ $paginator->lastPage() }}
                            </a>
                        </li>

                    @elseif($paginator->currentPage() >= ($paginator->lastPage()-2))
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" data-href="{{ $paginator->url(1) }}" onclick="getPaginatedData(this)">
                                {{ 1 }}
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" data-href="{{ $paginator->url(2) }}" onclick="getPaginatedData(this)">
                                {{ 2 }}
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link disabled" href="#">...</a>
                        </li>
                        @for($i=($paginator->lastPage()-3);$i<=$paginator->lastPage();$i++)
                            @if ($i == $paginator->currentPage())
                                <li class="page-item active"><a class="page-link" href="#">{{ $i }}</a></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0)" data-href="{{ $paginator->url($i) }}" onclick="getPaginatedData(this)">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endif
                        @endfor
                    @else
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" data-href="{{ $paginator->url(1) }}" onclick="getPaginatedData(this)">
                                {{ 1 }}
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link disabled" href="#">...</a>
                        </li>
                        @for($i=($paginator->currentPage() - 1);$i<=($paginator->currentPage() + 1);$i++)
                            @if ($i == $paginator->currentPage())
                                <li class="page-item active"><a class="page-link" href="#">{{ $i }}</a></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0)" data-href="{{ $paginator->url($i) }}" onclick="getPaginatedData(this)">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endif
                        @endfor
                        <li class="page-item">
                            <a class="page-link disabled" href="#">...</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" data-href="{{ $paginator->url($paginator->lastPage()) }}" onclick="getPaginatedData(this)">
                                {{ $paginator->lastPage() }}
                            </a>
                        </li>
                    @endif
                @endif

                @if ($paginator->hasMorePages())
                    <li class="page-item"><a class="page-link" href="javascript:void(0)" data-href="{{ $paginator->nextPageUrl() }}" rel="next" onclick="getPaginatedData(this)">»</a></li>
                @else
                    <li class="page-item disabled"> <a href="#" aria-label="Next"  class="page-link"><span aria-hidden="true">»</span></a> </li>
                @endif
            </ul>
        </div>
    </div>
@endif
