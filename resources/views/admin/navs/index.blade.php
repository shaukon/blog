@extends("layouts.admin")
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 导航列表
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>导航管理</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>新增导航</a>
                    <a href="{{url('admin/navs')}}"><i class="fa fa-recycle"></i>导航列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>导航名称</th>
                        <th>导航别名</th>
                        <th>导航地址</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$v->Id}})" value="{{$v->nav_order}}">
                        </td>
                        <td class="tc">{{$v->Id}}</td>
                        <td>
                            <a href="#">{{$v->nav_name}}</a>
                        </td>
                        <td>{{$v->nav_alias}}</td>
                        <td>{{$v->nav_src}}</td>
                        <td>
                            <a href="{{url('admin/navs/'.$v->Id.'/edit')}}">修改</a>
                            <a href="javascrit:;" onclick="delnav({{$v->Id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

    <script>
        function changeOrder(obj,Id) {
            var nav_order = $(obj).val();
            $.post("{{url('admin/navs/changeorder')}}",
                {   '_token':'{{csrf_token()}}',
                    'Id':Id,
                    'nav_order':nav_order
                },
                function (data) {
                    if ( 0 == data.status){
                        layer.msg(data.msg, {icon: 6});
                    } else {
                        layer.msg(data.msg, {icon: 5});
                    }

            });
        }

        function delnav($Id) {
            //询问框
            layer.confirm('确认要删除这个导航吗？', {
                btn: ['确认','取消'] //按钮
            }, function(){
                $.post(
                    "{{url('admin/navs')}}/"+$Id,
                    {   '_token':"{{csrf_token()}}",
                        '_method':"delete"
                    },
                    function (data) {
                        if (data.status == 0){
                            location.href = location.href;
                            layer.msg(data.msg, {icon: 6});
                        } else{
                            layer.msg(data.msg, {icon: 5});
                        }
                    }
                );

            }, function () {
                    layer.msg('您点击了取消按钮', {icon: 5});
                }
            );


        }
    </script>
@endsection