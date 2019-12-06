@extends("layouts.admin")
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 所有分类列表
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    {{--<div class="search_wrap">
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="">全部</option>
                            <option value="http://www.baidu.com">百度</option>
                            <option value="http://www.sina.com">新浪</option>
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>--}}
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>分类管理</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>新增分类</a>
                    <a href="{{url('admin/category')}}"><i class="fa fa-recycle"></i>分类列表</a>
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
                        <th>分类名称</th>
                        <th>标题</th>
                        <th>查看次数</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$v->Id}})" value="{{$v->cate_order}}">
                        </td>
                        <td class="tc">{{$v->Id}}</td>
                        <td>
                            <a href="#">{{$v->_cate_name}}</a>
                        </td>
                        <td>{{$v->cate_title}}</td>
                        <td>{{$v->cate_view}}</td>
                        <td>
                            <a href="{{url('admin/category/'.$v->Id.'/edit')}}">修改</a>
                            <a href="javascrit:;" onclick="delCate({{$v->Id}})">删除</a>
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
            var cate_order = $(obj).val();
            $.post("{{url('admin/cate/changeorder')}}",
                {   '_token':'{{csrf_token()}}',
                    'Id':Id,
                    'cate_order':cate_order
                },
                function (data) {
                    if ( 0 == data.status){
                        layer.msg(data.msg, {icon: 6});
                    } else {
                        layer.msg(data.msg, {icon: 5});
                    }

            });
        }

        function delCate($Id) {
            //询问框
            layer.confirm('确认要删除这个分类吗？', {
                btn: ['确认','取消'] //按钮
            }, function(){
                $.post(
                    "{{url('admin/category')}}/"+$Id,
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