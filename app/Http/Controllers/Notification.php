<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB; 
use NotifiFinder;
use Illuminate\Support\Facades\Auth;
use DateTime;
class Notification extends Controller
{
    public function change_notification_status(){
		$user_id=Auth::user()->id;
		       DB::update("update user_notifications set is_read = 1 where user_id = ?", [$user_id]);
	}
     public function redirect(Request $request, $id=false){
         $users = DB::table('user_notifications')               
			   ->select('user_notifications.id','user_notifications.user_id', 'user_notifications.notification','user_notifications.url','user_notifications.is_read','user_notifications.created_at')
               ->where([['user_notifications.id','=',$id]])               
               ->first();
               DB::update("update user_notifications set is_read = 1 where id = ?", [$users->id]);
        
         return redirect($users->url);    
         
     }
    public function index(Request $request, $id=false){
   
        $user_id=Auth::user()->id;
		
		$users_total = DB::table('user_notifications')               
			   ->select('user_notifications.id','user_notifications.user_id', 'user_notifications.notification','user_notifications.url','user_notifications.is_read','user_notifications.created_at')
               ->where([['user_notifications.user_id','=',$user_id]])
               ->where([['user_notifications.is_read','=','0']])
			   ->orderBy('id', 'DESC')               
               ->get();
		
        $users = DB::table('user_notifications')               
			   ->select('user_notifications.id','user_notifications.user_id', 'user_notifications.notification','user_notifications.url','user_notifications.is_read','user_notifications.created_at')
               ->where([['user_notifications.user_id','=',$user_id]])
			   ->orderBy('id', 'DESC')
               ->limit('10')
               ->get();
               $data_user="";
				foreach($users as $users_row){     
				$time_ago="";
				$firstDate  = new DateTime($users_row->created_at);
				$secondDate = new DateTime(date("Y-m-d H:i:s"));
				$intvl = $firstDate->diff($secondDate);
				if($intvl->y!="0"){
					$time_ago=$intvl->y." Year";
					if($intvl->m>"183"){
						$time_ago=($intvl->y+1)." Year";
					}
				} else if($intvl->m!="0"){
					$time_ago=$intvl->m." Month";
					if($intvl->d>"15"){
						$time_ago=($intvl->m+1)." Month";
					}
				} else if($intvl->d!="0"){
					$time_ago=$intvl->d." Day";
					if($intvl->h>"13"){
						$time_ago=($intvl->d+1)." Day";
					}
				} else if($intvl->h!="0"){
					$time_ago=$intvl->h." Hour";
					if($intvl->i>"31"){
						$time_ago=($intvl->h+1)." Hour";
					}
				} else if($intvl->i!="0"){
					$time_ago=$intvl->i." Min";
					if($intvl->s>"31"){
						$time_ago=($intvl->s+1)." Min";
					}
				} else if($intvl->s!="0"){
					$time_ago=$intvl->s." Sec";
				} 
				/* 
				if($intvl->y!="0"){
					$time_ago.=$intvl->y." Year";
				}
				if($intvl->m!="0"){
					$time_ago.=" ".$intvl->m." Month";
				}
				if($intvl->d!="0"){
					$time_ago.=" ".$intvl->d." Day";
				}
				if($intvl->h!="0"){
					$time_ago.=" ".$intvl->h." Hours";
				}
				if($intvl->i!="0"){
					$time_ago.=" ".$intvl->i." Min";
				}
				if($intvl->s!="0"){
					$time_ago.=" ".$intvl->s." Sec";
				} */
				$time_ago.=" ago";

					if($users_row->url==""){
						$url="javascript:void(0)";
					} else{
						$url=$users_row->url;
					}
				
                   $data_user.= "<li  style='height: 40px;'>
                            <a href='$url' class='dropdown-item'>
                                <div>
                                    $users_row->notification
                                    <span class='float-right text-muted small'>$time_ago</span>
                                </div>
                            </a>
                        </li>
                        <li class='dropdown-divider'></li>
                        ";
                }
				
				$t_num=count($users_total);
				
				$data['total_num']=$t_num;
				$data['data']=$data_user;
				
			echo	json_encode($data);
				
    }
}
