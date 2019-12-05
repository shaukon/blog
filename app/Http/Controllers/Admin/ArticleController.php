<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    //  GET|HEAD | admin/article 全部文章列表
    public function index()
    {
        $data = Article::orderBy('Id','desc')->paginate(5);
        return view('admin.article.index',compact('data'));
    }

    //  GET|HEAD | admin/article/create 添加文章
    public function create()
    {
        $data = (new Category())->tree();
        return view("admin/article/add",compact('data'));

    }

    //  POST     | admin/article 添加文章提交
    public function store()
    {
        $input = Input::except('_token');
        $input['art_time'] = time();

        $rules = [
            'art_title'=>'required',
            'art_content'=>'required',
        ];

        $message = [
            'art_title.required'=>'文章标题不能为空！',
            'art_content.required'=>'文章内容不能为空！',
        ];

        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $res = Article::create($input);
            if ($res){
                return redirect("admin/article");
            }else{
                return back()->with('errors','文章添加失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }

    }

    //  GET|HEAD | admin/article/{article}/edit 编辑文章
    public function edit($Id)
    {
        $field = Article::find($Id);
        $data = (new Category())->tree();
        return view('admin.article.edit',compact('field','data'));
    }
    //  PUT|PATC | admin/article/{article} 更新文章
    public function update($Id)
    {
        $input = Input::except('_token','_method');
        $res = Article::where('Id',$Id)->update($input);
        if ($res){
            return redirect('admin/article');
        }else{
            return back()->with('errors','数据修改失败，请稍后重试！');
        }
    }

    //  DELETE   | admin/article/{article} 删除单个文章
    public function destroy($Id)
    {
        $res = Article::where("Id",$Id)->delete();
        if ($res){
            $data = ['status'=>0,'msg'=>'删除成功！'];
        }else{
            $data = ['status'=>1,'msg'=>'删除失败！'];
        }
        return $data;
    }


}
