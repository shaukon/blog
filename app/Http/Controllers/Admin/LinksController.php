<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    //  GET|HEAD | admin/links 全部分类列表
    public function index()
    {
        $data =Links::orderBy('link_order','asc')->get();
        return view('admin.links.index',compact('data'));
    }

    public function changeOrder()
    {
        $input = Input::all();
        $link = Links::find($input['Id']);
        $link->link_order = $input['link_order'];
        $res = $link->update();
        if ($res){
            $data = [
                'status' => 0,
                'msg' => '链接排序更新成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '链接排序更新失败！',
            ];
        }
        return $data;
    }

    //  GET|HEAD | admin/links/create 添加分类
    public function create()
    {
        $data = [];
        return view("admin/links/add",compact('data'));

    }

    //  POST     | admin/links 添加链接提交
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'link_name'=>'required',
        ];

        $message = [
            'link_name.required'=>'链接名称不能为空！',
        ];

        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $res = Links::create($input);
            if ($res){
                return redirect("admin/links");
            }else{
                return back()->with('errors','数据填充失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }

    }

    //  GET|HEAD | admin/links/{links}/edit 编辑链接
    public function edit($Id)
    {
        $field = Links::find($Id);
        return view('admin.links.edit',compact('field'));
    }

    //  PUT|PATC | admin/links/{links} 更新链接
    public function update($Id)
    {
        $input = Input::except('_token','_method');
        $res = Links::where('Id',$Id)->update($input);
        if ($res){
            return redirect('admin/links');
        }else{
            return back()->with('errors','数据修改失败，请稍后重试！');
        }
    }

    //  DELETE   | admin/links/{links} 删除单个链接
    public function destroy($Id)
    {
        $res = Links::where("Id",$Id)->delete();
        if ($res){
            $data = ['status'=>0,'msg'=>'删除成功！'];
        }else{
            $data = ['status'=>1,'msg'=>'删除失败！'];
        }
        return $data;
    }
}
