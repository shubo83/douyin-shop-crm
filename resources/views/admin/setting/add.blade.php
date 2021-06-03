@extends('admin.public.base')

@section('content')
@include('admin.public.content_header')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <!-- 表单头部 -->
                <div class="box-header with-border">
                    <div class="btn-group">
                        <a class="btn flat btn-sm btn-default BackButton">
                            <i class="fa fa-arrow-left"></i>
                            返回
                        </a>
                    </div>
                </div>
                <!-- 表单 -->
                <form id="dataForm" class="form-horizontal dataForm" action="{{route('admin.setting.create')}}" method="post"
                      enctype="multipart/form-data">
                    <!-- 表单字段区域 -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="setting_group_id" class="col-sm-2 control-label">所属分组</label>
                            <div class="col-sm-10 col-md-4">
                                <select name="setting_group_id" id="setting_group_id" class="form-control field-select"
                                        data-placeholder="请选择所属分组">
                                    <option value=""></option>
                                    @foreach($setting_group_list as $item)
                                    <option value="{{$item['id']}}" @if(isset($data) && $data['setting_group_id']==$item['id']) selected @endif>
                                        {{$item['name']}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <script>
                            $('#setting_group_id').select2();
                        </script>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="name" name="name" value="{{isset($data['name']) ? $data['name'] : ''}}" placeholder="请输入名称"
                                       type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">描述</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="description" name="description" value="{{isset($data['description']) ? $data['description'] : ''}}"
                                       placeholder="请输入描述" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">代码</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="code" name="code" value="{{isset($data['code']) ? $data['code'] : ''}}" placeholder="请输入代码"
                                       type="text" class="form-control field-text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">设置配置</label>
                            <div class="col-sm-10 col-md-8">
                                <div class="box">
                                    <div class="box-body table-responsive">
                                        <table id="goods" class="table table-hover table-bordered datatable"
                                               width="100%">
                                            <thead>
                                            <tr class="input-type">
                                                <th>操作</th>
                                                <th>设置类型</th>
                                                <th>设置名称</th>
                                                <th>设置字段</th>
                                                <th>设置内容</th>
                                                <th>设置选项</th>
                                            </tr>
                                            </thead>
                                            <tbody id="dataBody">
                                            @if(isset($data))
                                            @foreach($data['content'] as $item)
                                            <tr>
                                                <td>
                                                    <a class="btn btn-xs btn-primary" onclick="addNew(this,1)">插入</a>
                                                    <a class="btn btn-xs btn-success" onclick="addNew(this,2)">追加</a>
                                                    <a class="btn btn-xs btn-danger" onclick="delThis(this,1)">删除</a>
                                                </td>

                                                <td>
                                                    <select name="config_type[]" class="form-control">
                                                        <option value="text" @if($item['type']=='text')selected @endif>
                                                            文本[text]
                                                        </option>
                                                        <option value="number" @if($item['type']=='number')selected @endif>
                                                            数字[number]
                                                        </option>
                                                        <option value="password" @if($item['type']=='password')selected @endif>密码[password]
                                                        </option>
                                                        <option value="mobile" @if($item['type']=='mobile')selected @endif>
                                                            手机号[mobile]
                                                        </option>
                                                        <option value="email" @if($item['type']=='email')selected @endif>
                                                            邮箱[email]
                                                        </option>
                                                        <option value="id_card" @if($item['type']=='id_card')selected @endif>
                                                            身份证号[id_card]
                                                        </option>
                                                        <option value="url" @if($item['type']=='url')selected @endif>
                                                            网址[url]
                                                        </option>
                                                        <option value="ip" @if($item['type']=='ip')selected @endif>IP地址[ip]
                                                        </option>
                                                        <option value="textarea" @if($item['type']=='textarea')selected @endif>文本域[textarea]
                                                        </option>
                                                        <option value="checkbox" @if($item['type']=='checkbox')selected @endif>复选[checkbox]
                                                        </option>
                                                        <option value="switch" @if($item['type']=='switch')selected @endif>
                                                            开关[switch]
                                                        </option>
                                                        <option value="radio" @if($item['type']=='radio')selected @endif>
                                                            单选[radio]
                                                        </option>
                                                        <option value="select" @if($item['type']=='select')selected @endif>
                                                            选择列表[select]
                                                        </option>
                                                        <option value="multi_select" @if($item['type']=='multi_select')selected @endif>
                                                            多项选择列表[multi-select]
                                                        </option>
                                                        <option value="image" @if($item['type']=='image')selected @endif>
                                                            图片上传[image]
                                                        </option>
                                                        <option value="multi_image" @if($item['type']=='multi_image')selected @endif>
                                                            多图上传[multi-image]
                                                        </option>
                                                        <option value="file" @if($item['type']=='file')selected @endif>
                                                            文件上传[file]
                                                        </option>
                                                        <option value="multi_file" @if($item['type']=='multi_file')selected @endif>多文件上传[multi-file]
                                                        </option>
                                                        <option value="date" @if($item['type']=='date')selected @endif>
                                                            日期[date]
                                                        </option>
                                                        <option value="date_range" @if($item['type']=='date_range')selected @endif>日期范围[date-range]
                                                        </option>
                                                        <option value="datetime" @if($item['type']=='datetime')selected @endif>日期时间[datetime]
                                                        </option>
                                                        <option value="datetime_range" @if($item['type']=='datetime_range')selected @endif>
                                                            日期时间范围[datetime-range]
                                                        </option>
                                                        <option value="year" @if($item['type']=='year')selected @endif>
                                                            年[year]
                                                        </option>
                                                        <option value="year_range" @if($item['type']=='year_range')selected @endif>年范围[year-range]
                                                        </option>
                                                        <option value="year_month" @if($item['type']=='year_month')selected @endif>年月[year-month]
                                                        </option>
                                                        <option value="year_month_range" @if($item['type']=='year_month_range')selected @endif>
                                                            年月范围[year-month-range]
                                                        </option>
                                                        <option value="map" @if($item['type']=='map')selected @endif>
                                                            地图选点[map]
                                                        </option>
                                                        <option value="color" @if($item['type']=='color')selected @endif>
                                                            颜色选择[color]
                                                        </option>
                                                        <option value="icon" @if($item['type']=='icon')selected @endif>
                                                            图标选择[icon]
                                                        </option>
                                                        <option value="editor" @if($item['type']=='editor')selected @endif>
                                                            富文本编辑器[editor]
                                                        </option>
                                                    </select>
                                                </td>

                                                <td>
                                                    <input class="form-control" placeholder="名称" value="{{$item['name']}}"
                                                           name="config_name[]">

                                                </td>
                                                <td>
                                                    <input class="form-control" placeholder="字段" value="{{$item['field']}}"
                                                           name="config_field[]">

                                                </td>

                                                <td>
                                                    <input class="form-control" name="config_content[]"
                                                           value="{{$item['content']}}" placeholder="选项/默认值(默认值为内容或者第一个选项)"/>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="config_option[]"
                                                              placeholder="设置选项(单选，复选，选择列表等需要填写此项。格式为 字段||中文名称+换行符)">{{$item['option']}}</textarea>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sort_number" class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-10 col-md-4">
                                <div class="input-group">
                                    <input id="sort_number" name="sort_number"
                                           value="{{isset($data['sort_number']) ? isset($data['sort_number']) : '1000'}}" placeholder="请输入排序" type="number"
                                           class="form-control field-number">
                                </div>
                            </div>
                        </div>
                        <script>
                            $('#sort_number')
                                .bootstrapNumber({
                                    upClass: 'success',
                                    downClass: 'primary',
                                    center: true
                                });
                        </script>

                    </div>
                    <!-- 表单底部 -->
                    <div class="box-footer">
                        @csrf
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10 col-md-4">
                            @if(!isset($data))
                            <div class="btn-group pull-right">
                                <label class="createContinue">
                                    <input type="checkbox" value="1" id="_create" name="_create"
                                           title="继续添加数据">继续添加</label>
                            </div>
                            @endif
                            <div class="btn-group">
                                <button type="submit" class="btn flat btn-info dataFormSubmit">
                                    保存
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="reset" class="btn flat btn-default dataFormReset">
                                    重置
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<table>
    <tbody id="data-template" style="display: none">
    <tr>
        <td>
            <a class="btn btn-xs btn-primary" onclick="addNew(this,1)">插入</a>
            <a class="btn btn-xs btn-success" onclick="addNew(this,2)">追加</a>
            <a class="btn btn-xs btn-danger" onclick="delThis(this,1)">删除</a>
        </td>
        <td>
            <select name="config_type[]" class="form-control">
                <option value="text">文本[text]</option>
                <option value="number">数字[number]</option>
                <option value="password">密码[password]</option>
                <option value="mobile">手机号[mobile]</option>
                <option value="email">邮箱[email]</option>
                <option value="id_card">身份证号[id_card]</option>
                <option value="url">网址[url]</option>
                <option value="ip">IP地址[ip]</option>
                <option value="textarea">文本域[textarea]</option>
                <option value="checkbox">复选[checkbox]</option>
                <option value="switch">开关[switch]</option>
                <option value="radio">单选[radio]</option>
                <option value="select">选择列表[select]</option>
                <option value="multi_select">多项选择列表[multi-select]</option>
                <option value="image">图片上传[image]</option>
                <option value="multi_image">多图上传[multi-image]</option>
                <option value="file">文件上传[file]</option>
                <option value="multi_file">多文件上传[multi-file]</option>
                <option value="date">日期[date]</option>
                <option value="date_range">日期范围[date-range]</option>
                <option value="datetime">日期时间[datetime]</option>
                <option value="datetime_range">日期时间范围[datetime-range]</option>
                <option value="year">年[year]</option>
                <option value="year_range">年范围[year-range]</option>
                <option value="year_month">年月[year-month]</option>
                <option value="year_month_range">年月范围[year-month-range]</option>
                <option value="map">地图选点[map]</option>
                <option value="color">颜色选择[color]</option>
                <option value="icon">图标选择[icon]</option>
                <option value="editor">富文本编辑器[editor]</option>
            </select>
        </td>
        <td>
            <input class="form-control" placeholder="名称" name="config_name[]">
        </td>
        <td>
            <input class="form-control" placeholder="字段" name="config_field[]">
        </td>

        <td>
            <input class="form-control" name="config_content[]" placeholder="选项/默认值(默认值为内容或者第一个选项)"/>
        </td>
        <td>
            <textarea class="form-control" name="config_option[]"
                      placeholder="设置选项(单选，复选，选择列表等需要填写此项。格式为 字段||中文名称+换行符)"></textarea>
        </td>
    </tr>

    </tbody>
</table>

<script>
    /** 表单验证 **/
    $('#dataForm').validate({
        rules: {
            'setting_group_id': {
                required: true,
            },
            'name': {
                required: true,
            },
            'description': {
                required: true,
            },
            'code': {
                required: true,
            },
            'sort_number': {
                required: true,
            },

        },
        messages: {
            'setting_group_id': {
                required: "所属分组不能为空",
            },
            'name': {
                required: "名称不能为空",
            },
            'description': {
                required: "描述不能为空",
            },
            'code': {
                required: "代码不能为空",
            },
            'sort_number': {
                required: "排序不能为空",
            },

        }
    });


    function addNew(obj, type) {
        var template = $('#data-template').html();
        if (obj == null) {
            $("#dataBody").append(template);
        } else {
            if (type === 1) {
                $(obj).parent().parent().before(template);
            } else {
                $(obj).parent().parent().after(template);
            }
        }

        $('#dataBody select').select2();
    }

    function delThis(obj) {
        layer.confirm('您确认删除本行吗？', {title: '删除确认', closeBtn: 1, icon: 3}, function () {
            $(obj).parent().parent().remove();
            layer.closeAll();
        });
    }
</script>

@if(!isset($data))
<script>
    $(function () {
        addNew(null, 1);
    });
</script>
@else
<script>
    $('#dataBody select').select2();
</script>
@endif

@endsection