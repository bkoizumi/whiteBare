<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class ReminderController extends Controller
{
 /**
     * Display a listing of the user operation.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       return view('reminder');
    }


}
