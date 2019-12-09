<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends CommonController
{
    public function index()
    {
        //点击量最高的6篇文章（站长推荐）
        $pics = Article::orderBy('art_view','desc')->take(6)->get();

        //图文列表5篇（带分页）
        $data = Article::orderBy('art_time','desc')->paginate(5);

        //友情链接
        $links = Links::orderBy('link_order','asc')->get();

        //网站配置项


        return view('home.index',compact('pics','data','links'));
    }
    public function cate($Id)
    {
        $field = Category::find($Id);
        //查看次数自增
        Category::where('Id',$Id)->increment('cate_view',1);

        //图文列表5篇（带分页）
        $data = Article::where('cate_id',$Id)->orderBy('art_time','desc')->paginate(5);

        //当前分类的子分类
        $submenu = Category::where('cate_pid',$Id)->get();

        return view('home.list',compact('field','data','submenu'));
    }
    public function article($Id)
    {
        $field = Article::join('category','article.cate_id','=','category.Id')->where('article.Id',$Id)->first();
        //查看次数自增
        Article::where('Id',$Id)->increment('art_view',1);

        $article['pre'] = Article::where('Id','<',$Id)->where('cate_id',$field->cate_id)->orderBy('Id','desc')->first();
        $article['next'] = Article::where('Id','>',$Id)->where('cate_id',$field->cate_id)->orderBy('Id','asc')->first();

        $data = Article::where('cate_id',$field->cate_id)->orderBy('Id','desc')->take(6)->get();
        return view('home.new',compact('field','article','data'));
    }



























}
