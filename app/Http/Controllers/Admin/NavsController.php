<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends Controller
{
    //  GET|HEAD | admin/navs 全部分类列表
    public function index()
    {
        $data =navs::orderBy('nav_order','asc')->get();
        return view('admin.navs.index',compact('data'));
    }

    public function changeOrder()
    {
        $input = Input::all();
        $nav = navs::find($input['Id']);
        $nav->nav_order = $input['nav_order'];
        $res = $nav->update();
        if ($res){
            $data = [
                'status' => 0,
                'msg' => '导航排序更新成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '导航排序更新失败！',
            ];
        }
        return $data;
    }

    //  GET|HEAD | admin/navs/create 添加分类
    public function create()
    {
        return view("admin/navs/add");

    }

    //  POST     | admin/navs 添加导航提交
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'nav_name'=>'required',
        ];

        $message = [
            'nav_name.required'=>'导航名称不能为空！',
        ];

        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $res = navs::create($input);
            if ($res){
                return redirect("admin/navs");
            }else{
                return back()->with('errors','数据填充失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }

    }

    //  GET|HEAD | admin/navs/{navs}/edit 编辑导航
    public function edit($Id)
    {
        $field = navs::find($Id);
        return view('admin.navs.edit',compact('field'));
    }

    //  PUT|PATC | admin/navs/{navs} 更新导航
    public function update($Id)
    {
        $input = Input::except('_token','_method');
        $res = navs::where('Id',$Id)->update($input);
        if ($res){
            return redirect('admin/navs');
        }else{
            return back()->with('errors','数据修改失败，请稍后重试！');
        }
    }

    //  DELETE   | admin/navs/{navs} 删除单个导航
    public function destroy($Id)
    {
        $res = navs::where("Id",$Id)->delete();
        if ($res){
            $data = ['status'=>0,'msg'=>'删除成功！'];
        }else{
            $data = ['status'=>1,'msg'=>'删除失败！'];
        }
        return $data;
    }
}
