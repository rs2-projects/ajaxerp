<div class="page-header bg-card">
    <h1 class="page-title my-auto">{{ $pageHeaderTitle }}</h1>
    @if(count($pageBreadcrumbs) > 0)
        <div>
            <ol class="breadcrumb mb-0">
                @foreach($pageBreadcrumbs as $pageBreadcrumb)
                    <li class="breadcrumb-item {{ ($loop->last)?'active':'' }}">
                        <a href="{{ $pageBreadcrumb['link'] ?? 'javascript:void(0)' }}">
                            @if($pageBreadcrumb['icon'] != null)
                                @if($pageBreadcrumb['icon_custom'])
                                    {!! $pageBreadcrumb['icon'] !!}
                                @else
                                    <span class="me-1"><i class="{{ $pageBreadcrumb['icon'] }}"></i></span>
                                @endif
                            @endif
                            {{ $pageBreadcrumb['text'] }}
                        </a>
                    </li>
                @endforeach
            </ol>
        </div>
    @endif
</div>
