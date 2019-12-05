<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table='category';
    protected $primaryKey='Id';
    public $timestamps=false;
    protected $guarded = [];

    public function tree()
    {
        $data = $this->orderBy('cate_order','asc')->get();
        $data = $this->getTree($data,'cate_name','Id','cate_pid');
        return $data;
    }

    public function getTree($data,$field_name,$field_id='id',$field_pid='pid',$pid=0)
    {
        $treeData = array();
        foreach ($data as $k =>$v){
            if ($v['cate_pid'] == 0){
                $data[$k]['_cate_name'] = $data[$k]['cate_name'];
                $treeData[] = $data[$k];
                foreach ($data as $m => $n){
                    if ($n['cate_pid'] == $v['Id']){
                        $data[$m]['_cate_name'] = "|--".$data[$m]['cate_name'];
                        $treeData[] = $data[$m];
                    }
                }
            }
        }

        return $treeData;


    }
}
