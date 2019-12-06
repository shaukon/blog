<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\conf;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    //  GET|HEAD | admin/conf 全部配置列表
    public function index()
    {
        $data =conf::orderBy('conf_order','asc')->get();
        foreach ($data as $k=>$v){
            switch ($v->field_type){
                case 'input' :
                    $data[$k]->_html = "<input type='text' name='conf_content[]' class='lg' value='".$v->conf_content."'>";
                    break;
                case 'textarea' :
                    $data[$k]->_html = "<textarea type='text' name='conf_content[]' class='lg' >".$v->conf_content."</textarea>";
                    break;
                case 'radio' :
//                    1|开启,0|关闭
                    $arr = explode(',',$v->field_value);
                    $str = '';
                    //1|开启
                    foreach ($arr as $m=>$n){
                        $a = explode('|',$n);
                        //  0 => "1"
                        //  1 => "开启"
                        $check = $a[0] == $v->conf_content ? 'checked' : '';
                        $str .= "<input type='radio' name='conf_content[]' value='$a[0]' $check > $a[1] &nbsp;";

                    }
                    $data[$k]->_html = $str;
                    break;
            }
        }
        return view('admin.conf.index',compact('data'));
    }

    //修改网站配置内容
    public function changeContent()
    {
        $input = Input::all();
        foreach ($input['Id'] as $k => $v){
            Conf::where('Id',$v)->update(['conf_content'=> $input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->withErrors("修改配置成功");
    }

    //从数据库读取网站配置到配置文件
    public function putFile()
    {
        $config = Conf::pluck('conf_content','conf_name')->all();
        $path = base_path()."\config\web.php";
        $str = "<?php  return ".var_export($config,true).";";
        $res = file_put_contents($path,$str);
    }

    public function changeOrder()
    {
        $input = Input::all();
        $conf = conf::find($input['Id']);
        $conf->conf_order = $input['conf_order'];
        $res = $conf->update();
        if ($res){
            $data = [
                'status' => 0,
                'msg' => '配置排序更新成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '配置排序更新失败！',
            ];
        }
        return $data;
    }

    //  GET|HEAD | admin/conf/create 添加配置

    public function create()
    {
        return view("admin/conf/add");

    }

    //  POST     | admin/conf 添加配置提交
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'conf_name'=>'required',
            'conf_title'=>'required',
        ];

        $message = [
            'conf_name.required'=>'名称不能为空！',
            'conf_title.required'=>'标题不能为空！',
        ];

        $validator = Validator::make($input,$rules,$message);

        if($validator->passes()){
            $res = conf::create($input);
            if ($res){
                $this->putFile();
                return redirect("admin/conf");
            }else{
                return back()->with('errors','数据填充失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }

    }

    //  GET|HEAD | admin/conf/{conf}/edit 编辑配置
    public function edit($Id)
    {
        $field = conf::find($Id);
        return view('admin.conf.edit',compact('field'));
    }

    //  PUT|PATC | admin/conf/{conf} 更新配置
    public function update($Id)
    {
        $input = Input::except('_token','_method');
        $res = conf::where('Id',$Id)->update($input);
        if ($res){
            $this->putFile();
            return redirect('admin/conf');
        }else{
            return back()->with('errors','数据修改失败，请稍后重试！');
        }
    }

    //  DELETE   | admin/conf/{conf} 删除单个配置
    public function destroy($Id)
    {
        $res = conf::where("Id",$Id)->delete();
        if ($res){
            $this->putFile();
            $data = ['status'=>0,'msg'=>'删除成功！'];
        }else{
            $data = ['status'=>1,'msg'=>'删除失败！'];
        }
        return $data;
    }

    public function show()
    {
        echo 'show';
    }
}
