<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //
    public function upload()
    {
        $file = Input::file('Filedata');
        if ($file->isValid()){
            $entension = $file->getClientOriginalExtension();//长传文件的后缀
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path =$file->move(base_path().'/uploads',$newName);
            $filePath = 'uploads/'.$newName;
            return $filePath;
        }
    }















}
