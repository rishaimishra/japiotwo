<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use App\User;
class ProfileController extends Controller
{
        public function __construct()
    {
         $page_data = ['menu_selected'=>'profile','header'=>'list'];    
         $this->page_data=$page_data;         
        $this->middleware('auth');
    }
    public function index(Request $request){
        $page_data=$this->page_data;
        if (Auth::check()) {
            $auth_id=Auth::user()->id;
            $users = DB::table('users')
               ->select('users.name','users.email','users.position','users.pro_img','users.password')
               ->where([['users.id','=',$auth_id]])
               ->first();
             return view('admin.user.profile',compact('page_data','users'));          
        }
    }
    public function pro_edit(Request $request){
        $page_data=$this->page_data;
        if (Auth::check()) {
           // $request->session()->flash('success1', '');
            //$request->session()->flash('success2', '');
           // $request->session()->flash('success3', '');
            //$request->session()->flash('error1', '');
            //$request->session()->flash('error2', '');
            //$request->session()->flash('error3', '');
            $auth_id=Auth::user()->id;
            $users = DB::table('users')
               ->select('users.name','users.email','users.position','users.pro_img','users.password')
               ->where([['users.id','=',$auth_id]])
               ->first();
            
            if($request->input('update1')=="update"){
                $file=$request->file('profile_img_update');
                
                request()->validate([

                    'profile_img_update' => 'required|image|max:1024',

                ]);
                        
                
                if(!empty($request->file('profile_img_update'))){
                    $destinationPath = 'img/profile_img';
                    $img_name=md5(time().$file->getClientOriginalName()).".".$file->getClientOriginalExtension();
                    $file->move($destinationPath,$img_name);
                    $us_update = User::find($auth_id);
                    $us_update->pro_img = $destinationPath.'/'.$img_name;
                    $us_update->save();
                    $request->session()->flash('success1', 'Successfully updated');
                    return redirect('profile-update#1');        
                } 
            } else
            if($request->input('update2')=="update"){              
                $us_update = User::find($auth_id);
                $us_update->name = $request->input('name');
                $us_update->position = $request->input('destination');
                $us_update->save();                
                $request->session()->flash('success2', 'Successfully updated');
                return redirect('profile-update#2');        
            }
            if($request->input('update3')=="update"){
                
               
                if (Hash::check($request->input('current_password'), $users->password)) { 
                    if($request->input('password')==$request->input('repassword')){
                        $us_update = User::find($auth_id);
                        $us_update->password = Hash::make($request->input('password'));
                        $us_update->save();
                           $request->session()->flash('success3', 'Successfully updated');
                           return redirect('profile-update#3');        
                    } else{
                         $request->session()->flash('error3', 'Password and Re-Password does not match');
                    return redirect('profile-update#3');        
                    }
                } else {
                    $request->session()->flash('error3', 'You have enter wrong password, Please try again');
                    return redirect('profile-update#3');        
                }
                
                
               /*  if(Hash::make($request->input('current_password'))!=$users->password){
                    $request->session()->flash('error3', 'You have enter wrong password, Please try again');
                    return redirect('profile-update#3');        
                } else
                if($request->input('password')==$request->input('repassword')){
                    $us_update = User::find($auth_id);
                    $us_update->password = Hash::make($request->input('password'));
                    $us_update->save();
                       $request->session()->flash('success3', 'Successfully updated');
                       return redirect('profile-update#3');        
                } else{
                    $request->session()->flash('error3', 'Password and Re-Password does not match');
                    return redirect('profile-update#3');        
                } */
                
            }            
            $users = DB::table('users')
               ->select('users.name','users.email','users.position','users.pro_img','users.password')
               ->where([['users.id','=',$auth_id]])
               ->first();
             
            return view('admin.user.profile_update',compact('page_data','users'));        
            
               
               
        }
    }
}
