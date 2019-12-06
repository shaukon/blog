@extends("layouts.admin")
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/index')}}">首页</a> &raquo; 配置项管理
    </div>
    <!--面包屑配置项 结束-->

    <!--搜索结果页面 列表 开始-->

        <div class="result_wrap">
            <div class="result_title">
                <h3>配置项列表</h3>
                @if(count($errors)>0)
                    <div class="mark">
                        @if(is_object($errors))
                            @foreach($errors->all() as $error)
                                <p>{{$error}}</p>
                            @endforeach
                        @else
                            <p>{{$errors}}</p>
                        @endif
                    </div>
                @endif
            </div>
            <!--快捷配置项 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/conf/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                    <a href="{{url('admin/conf')}}"><i class="fa fa-recycle"></i>配置项列表</a>
                </div>
            </div>
            <!--快捷配置项 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <form action="{{url('admin/conf/changecontent')}}" method="post">
                    {{csrf_field()}}
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>标题</th>
                        <th>名称</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <input type="hidden" name="Id[]" value="{{$v->Id}}">
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$v->Id}})" value="{{$v->conf_order}}">
                        </td>
                        <td class="tc">{{$v->Id}}</td>
                        <td>
                            <a href="#">{{$v->conf_title}}</a>
                        </td>
                        <td>{{$v->conf_name}}</td>
                        <td>{!! $v->_html !!}</td>
                        <td>
                            <a href="{{url('admin/conf/'.$v->Id.'/edit')}}">修改</a>
                            <a href="javascrit:;" onclick="delconf({{$v->Id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach

                </table>
                <div class="btn_group">
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回" >
                </div>
                </form>
            </div>
        </div>
    <!--搜索结果页面 列表 结束-->

    <script>
        function changeOrder(obj,Id) {
            var conf_order = $(obj).val();
            $.post("{{url('admin/conf/changeorder')}}",
                {   '_token':'{{csrf_token()}}',
                    'Id':Id,
                    'conf_order':conf_order
                },
                function (data) {
                    if ( 0 == data.status){
                        layer.msg(data.msg, {icon: 6});
                    } else {
                        layer.msg(data.msg, {icon: 5});
                    }

            });
        }

        function delconf($Id) {
            //询问框
            layer.confirm('确认要删除这个配置项吗？', {
                btn: ['确认','取消'] //按钮
            }, function(){
                $.post(
                    "{{url('admin/conf')}}/"+$Id,
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