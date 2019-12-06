@extends("layouts.admin")
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 友情链接列表
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>链接管理</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>新增链接</a>
                    <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>链接列表</a>
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
                        <th>链接名称</th>
                        <th>链接标题</th>
                        <th>链接地址</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$v->Id}})" value="{{$v->link_order}}">
                        </td>
                        <td class="tc">{{$v->Id}}</td>
                        <td>
                            <a href="#">{{$v->link_name}}</a>
                        </td>
                        <td>{{$v->link_title}}</td>
                        <td>{{$v->link_src}}</td>
                        <td>
                            <a href="{{url('admin/links/'.$v->Id.'/edit')}}">修改</a>
                            <a href="javascrit:;" onclick="delLink({{$v->Id}})">删除</a>
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
            var link_order = $(obj).val();
            $.post("{{url('admin/links/changeorder')}}",
                {   '_token':'{{csrf_token()}}',
                    'Id':Id,
                    'link_order':link_order
                },
                function (data) {
                    if ( 0 == data.status){
                        layer.msg(data.msg, {icon: 6});
                    } else {
                        layer.msg(data.msg, {icon: 5});
                    }

            });
        }

        function delLink($Id) {
            //询问框
            layer.confirm('确认要删除这个链接吗？', {
                btn: ['确认','取消'] //按钮
            }, function(){
                $.post(
                    "{{url('admin/links')}}/"+$Id,
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