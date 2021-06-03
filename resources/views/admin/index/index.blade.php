@extends('admin.public.base')

@section('content')
@include('admin.public.content_header')
<section class="content">

    @if(in_array(2,$admin["user"]["role"])) <!--销售-->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                <span class="info-box-icon bg-aqua">
                    <i class="fa fa-user"></i>
                </span>
                    <div class="info-box-content">
                        <span class="info-box-text">本月业绩</span>
                        <span class="info-box-number"><a href="{{route("admin.customer_sales.index")}}">{{isset($performance) ? $performance : '0'}}</a></span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                <span class="info-box-icon bg-red">
                    <i class="fa fa-users"></i>
                </span>
                    <div class="info-box-content">
                        <span class="info-box-text">跟进中达人</span>
                        <span class="info-box-number">{{isset($following_customer_count) ? $following_customer_count : '0'}}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                <span class="info-box-icon bg-green">
                    <i class="fa fa-list"></i>
                </span>
                    <div class="info-box-content">
                        <span class="info-box-text">已跟进达人</span>
                        <span class="info-box-number">{{isset($followed_customer_count) ? $followed_customer_count : '0'}}</span>
                    </div>
                </div>
            </div>

            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                <span class="info-box-icon bg-yellow">
                    <i class="fa fa-keyboard-o"></i>
                </span>

                    <div class="info-box-content">
                        <span class="info-box-text">我的达人总数</span>
                        <span class="info-box-number">{{isset($total_customer) ? $total_customer : '0'}}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(in_array(1,$admin["user"]["role"])) <!--管理员-->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua">
                    <i class="fa fa-user"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">后台用户</span>
                    <span class="info-box-number">{{isset($admin_user_count) ? $admin_user_count : '0'}}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red">
                    <i class="fa fa-users"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">后台角色</span>
                    <span class="info-box-number">{{isset($admin_role_count) ? $admin_role_count : '0'}}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green">
                    <i class="fa fa-list"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">后台菜单</span>
                    <span class="info-box-number">{{isset($admin_menu_count) ? $admin_menu_count : '0'}}</span>
                </div>
            </div>
        </div>

        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow">
                    <i class="fa fa-keyboard-o"></i>
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">操作日志</span>
                    <span class="info-box-number">{{isset($admin_log_count) ? $admin_log_count : '0'}}</span>
                </div>
            </div>
        </div>
    </div>
        @endif
</section>

<script>
    var passwordDanger = {{$password_danger}};
    var sortableChanged = false;
    var sortableIds = [];

    $(function () {

        $('.connectedSortable').sortable({
            placeholder: 'sort-highlight',
            connectWith: '.connectedSortable',
            handle: '.box-header',
            forcePlaceholderSize: true,
            zIndex: 999999,
            update: function (event, ui) {
                sortableChanged = true;
                let ids1 = $('#sortable1').sortable('toArray');
                let ids2 = $('#sortable2').sortable('toArray');
                $.each(ids2, function (index, item) {
                    ids1.push(item);
                });

                sortableIds = ids1;
                console.log(sortableIds);

                /* $.ajax({
                     type: "post",
                     url: "",
                     data: {image_ids},
                     dataType: "json",
                     success: function(result) {
                         window.location.reload(); //后台获取到数据刷新页面
                     }
                 });*/
            }

        });
        $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

        //密码修改检查
        if (parseInt(passwordDanger) === 1) {
            layer.confirm('系统检测到该账户为初始密码，马上去修改？', {title: '风险提示', closeBtn: 1, icon: 7}, function () {
                $.pjax({
                    url: '{{route("admin.admin_user.profile")}}#privacy',
                    container: '#pjax-container'
                });
                layer.closeAll();
            });
        }
    });

</script>
@endsection
