@extends('admin.public.base')

@section('content')
@include('admin.public.content_header')
<!--数据列表页面-->
<section class="content">

    <!--顶部搜索筛选-->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <form class="form-inline searchForm" id="searchForm" action="{{route(request()->route()->action["as"],request()->route()->parameters)}}" method="GET">

                        <div class="form-group">
                            <input value="{{request('_keywords')}}"
                                   name="_keywords" id="_keywords" class="form-control input-sm" placeholder="关键词">
                        </div>

                        @if(request()->route()->getName() != 'admin.customers.index1' && check_auth("admin.customers.export") )
                        <div class="form-group">
                            <select name="admin_user_id" id="admin_user_id" class="form-control input-sm">
                                <option value="">选择销售</option>
                                @foreach($sales_list as $item)
                                    <option value="{{$item['id']}}" @if(request('admin_user_id') == $item['id'])selected @endif>
                                        {{$item['nickname']}}[{{$item['username']}}]
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <script>
                            $('#admin_user_id').select2({
                                width:'150px',
                            });
                        </script>
                        @endif


                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-search"></i> 查询
                            </button>
                        </div>
                        @if(check_auth("admin.customers.export"))
                        <div class="form-group">
                            <button onclick="exportData('{{route('admin.customers.export')}}')" class="btn btn-sm btn-warning exportData" type="button"><i
                                    class="fa fa-search"></i> 导出
                            </button>
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
                            <th>
                                <input id="dataCheckAll" type="checkbox" onclick="checkAll(this)" class="checkbox"
                                       placeholder="全选/取消">
                            </th>
                            <th>ID</th>
                            @if(request()->route()->getName() != 'admin.customers.index1' && in_array(1,$admin["user"]["role"]))
                                <th>所属销售</th>
                            @endif
                            <th>达人昵称</th>
                            <th>达人等级</th>
                            <th>平台用户ID</th>
                            <th>联系人</th>
                            <!-- 业务员不能看到公海达人的联系方式-->
                            @if(request()->route()->getName() != 'admin.customers.index1' || in_array(1,$admin["user"]["role"]) )
                            <th>手机号</th>
                            <th>微信号</th>
                            @endif
                            <th>店铺粉丝量</th>
                            <th>店铺评分</th>
                            <th>店铺销量</th>
                            <th>店铺类目</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['data'] as $item)
                        <tr>
                            <td>
                                <input type="checkbox" onclick="checkThis(this)" name="data-checkbox"
                                       data-id="{{$item['id']}}" class="checkbox data-list-check" value="{{$item['id']}}"
                                       placeholder="选择/取消">
                            </td>
                            <td>{{$item->id}}</td>
                            @if(request()->route()->getName() != 'admin.customers.index1' && in_array(1,$admin["user"]["role"]))
                                <td>{{$item->admin_user->nickname}}</td>
                            @endif
                            <td>{{$item->nickname}}</td>
                            <td>{{$item->level}}</td>
                            <td>{{$item->platform_user_id}}</td>
                            <td>{{$item->contact_person}}</td>
                            @if(request()->route()->getName() != 'admin.customers.index1' || in_array(1,$admin["user"]["role"]) )
                            <td>{{$item->mobile}}</td>
                            <td>{{$item->wechat_account}}</td>
                            @endif
                            <td>{{$item->fans_number}}w</td>
                            <td>{{$item->shop_score}}</td>
                            <td>{{$item->shop_sales}}w</td>
                            <td>{{$item->shop_category->value}}</td>
                            <td>{{$item['created_at']}}</td>

                            <td class="td-do">
                                <a href="{{route('admin.customers.edit',['id'=>$item['id']])}}"
                                   class="btn btn-primary btn-xs" title="修改" data-toggle="tooltip">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                @if(request()->route()->getName() == 'admin.customers.index1') <!-- 公海-->
                                    <a class="btn btn-success btn-xs AjaxButton" data-toggle="tooltip" title="跟进客户"
                                       data-id="{{$item['id']}}" data-confirm-title="跟进客户确认"
                                       data-confirm-content='您确定要跟进ID为 <span class="text-red">{{$item['id']}}</span> 的客户吗？'
                                       data-url="{{route('admin.customers.follow_up',$item['id'])}}">
                                        跟进
                                    </a>
                                @else
                                        <a href="{{route('admin.customer_addresses.index',['customer_id'=>$item['id']])}}"
                                           class="btn btn-info btn-xs" title="地址管理" data-toggle="tooltip">
                                            地址
                                        </a>
                                        <a href="{{route('admin.send_samples.add',['customer_id'=>$item['id']])}}"
                                           class="btn btn-warning btn-xs" title="寄样申请" data-toggle="tooltip">
                                            寄样
                                        </a>
                                    <a class="btn btn-danger btn-xs AjaxButton" data-toggle="tooltip" title="公海"
                                       data-id="{{$item['id']}}" data-confirm-title="踢到公海确认"
                                       data-confirm-content='您确定要将ID为 <span class="text-red">{{$item['id']}}</span> 的数据踢到公海吗？'
                                       data-url="{{route('admin.customers.high_seas',$item['id'])}}">
                                        公海
                                    </a>
                                @endif
                                <a class="btn btn-danger btn-xs AjaxButton" data-toggle="tooltip" title="删除"
                                   data-id="{{$item['id']}}" data-confirm-title="删除确认"
                                   data-confirm-content='您确定要删除ID为 <span class="text-red">{{$item['id']}}</span> 的数据吗？'
                                   data-url="{{route('admin.customers.del')}}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- 数据列表底部 -->
                <div class="box-footer">
                    {{ $data['data']->withQueryString()->links() }}
                    <label class="control-label pull-right" style="margin-right: 10px; font-weight: 100;">
                        <small>共{{$data['data']->total()}}条记录</small>&nbsp;
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

