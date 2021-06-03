<!--空白弹出页面参考模版-->
@include('admin.public.head_css')
@include('admin.public.head_js')

<!-- 这里写内容即可 -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body table-responsive">
                <table id="datalist" class="table table-hover table-bordered datatable" width="100%">
                    <thead>

                    <tr>
                        <th>字段名</th>
                        <th>类型</th>
                        <th>排序规则</th>
                        <th>是否为空</th>
                        <th>是否为主键</th>
                        <th>默认值</th>
                        <th>更多信息</th>
                        <th>备注</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td>{{$item['name']}}</td>
                        <td>{{$item['type']}}</td>
                        <td>{{$item['collation']}}</td>
                        <td>{{$item['null']}}</td>
                        <td>{{$item['key']}}</td>
                        <td>{{$item['default']}}</td>
                        <td>{{$item['extra']}}</td>
                        <td>{{$item['comment']}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>