<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
//  GET|HEAD | admin/category 全部分类列表
    public function index()
    {
        $categorys = (new Category())->tree();
        return view("admin.category.index")->with('data',$categorys);
        
    }

    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['Id']);
        $cate->cate_order = $input['cate_order'];
        $res = $cate->update();
        if ($res){
            $data = [
                'status' => 0,
                'msg' => '分类排序更新成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '分类排序更新失败！',
            ];
        }
        return $data;
    }


//  GET|HEAD | admin/category/create 添加分类
    public function create()
    {
        $data = Category::where('cate_pid',0)->get();
        return view("admin/category/add",compact('data'));

    }

    //  POST     | admin/category 添加分类提交
    public function store()
    {
        $input = Input::except('_token');
//        dd($input);
        $rules = [
            'cate_name'=>'required',
        ];

        $message = [
            'cate_name.required'=>'分类名称不能为空！',
        ];

        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $res = Category::create($input);
            if ($res){
                return redirect("admin/category");
            }else{
                return back()->with('errors','数据填充失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }

    }


    //  GET|HEAD | admin/category/{category}/edit 编辑分类
    public function edit($Id)
    {
        $field = Category::find($Id);
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.edit',compact('field','data'));
    }

    //  PUT|PATC | admin/category/{category} 更新分类
    public function update($Id)
    {
        $input = Input::except('_token','_method');
        $res = Category::where('Id',$Id)->update($input);
        if ($res){
            return redirect('admin/category');
        }else{
            return back()->with('errors','数据修改失败，请稍后重试！');
        }
    }

//  GET|HEAD | admin/category/{category} 显示单个分类信息
    public function show()
    {
        echo "show1";
    }

//  DELETE   | admin/category/{category} 删除单个分类
    public function destroy($Id)
    {
        $res = Category::where("Id",$Id)->delete();
        //如果删除的是顶级，有子集。则子集升级。
        Category::where("cate_pid",$Id)->update(['cate_pid'=>0]);
        if ($res){
            $data = ['status'=>0,'msg'=>'删除成功！'];
        }else{
            $data = ['status'=>1,'msg'=>'删除失败！'];
        }
        return $data;
    }


}
