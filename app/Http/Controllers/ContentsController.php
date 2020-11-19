<?php
namespace App\Http\Controllers;
class ContentsController extends Controller
{
    public function termsconditions(){
      	return view('contents.termsconditions');
    }

    public function membershipagreement(){
        return view('contents.membershipagreement');
    }

    public function datapolicies(){
        return view('contents.datapolicies');
    }
   
}

