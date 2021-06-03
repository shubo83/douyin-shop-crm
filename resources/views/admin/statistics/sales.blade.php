@extends('admin.public.base')

@section('content')
@include('admin.public.content_header')
<!--数据列表页面-->
<section class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered datatable" width="100%">
                        <thead>
                        <tr>
                            <th>销售</th>
                            <th class="text-blue">达人数</th>
                            <th class="text-blue">上月新增达人</th>
                            <th class="text-blue">本月新增达人</th>
                            <th class="text-blue">昨日新增达人</th>
                            <th class="text-orange">寄样数</th>
                            <th class="text-orange">上月新增寄样</th>
                            <th class="text-orange">本月新增寄样</th>
                            <th class="text-orange">昨日新增寄样</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sales_users as $sales_user)
                        <tr>
                            <td>{{$sales_user->nickname}}</td>
                            <td class="text-blue">{{$sales_user->customer_total}}</td>
                            <td class="text-blue">{{$sales_user->last_month_new_customer_total}}</td>
                            <td class="text-blue">{{$sales_user->current_month_new_customer_total}}</td>
                            <td class="text-blue">{{$sales_user->yesterday_new_customer_total}}</td>
                            <td class="text-orange">{{$sales_user->send_sample_total}}</td>
                            <td class="text-orange">{{$sales_user->last_month_new_send_sample_total}}</td>
                            <td class="text-orange">{{$sales_user->current_month_new_send_sample_total}}</td>
                            <td class="text-orange">{{$sales_user->yesterday_new_send_sample_total}}</td>
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

