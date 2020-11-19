<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $page_data = ['menu_selected'=>'home','header'=>'list'];    
        $this->page_data=$page_data;
        
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_data=$this->page_data;
        if (Auth::check()) {
          return view('home',compact('page_data'));  
        // The user is logged in...
        } else {
          
        }
    }
}
