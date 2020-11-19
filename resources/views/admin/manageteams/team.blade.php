@extends('admin.layouts.dashboard_v3')
@section('content1')
<style>
.swal2-styled.swal2-confirm {
    background-color: #633141 !important;
    
    
}
</style> 
 <script type="text/javascript">

                function activatedeleteuser(id,name,is_active,status,u_id,t_id)
                { 
                  
                   var url = '{{ route("user-activate-delete-re", [":id",":is_active",":u_id",":t_id"]) }}';

 

                    url = url.replace(':id',id);
                    url = url.replace(':is_active',is_active);
                    url = url.replace(':u_id',u_id);
                    url = url.replace(':t_id',t_id);

                   var ids=id;
                    Swal.fire({
                      title: 'Are you sure to '+status+' user '+name+'?',
                      text: '',
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonText: 'Yes, '+status+' it!',
                      cancelButtonText: 'No, keep it'
                    }).then((result) => {

                             if (result.value) {
                        window.location.href = url;        
                            } else {
                        
                            }
                    
                    }
)
                }
                </script>
<br>
<div class="text-right pb-3">
    <a href="{{ url('team-list') }}">
    <button class="btn btn-primary m-t" type="button"><i class="fa fa-step-backward"></i> Back to Teams</button>
    </a>
</div>
<div class="content__inner">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $teamList[0]->team_name }}::Team Members</h4>
                            <hr>
                            <form method="post" action="<?php echo url("/team-members/$team_id"); ?>">
                              @csrf
                                    @if(Session::has('success'))
                                        <div class="alert alert-success col-md-12" role="alert">   
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>        
                                    {{ Session::get('success') }}

                                        </div>
                                    @endif
                                    @if(Session::has('error'))
                                        <div class="alert alert-danger  col-md-12" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                    {{ Session::get('error') }}
                                        </div>
                                    @endif
                                    
                                    
                             @if($subscription_plans->max_team_size<$member_reached)
                                            <div class="row">
                                         <div class="col-md-12">
                                           <b> You have reached maximum number of user in this plan <b>
                                         
                                           </div>
                                           </div><hr>
                                         @else   
                                    
                                  <div class="row">
                                    
                                <div class="col-md-4">
                                       <div class="form-group">
                                            <label>Enter Email to invite someone in team</label>
                                          
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          
                                            <input type="email" name="email_id" id="email_id" class="form-control" required>
                                        </div>
                                    </div>
                                    
                                </div>


 <div class="hr-line-dashed"></div>
 <div class="row">
                                    
                                <div class="col-md-4">
                                       <div class="form-group">
                                            <label>User's Role</label>
                                          
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                        <select class="form-control m-b" name="role_id">
                                            <?php
                                            foreach($roles as $teamRole){
                                            ?>
                                                <option value="{{$teamRole->id}}">{{$teamRole->description}}</option>
                                            <?php
                                            }
                                            ?>
                                          </select>

                                        </div>
                                    </div>
                                    
                                </div>
                                 <div class="hr-line-dashed"></div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button type="submit" name="send" class="btn btn-primary btn-sm">Send</button>
                                        </div>
                                    </div>
                                    </div>
                                <hr> @endif
   <?php if(($member_reached!="0")&& isset($teamList[0]->user_invitation_id) && is_numeric($teamList[0]->user_invitation_id) ){ //exit;?>                           
 <div class="row">
           <div class="table-responsive data-table">
                                <table id="data-table" class="table">
                                    <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th> Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                      <?php  
                                      $hide_or_show="0";
                                          foreach ($teamList as $team_v){
                                              if($team_v->is_acepted=="1"){
                                                  $hide_or_show="1";
                                              }
                                          }
                                      
                                      if((Auth::user()->role_id != '2') && ($hide_or_show=="1")) { ?> 
                                                                                
                                        <th>Action</th>
                                      <?php }?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                          @foreach ($teamList as $team)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $team->name }}</td>
                                            <td>{{ $team->email_id }}</td>
                                            <td>                                            
                                            @if($team->is_acepted == '1')
                                                       <p>Acepted</p>
                                                 @else
                                                       <p>pending</p>
                                                   @endif
                                            </td> 
                                            <?php if((Auth::user()->role_id != '2')&&($team->is_acepted=="1")){  ?>
                                            <td>   
<?php $users_created_id=0;if(is_numeric($team->users_created_id)){$users_created_id=$team->users_created_id;}?>                                            
                                            @if($team->is_active == '1')
                                                <a  onclick="activatedeleteuser('{{ $team->id }}','{{ $team->email_id }}','0','Deactivate','{{ $users_created_id }}' ,'{{ $team_id }}')"  type="button" class="btn btn-primary btn-sm" style="color: white !important;">Deactivate</a>
                                                      
                                                 @else
                                                      <a  onclick="activatedeleteuser('{{ $team->id }}','{{ $team->email_id }}','1','Activate','{{ $users_created_id }}' ,'{{ $team_id }}')"  type="button" class="btn btn-primary btn-sm" style="color: white !important;">Activate</a>
                                               
                                                    
                                                   @endif
                                            </td>
                                            <?php }?>
                                        </tr> 
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
</div>
   <?php }?>
                            </form>

                        </div>
                    </div>

                </div>

@stop