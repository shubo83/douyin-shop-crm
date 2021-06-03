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
                <form id="dataForm" class="form-horizontal dataForm" action="@if(isset($item)){{ route('admin.customers.update',$item->id) }}@else{{ route('admin.customers.create') }}@endif" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $item->id }}"/>
                    <!-- 表单字段区域 -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nickname" class="col-sm-2 asterisk control-label">达人昵称</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="nickname" name="nickname" value="{{$item->nickname}}" placeholder="请输入达人昵称" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="level" class="col-sm-2 asterisk control-label">达人等级</label>
                            <div class="col-sm-10 col-md-4">
                                <select name="level" id="level" class="form-control select2">
                                    <option value="A" {{ $item->level == 'A' ? 'selected' : ''}} >A</option>
                                    <option value="B" {{ $item->level == 'B' ? 'selected' : ''}} >B</option>
                                    <option value="C" {{ $item->level == 'C' ? 'selected' : ''}} >C</option>
                                    <option value="D" {{ $item->level == 'D' ? 'selected' : ''}} >D</option>
                                </select>
                            </div>
                        </div>
                        <script>
                            $('#level').select2();
                        </script>
                        <div class="form-group">
                            <label for="platform_user_id" class="col-sm-2 asterisk control-label">平台用户ID</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="platform_user_id" name="platform_user_id" value="{{$item->platform_user_id}}" placeholder="请输入抖音/快手等平台的用户ID" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact_person" class="col-sm-2 asterisk control-label">联系人</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="contact_person" name="contact_person" value="{{$item->contact_person}}" placeholder="请输入联系人姓名" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="col-sm-2"></label>
                            <div class="col-sm-10 col-md-4">
                                <code>手机号和微信号必填其中一项</code>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="col-sm-2 control-label">手机号</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="mobile" name="mobile" value="{{$item->mobile}}" placeholder="请输入联系人手机号" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="wechat_account" class="col-sm-2 control-label">微信号</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="wechat_account" name="wechat_account" value="{{$item->wechat_account}}" placeholder="请输入联系人微信号" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fans_number" class="col-sm-2 asterisk control-label">粉丝数量(万)</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="fans_number" name="fans_number" value="{{$item->fans_number}}" placeholder="请输入达人粉丝数量" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="shop_score" class="col-sm-2 asterisk control-label">店铺评分</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="shop_score" name="shop_score" value="{{$item->shop_score}}" placeholder="请输入达人店铺评分" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="shop_sales" class="col-sm-2 asterisk control-label">店铺销量(万)</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="shop_sales" name="shop_sales" value="{{$item->shop_sales}}" placeholder="请输入达人店铺销量" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="shop_category_id" class="col-sm-2 asterisk control-label">店铺类目</label>
                            <div class="col-sm-10 col-md-4">
                                <select name="shop_category_id" id="shop_category_id" class="form-control select2">
                                    @foreach($shop_categories as $shop_category)
                                        <option value="{{$shop_category->id}}" {{ $shop_category->id==$item->shop_category_id ? 'selected' : ''}} >
                                            {{$shop_category->value}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <script>
                            $('#shop_category_id').select2();
                        </script>
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
