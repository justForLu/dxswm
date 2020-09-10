<div class="col-lg-12" style="overflow: hidden;">
    <div class="pull-left">
        <ul class="pagination">
            第&nbsp;{{$list->currentPage()}}&nbsp;/&nbsp;{{$list->LastPage()}}&nbsp;页,共&nbsp;{{$list->total()}}&nbsp;条数据
        </ul>
    </div>

    <div class="pull-right">
        @if (empty($params))
            {!! $list -> render() !!}
        @else
            {!! $list->appends($params)->render() !!}
        @endif
    </div>
</div>