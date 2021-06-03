@extends('admin.public.base')

@section('content')
@include('admin.public.content_header')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <form class="form-inline searchForm" id="searchForm" action="{{route('admin.admin_log.index')}}" method="GET">
                        <div class="form-group">
                            <input value="{{isset($_keywords) ? $_keywords : ''}}"
                                   name="_keywords" id="_keywords" class="form-control input-sm" placeholder="操作/URL/IP">
                        </div>

                        <div class="form-group">
                            <select name="admin_user_id" id="admin_user_id" class="form-control input-sm">
                                <option value="">选择用户</option>
                                @foreach($admin_user_list as $item)
                                <option value="{{$item['id']}}" @if(isset($admin_user_id) && $admin_user_id == $item['id'])selected @endif>
                                    {{$item['nickname']}}[{{$item['username']}}]
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <script>
                            $('#admin_user_id').select2({
                                width:'100%',
                            });
                        </script>

                        <div class="form-group">
                            <input readonly value="{{isset($create_time) ? $create_time : ''}}"
                                   name="create_time" id="create_time" class="form-control input-sm indexSearchDatetimeRange" placeholder="操作日期">
                        </div>
                        <script>
                            laydate.render({
                                elem: '#create_time'
                                ,range: true
                                ,type:'datetime'
                            });
                        </script>

                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-search"></i> 查询
                            </button>
                        </div>
                        <div class="form-group">
                            <button onclick="clearSearchForm()" class="btn btn-sm btn-default" type="button"><i
                                    class="fa  fa-eraser"></i> 清空
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
                            <th>ID</th>
                            <th>用户</th>
                            <th>操作</th>
                            <th>URL</th>
                            <th>请求方式</th>
                            <th>IP</th>
                            <th>日期</th>
                            <th>操作</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{$item['id']}}</td>
                            <td>{{isset($item['adminUser']['nickname']) ? $item['adminUser']['nickname'] : '已删除'}}</td>
                            <td>{{$item['name']}}</td>
                            <td>{{$item['url']}}</td>
                            <td>{{$item['log_method']}}</td>
                            <td>{{$item['log_ip']}}</td>
                            <td>{{$item['create_time']}}</td>
                            <td class="td-do">
                                <a data-id="{{$item['id']}}" data-url="view" data-confirm="2" data-type="2"
                                   class="btn btn-default btn-xs AjaxButton" data-title="日志详情" title="查看详情" data-toggle="tooltip">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
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

