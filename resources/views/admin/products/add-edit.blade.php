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
                <form id="dataForm" class="form-horizontal dataForm" action="@if(isset($item)){{ route('admin.products.update',$item->id) }}@else{{ route('admin.products.create') }}@endif" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $item->id }}"/>
                    <!-- 表单字段区域 -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 asterisk control-label">产品名称</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="title" name="title" value="{{$item->title}}" placeholder="请输入" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="serial_number" class="col-sm-2 asterisk control-label">产品编码</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="serial_number" name="serial_number" value="{{$item->serial_number}}" placeholder="请输入" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cover" class="col-sm-2 asterisk control-label">代表图</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="cover" name="cover" placeholder="请上传图片" @if(isset($item->cover))data-initial-preview="{{asset($item->cover)}}" @endif type="file"
                                       class="form-control field-image" >
                            </div>
                        </div>
                        <script>
                            $('#cover').fileinput({
                                language: 'zh',
                                overwriteInitial: true,
                                browseLabel: '浏览',
                                initialPreviewAsData: true,
                                dropZoneEnabled: false,
                                showUpload: false,
                                showRemove: false,
                                allowedFileTypes: ['image'],
                                maxFileSize: 10240
                            });
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
