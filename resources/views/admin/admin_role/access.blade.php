@extends('admin.public.base')

@section('content')
@include('admin.public.content_header')
<link rel="stylesheet" href="{{asset(__ADMIN_CSS__.'/access.css')}}">
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

                <div class="box-header with-border">
                    <h3 class="box-title">【{!! $data['name'] !!}】授权</h3>
                    <label class="checkbox" for="check_all">
                        <input class="checkbox-inline" type="checkbox" name="check_all" id="check_all">全选
                    </label>
                </div>
                <div class="box-body" id="all_check">
                    <form id="dataForm" class="form-horizontal dataForm" action="{{route('admin.admin_role.access_operate')}}" method="post"
                          enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{$data['id']}}">
                        <div class="box-body">
                            <div class="table_full">
                                <table width="100%" cellspacing="0">
                                    <tbody>
                                    {!! $html !!}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!--表单底部-->
                        <div class="box-footer">
                            @csrf
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-10 col-md-4">
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
        <script>
            $("#check_all").click(function () {
                if (this.checked) {
                    $("#all_check").find(":checkbox").prop("checked", true);
                } else {
                    $("#all_check").find(":checkbox").prop("checked", false);
                }
            });

            function checkNode(obj) {
                var level_bottom;
                var chk = $("input[type='checkbox']");
                var count = chk.length;
                var num = chk.index(obj);
                var level_top = level_bottom = chk.eq(num).attr('level');

                for (var i = num; i >= 0; i--) {
                    var le = chk.eq(i).attr('level');
                    if (eval(le) < eval(level_top)) {
                        chk.eq(i).prop("checked", true);
                        level_top = level_top - 1;
                    }
                }

                for (var j = num + 1; j < count; j++) {
                    le = chk.eq(j).attr('level');
                    if (chk.eq(num).prop("checked")) {
                        if (eval(le) > eval(level_bottom)) {

                            chk.eq(j).prop("checked", true);
                        } else if (eval(le) == eval(level_bottom)) {
                            break;
                        }
                    } else {
                        if (eval(le) > eval(level_bottom)) {
                            chk.eq(j).prop("checked", false);
                        } else if (eval(le) == eval(level_bottom)) {
                            break;
                        }
                    }
                }

                var all_length = $("input[name='url[]']").length;
                var checked_length = $("input[name='url[]']:checked").length;

                if(adminDebug){
                    console.log('所有数量'+all_length);
                    console.log('选中数量'+checked_length);
                }

                if (all_length === checked_length) {
                    $("#check_all").prop("checked", true);
                } else {
                    $("#check_all").prop("checked", false);
                }

            }
        </script>
    </div>
</section>

<script>
    $("#dataForm").validate({
        rules: {
            'url[]': {
                required: true
            }
        },
        messages: {
            'url[]': {
                required: "请选择权限",

            },
        },

    });
</script>

@endsection

