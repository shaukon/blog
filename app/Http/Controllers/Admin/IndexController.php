<?php
/**
 * Created by PhpStorm.
 * User: 52818
 * Date: 2019/11/29
 * Time: 14:28
 */

namespace App\Http\Controllers\Admin;



class IndexController extends CommonController
{
    public function index(){
        echo route('profile');
        echo 1231;
    }

}