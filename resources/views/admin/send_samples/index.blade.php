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

    <!-- 拒绝dialog -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">拒绝寄样申请</h4>
                </div><form id="reject_form" method="get" action="">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">拒绝理由</label>
                            <input type="text" class="form-control" id="reject_reason" name="reject_reason">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">确认</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 签收dialog -->
    <div class="modal fade" id="signModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">寄样已签收</h4>
                </div><form id="sign_form" method="get" action="">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">签收日期</label>
                            <input type="text" class="form-control" id="sign_date" name="sign_date" readonly>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">确认</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 大图dialog -->
    <div class="modal fade" id="chatScreenModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <td><img id="bigimg" class="img-responsive" width="100%" src="" alt=""></td>
                </div>
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
                            <input value="{{isset($_keywords) ? $_keywords : ''}}"
                                   name="_keywords" id="_keywords" class="form-control input-sm" placeholder="关键词">
                        </div>

                        <div class="form-group">
                            <select name="apply_status" id="apply_status" class="form-control input-sm">
                                <option value="">审核状态(全部)</option>
                                <option value="1" @if(request('apply_status') == 1)selected @endif>审核中</option>
                                <option value="3" @if(request('apply_status') == 3)selected @endif>审核通过</option>
                                <option value="2" @if(request('apply_status') == 2)selected @endif>审核拒绝</option>
                            </select>
                        </div>
                        <script>
                            $('#apply_status').select2({
                                width:'130px',
                            });
                        </script>


                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-search"></i> 查询
                            </button>
                        </div>
                        @if(check_auth("admin.send_samples.export"))
                        <div class="form-group">
                            <button onclick="exportData('{{route('admin.send_samples.export')}}')" class="btn btn-sm btn-warning exportData" type="button"><i
                                    class="fa fa-search"></i> 导出
                            </button>
                        </div>
                        @endif

                        @if(check_auth("admin.send_samples.import"))
                            <div class="form-group">
                                <a href="javascript:void(0);"
                                   data-toggle="modal" data-target="#importModal"
                                   class="btn btn-danger btn-sm" title="导入" data-toggle="tooltip">
                                    <i class="fa fa-upload"></i> 导入
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
                            <th>编号</th>
                            <th>销售</th>
                            <th>达人</th>
                            <th>姓名</th>
                            <th>手机</th>
                            <th>地址</th>
                            <th>截图</th>
                            <th>产品</th>
                            <th>数量</th>
                            <th>佣金</th>
                            <th>备注</th>
                            <th>快递单号</th>
                            <th>状态</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{$item->send_sample->serial_number}}</td>
                            <td>{{$item->send_sample->admin_user->nickname}}</td>
                            <td>{{$item->send_sample->customer->nickname}}</td>
                            <td>{{$item->send_sample->address->consignee_name}}</td>
                            <td>{{$item->send_sample->address->consignee_mobile}}</td>
                            <td>{{$item->send_sample->address->consignee_address}}</td>
                            <td>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#chatScreenModal" data-src="{{asset("storage/".$item->send_sample->chat_screen)}}">
                                    <img class="img-responsive" width="100" src="{{asset("storage/".$item->send_sample->chat_screen)}}" alt="">
                                </a>
                            </td>
                            <td>{{$item->product->title}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->commission}}%</td>
                            <td>{{$item->remark}}</td>
                            <td><a href="https://www.baidu.com/s?wd={{$item->courier_number}}" target="_blank">{{$item->courier_number}}</a></td>
                            <td>{{$item->send_sample->apply_status_text}}</td>
                            <td>{{$item->send_sample->created_at}}</td>
                            <td class="td-do">
                                @if(check_auth("admin.send_samples.send"))
                                    <a href="{{route('admin.send_samples.send',['id'=>$item['send_sample_id']])}}"
                                       class="btn btn-warning btn-xs" title="发货" data-toggle="tooltip">
                                        发货
                                    </a>
                                @endif

                                @if(check_auth("admin.send_samples.reject"))
                                    <a href="javascript:void(0);"
                                       data-toggle="modal" data-target="#rejectModal"
                                       data-action="{{route('admin.send_samples.reject',[$item['send_sample_id']])}}"
                                       class="btn btn-danger btn-xs" title="拒绝" data-toggle="tooltip">
                                        拒绝
                                    </a>
                                @endif

                                    @if(check_auth("admin.send_samples.sign") && $item->send_sample->apply_status==3 && $item->send_sample->admin_user_id == session(LOGIN_USER)["id"])
                                        <a href="javascript:void(0);"
                                           data-toggle="modal" data-target="#signModal"
                                           data-action="{{route('admin.send_samples.sign',[$item['send_sample_id']])}}"
                                           class="btn btn-success btn-xs" title="签收时间" data-toggle="tooltip">
                                            签收时间
                                        </a>
                                    @endif

                                    @if($item->send_sample->apply_status==1 && $item->send_sample->admin_user_id == session(LOGIN_USER)["id"])
                                    <a href="{{route('admin.send_samples.edit',['id'=>$item['send_sample_id']])}}"
                                       class="btn btn-primary btn-xs" title="修改" data-toggle="tooltip">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    @endif
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

<script>
    $(function(){
        $('#chatScreenModal').on('shown.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#bigimg').attr("src",button.data('src'));
        })

        $('#rejectModal').on('shown.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#reject_form').attr("action",button.data('action'));
            modal.find("#reject_reason").focus();
        })

        $('#signModal').on('shown.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#sign_form').attr("action",button.data('action'));
            modal.find("#sign_date").focus();
        })

        $('#sendModal').on('shown.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var modal = $(this);
            modal.find('#send_form').attr("action",button.data('action'));
            modal.find("#courier_number").focus();
        })

        $("#import").fileinput({
            "browseLabel":"请选择",
            "showUpload":false,
            "showRemove":false,
            "showCancel":false,
            "dropZoneEnabled":false,
            "allowedPreviewType":false,
            "browseClass": "btn btn-primary",
            "fileActionSettings":{
                "showRemove":false,
                "showDrag":false
            },
            "msgPlaceholder":"请选择",
            "allowedFileExtensions":[
                "xlsx"
            ]
        });

        $.fn.datepicker.dates['en'] = {
            days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
            daysMin: ["日", "一", "二", "三", "四", "五", "六"],
            months: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"],
            monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            today: "Today",
            clear: "Clear",
            format: "yyyy-mm-dd",
            titleFormat: "yyyy-MM", /* Leverages same syntax as 'format' */
            weekStart: 0
        };

        $('#sign_date').datepicker({
            autoclose: true
        })
    });
</script>

@endsection

