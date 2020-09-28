<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AppBaseController;


use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Auth;



class TestController extends Controller
{
    public function index(Request $request){
        return view('test.index');
    }


    public function create(Request $request){
        return view('test.create');
    }


    public function edit(Request $request){
        return view('test.create');
    }

}
