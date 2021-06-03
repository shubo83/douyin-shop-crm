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
                <form id="dataForm" class="form-horizontal dataForm" action="{{ route('admin.send_samples.do_send',$item->id) }}" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $item->id }}"/>
                    <input type="hidden" name="is_send" value="1"/>
                    <!-- 表单字段区域 -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="customer_id" class="col-sm-2 asterisk control-label">达人</label>
                            <div class="col-sm-10 col-md-4 v">
                                <label class="control-label">{{ $item->customer->nickname }}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="customer_address_id" class="col-sm-2 asterisk control-label">收货地址</label>
                            <div class="col-sm-10 col-md-4">
                                <label class="control-label">{{ $item->address->consignee_address }}</label>
                            </div>
                        </div>
                        <script>
                            $('#customer_address_id').select2();
                        </script>
                        <div class="form-group">
                            <label class="col-sm-2 asterisk control-label">完善寄样信息</label>
                            <div class="col-sm-10 col-md-6">
                                <table class="table table-hover table-bordered datatable" width="100%">
                                    <thead>
                                    <tr>
                                        <th width="30%">产品名称</th>
                                        <th width="10%">数量</th>
                                        <th width="30%">备注</th>
                                        <th width="30%">物流单号</th>
                                    </tr>
                                    </thead>
                                    <tbody id="product_table_tbody">
                                    @foreach($item->send_sample_products as $key=>$send_sample_product)
                                        <tr>
                                            <input type='hidden' name='products[{{$key}}][send_sample_product_id]' value='{{$send_sample_product->id}}'>
                                            <td>{{$send_sample_product->product->title}}</td>
                                            <td>{{$send_sample_product->quantity}}</td>
                                            <td>{{$send_sample_product->remark}}</td>
                                            <td><input class='form-control' type='text' name='products[{{$key}}][courier_number]' value='{{$send_sample_product->courier_number}}'></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
    $(function (){
        $("#customer_id").change(function () {
            $.getJSON("{{route("admin.customer_addresses.list_by_customer_id")}}?customer_id="+$(this).val(),function (data){
                $("#customer_address_id").empty();
                $.each(data, function(key,vo){
                    $("#customer_address_id").append("<option value='"+vo.id+"'>"+vo.consignee_address+"</option>")
                })
            })
        });

        $("#product_ids").change(function (){

            var selected_ids = [];
            $('#product_ids option:selected').each(function (key,vo){
                selected_ids.push($(this).val());
            });

            var showed_ids = [];
            $("#product_table_tbody tr").each(function (k,p){
                showed_ids.push($(p).attr("data-id"));
                if (!selected_ids.includes($(p).attr("data-id"))){
                    $(p).remove();
                }
            })

            $('#product_ids option:selected').each(function (key,vo){
                if (!showed_ids.includes($(vo).val())){
                    $("#product_table_tbody").append("<tr data-id='"+$(vo).val()+"'><input type='hidden' name='products["+key+"][product_id]' value='"+$(vo).val()+"'>" +
                        "                    <td>"+$(vo).text().trim()+"</td>" +
                        "                    <td><input class='form-control' type='text' name='products["+key+"][quantity]'></td>" +
                        "                    <td><input class='form-control' type='text' name='products["+key+"][remark]'></td>" +
                        "                </tr>")
                }
            })

        })
    })
</script>
@endsection
