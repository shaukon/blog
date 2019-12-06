<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends CommonController
{
    public function index()
    {
        return view('home.index');
    }
    public function lists()
    {
        return view('home.list');
    }
    public function news()
    {
        return view('home.new');
    }
}
