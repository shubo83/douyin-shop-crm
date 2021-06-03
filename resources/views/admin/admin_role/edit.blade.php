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

                <form id="dataForm" class="form-horizontal dataForm" action="{{route('admin.admin_role.update')}}" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{$data['id']}}">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10 col-md-4">
                                <input maxlength="50" id="name" name="name" value="{{isset($data['name']) ? $data['name'] : ''}}"
                                       class="form-control" placeholder="请输入名称">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">简介</label>
                            <div class="col-sm-10 col-md-4">
                                <input maxlength="50" id="description" name="description"
                                       value="{{isset($data['description']) ? $data['description'] : ''}}" class="form-control" placeholder="请输入简介">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">启用状态</label>
                            <div class="col-sm-10 col-md-4">
                                <input class="input-switch" id="status" value="1" @if(!isset($data) || $data['status'] == '1') checked @endif type="checkbox"/>
                                <input class="switch field-switch" placeholder="启用状态" name="status"
                                       value="{{isset($data['status']) ? $data['status'] : '1'}}" hidden/>
                            </div>
                        </div>

                        <script>
                            $('#status').bootstrapSwitch({
                                onText: "是",
                                offText: "否",
                                onColor: "success",
                                offColor: "danger",
                                onSwitchChange: function (event, state) {
                                    $(event.target).closest('.bootstrap-switch').next().val(state ? '1' : '0').change();
                                }
                            });
                        </script>
                    </div>

                    <!--表单底部-->
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
<script>
    $("#dataForm").validate({
        rules: {
            name: {
                required: true,
            },
            description: {
                required: true
            }
        },
        messages: {
            name: {
                required: "名称不能为空",
            },
            description: {
                required: "简介不能为空",
            }
        },
    });
</script>

@endsection

