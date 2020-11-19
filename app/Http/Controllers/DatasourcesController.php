<?php
namespace App\Http\Controllers;
use Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;

class DatasourcesController extends Controller
{
     public function __construct()
    {
         $page_data = ['menu_selected'=>'datasources','header'=>'list'];    
         $this->page_data=$page_data;
         
        $this->middleware('auth');
    }
    
    
    public function index(Request $request){
        $user = auth()->user()->role_id;
       
        $page_data=$this->page_data;
        $auth_id=Auth::user()->id;
        
        if (Auth::check()) {

            $data_sources = DB::table('data_sources')                    
                ->leftJoin('user_connectors', function ($join) use($auth_id)  {             $join->on('user_connectors.id_connector', '=', 'data_sources.id')->where('user_connectors.user_id', '=', $auth_id);             })                          
                ->select('data_sources.id','data_sources.provider', 'data_sources.name','data_sources.connection_img','user_connectors.user_id')
                ->where([['data_sources.active','=','1']])
                ->orderBy('provider')
                ->get();

          return view('admin.datasources.index',compact('page_data','data_sources','auth_id'));
        
        } else {
              
        }
    }
}
