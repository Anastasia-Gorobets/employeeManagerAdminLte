<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:only.admin');
    }

    public function index(){
       return view('admin.admin');
   }
    public function index2(){
       return view('admin.admin2');
   }
}
