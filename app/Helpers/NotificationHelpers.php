<?php
namespace App\Helpers;
use Illuminate\Http\Request;
use DB; 
use Illuminate\Support\Facades\Auth;
use App\model\User_notifications;
class NotificationHelpers 
{
	
  static function add_notification($user_id,$mesage_type,$url="")
    {
         $user_id=Auth::user()->id;
         $teams_id=Auth::user()->teams_id;
       

            if(is_numeric($teams_id)&&is_numeric($mesage_type)){				
            
                if($mesage_type=="1"){
                    $notification=env('NEW_USER_MESSAGE');
            //        $url='my-team';
                }
                if($mesage_type=="2"){
                    $notification=env('NEW_DATASOURCE_MESSAGE');
              //      $url='my-connections';
                }
				$users = DB::table('users')               
			   ->select('users.id')
               ->where([['users.is_active','=','1'],['users.teams_id','=',$teams_id]])
               ->get();
				foreach($users as $users_row){
					$users_row->id ;
					$d_in[]=array(
						'user_id'=>$users_row->id ,
						'notification'=>$notification,
						'url'=>$url,					
					);
				}
				if(isset($d_in)&&(is_array($d_in))){
					User_notifications::insert($d_in);
				}
			}

       
        
    }
}
