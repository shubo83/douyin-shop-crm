@extends('admin.public.base')

@section('content')
@include('admin.public.content_header')
<!--数据列表页面-->
<section class="content">

    <!--顶部搜索筛选-->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <form class="form-inline searchForm" id="searchForm" action="{{route(request()->route()->action["as"],request()->route()->parameters)}}" method="GET">

                        <div class="form-group">
                            <select name="year" id="year" class="form-control input-sm">
                                <option value="">选择年</option>

                                @foreach($years as $year)
                                    <option value="{{$year}}" @if(request('year') == $year)selected @endif>
                                        {{$year}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <script>
                            $('#year').select2({
                                width:'100px',
                            });
                        </script>

                        <div class="form-group">
                            <select name="month" id="month" class="form-control input-sm">
                                <option value="">选择月</option>
                                @foreach([1,2,3,4,5,6,7,8,9,10,11,12] as $month)
                                    <option value="{{$month}}" @if(request('month') == $month)selected @endif>
                                        {{$month}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <script>
                            $('#month').select2({
                                width:'100px',
                            });
                        </script>


                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-search"></i> 查询
                            </button>
                        </div>

                        <div class="form-group">
                            <button onclick="clearSearchForm()" class="btn btn-sm btn-default" type="button"><i
                                    class="fa  fa-eraser"></i> 清空查询
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered datatable" width="100%">
                        <thead>
                        <tr>
                            <th>销售</th>
                            @foreach($shops as $shop)
                            <th>业绩({{$shop->value}})</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sales_users as $item)
                        <tr>
                            <td>{{$item->nickname}}</td>
                            @foreach($shops as $shop)
                            <td>{{ $item->{"total_sales_".$shop->id} }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>

<script>

    function clearSearchForm() {
        let url_all = window.location.href;
        let arr = url_all.split('?');
        let url = arr[0]+"?year=&month=";
        $.pjax({url: url, container: '#pjax-container'});
    }

</script>
@endsection

