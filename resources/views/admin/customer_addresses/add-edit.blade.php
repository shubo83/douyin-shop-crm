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
                <form id="dataForm" class="form-horizontal dataForm" action="@if(isset($item)){{ route('admin.customer_addresses.update',$item->id) }}@else{{ route('admin.customer_addresses.create') }}@endif" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $item->id }}"/>
                    <input type="hidden" name="customer_id" value="{{ request('customer_id') }}"/>
                    <!-- 表单字段区域 -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="consignee_name" class="col-sm-2 asterisk control-label">收货人姓名</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="consignee_name" name="consignee_name" value="{{$item->consignee_name}}" placeholder="请输入" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="consignee_mobile" class="col-sm-2 asterisk control-label">收货人手机号</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="consignee_mobile" name="consignee_mobile" value="{{$item->consignee_mobile}}" placeholder="请输入" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="consignee_address" class="col-sm-2 asterisk control-label">收货人详细地址</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="consignee_address" name="consignee_address" value="{{$item->consignee_address}}" placeholder="请输入" type="text" class="form-control field-text">
                            </div>
                        </div>
                    </div>
                    <!-- 表单底部 -->
                    <div class="box-footer">
                        @csrf
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10 col-md-4">
                            @if(!$item)
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
    /** 表单验证 **/
    $('#dataForm').validate();
</script>
@endsection
