@extends('admin.layouts.dashboard_v3')
@section('content1')

<br><br>










  <div class="content__inner">

                    <div class="card">
                        <div class="card-body">
                        <div class="row">
                        
                                <div class="col-md-10">
                                       <div class="form-group">
                                            <label> <h4 class="card-title">Profile</h4></label>
                                        </div>
                                    </div>
                        
                                <div class="col-md-2">
                                       <div class="form-group">
                                            <label><button type="button" name="back" class="btn btn-primary btn-sm"><a href="profile-update" style="color: white !important;"> Edit</a></button> </label>
                                        </div>
                                    </div>
                        
                        </div>
                            
                            <hr>
                     
                             
                                    
                                      
                              @if ($users->pro_img != '')                                                

 <div class="row">
                                <div class="col-md-5">
                                       <div class="form-group">
                                            <label> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                       <div class="form-group">
                                       <img alt="image" class="rounded-circle" src="{{ @$users->pro_img }}" style="height: 100px;width: 100px;">    

                                       
                               
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                
                               <hr>                               
                       @endif 
                                <div class="row">
                                <div class="col-md-3">
                                       <div class="form-group">
                                            <label><b>Name</b> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                       <label>{{ @ucwords($users->name) }} </label>                       
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="row">
                                <div class="col-md-3">
                                       <div class="form-group">
                                            <label><b>Email</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                        <label>{{ @Auth::user()->email }}</label>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="row">
                                <div class="col-md-3">
                                       <div class="form-group">
                                            <label><b>Your Role</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                        <label>{{ $users->position }}</label>                        </div>
                                    </div>
                                </div>
                                 
                                 
                                
 <hr>                                  
 
 
                             

                        </div>
                    </div>

                </div>
              
<br><br><br><br>
@stop