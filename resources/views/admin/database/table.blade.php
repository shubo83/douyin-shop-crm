<!--空白页面参考模版-->
@extends('admin.public.base')

@section('content')
@include('admin.public.content_header')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <!--数据列表顶部-->
                <div class="box-header">
                    <div>
                        <a class="btn btn-success btn-sm ReloadButton" data-toggle="tooltip" title="刷新"
                           data-id="checked">
                            <i class="fa fa-refresh"></i> 刷新
                        </a>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered datatable" width="100%">
                        <thead>
                        <tr>
                            <th>表名</th>
                            <th>注释</th>
                            <th>引擎</th>
                            <th>排序规则</th>
                            <th>记录数</th>
                            <th>表大小</th>
                            <th>创建时间</th>
                            <th>更新时间</th>

                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{$item['name']}}</td>
                            <td>{{$item['comment']}}</td>
                            <td>{{$item['engine']}}</td>
                            <td>{{$item['collation']}}</td>
                            <td>{{format_size($item['data_length'])}}</td>
                            <td>{{$item['create_time']}}</td>
                            <td>{{$item['update_time']}}</td>
                            <td class="td-do">

                                <a data-data='{"name":"{{$item['name']}}"}' data-url="view" data-confirm="2"
                                   data-type="2" class="AjaxButton btn btn-default btn-xs"
                                   data-title="{{$item['name']}}({{$item['comment']}})表详情" title="查看表详情"
                                   data-toggle="tooltip">
                                    <i class="fa  fa-info-circle"></i>
                                </a>
                                <a data-data='{"name":"{{$item['name']}}"}' data-go="1" data-url="optimize"
                                   data-confirm="2" class="AjaxButton btn btn-warning btn-xs" title="优化表"
                                   data-toggle="tooltip">
                                    <i class="fa  fa-refresh"></i>
                                </a>
                                <a data-data='{"name":"{{$item['name']}}"}' data-go="1" data-url="repair"
                                   data-confirm="2" class="AjaxButton btn btn-primary btn-xs" title="修复表"
                                   data-toggle="tooltip">
                                    <i class="fa  fa-circle-o-notch"></i>
                                </a>

                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection