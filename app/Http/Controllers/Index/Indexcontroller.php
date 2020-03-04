<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Indexcontroller extends Controller
{
        //页面方法
        public function index(){
            return view('index/index');
        }
}
