@extends('admin.public.base')

@section('content')
@include('admin.public.content_header')
<!--数据列表页面-->
<section class="content">

    <!-- 导入弹窗 -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">请选择要导入的Excel文件</h4>
                </div>
                <form action="{{ route('admin.send_samples.import') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div class="file-loading">
                            <input id="import" name="excel" type="file" data-show-preview="false">
                        </div>
                        <div id="kartik-file-errors"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">确认</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--顶部搜索筛选-->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <form class="form-inline searchForm" id="searchForm" action="{{route(request()->route()->action["as"],request()->route()->parameters)}}" method="GET">

                        <div class="form-group">
                            <select name="customer_id" id="customer_id" class="form-control input-sm">
                                <option value="">选择达人</option>

                                @foreach($customers as $customer)
                                    <option value="{{$customer->id}}" @if(request('customer_id') == $customer->id)selected @endif>
                                        {{$customer->nickname}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <script>
                            $('#customer_id').select2({
                                width:'200px',
                            });
                        </script>

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
                        @if(check_auth("admin.customer_sales.import"))
                            <div class="form-group">
                                <a href="javascript:void(0);"
                                   data-toggle="modal" data-target="#importModal"
                                   class="btn btn-danger btn-sm" title="导入" data-toggle="tooltip">
                                    <i class="fa fa-upload"></i> 销售额导入
                                </a>
                            </div>
                        @endif
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
                            <th>达人</th>
                            <th>年</th>
                            <th>月</th>
                            <th>销售额</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{$item->customer->nickname}}</td>
                            <td>{{$item->year}}</td>
                            <td>{{$item->month}}</td>
                            <td>{{$item->sales}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- 数据列表底部 -->
                <div class="box-footer">
                    {{ $data->withQueryString()->links() }}
                    <label class="control-label pull-right" style="margin-right: 10px; font-weight: 100;">
                        <small>共{{$data->total()}}条记录</small>&nbsp;
                        <small>每页显示</small>
                        &nbsp;
                        <select class="input-sm" onchange="changePerPage(this)">
                            @foreach($admin['per_page_config'] as $val)
                                <option value="{{$val}}" @if($admin['per_page'] == $val) selected @endif>{{$val}}</option>
                            @endforeach
                        </select>
                        &nbsp;
                        <small>条记录</small>
                    </label>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection

