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
                                   name="_keywords" id="_keywords" class="form-control input-sm" style="width:200px" placeholder="销售昵称/达人昵称/达人平台ID">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-search"></i> 查询
                            </button>
                        </div>
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

    @if(count($data['data'])>0)
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
                            <th>所属销售</th>
                            <th>达人昵称</th>
                            <th>达人等级</th>
                            <th>平台用户ID</th>
                            <th>店铺粉丝量</th>
                            <th>店铺评分</th>
                            <th>店铺销量</th>
                            <th>店铺类目</th>
                            <th>创建时间</th>
                            <th>状态</th>
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
                            <td>{{$item->admin_user->nickname}}</td>
                            <td>{{$item->nickname}}</td>
                            <td>{{$item->level}}</td>
                            <td>{{$item->platform_user_id}}</td>
                            <td>{{$item->fans_number}}w</td>
                            <td>{{$item->shop_score}}</td>
                            <td>{{$item->shop_sales}}w</td>
                            <td>{{$item->shop_category->value}}</td>
                            <td>{{$item['created_at']}}</td>
                            <td>{{$item->status_text}}</td>
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
    @endif
</section>

@endsection

