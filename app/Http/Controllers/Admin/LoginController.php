<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;

require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    public function login()
    {
        return view('admin.login');
    }

    public function code()
    {
        $code = new \Code;
        $code->make();
    }

    public function getCode()
    {
        $code = new \Code;
        echo $code->get();
    }
}
