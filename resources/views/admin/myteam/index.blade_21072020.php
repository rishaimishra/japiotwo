@extends('admin.layouts.dashboard_v3')
@section('content1')
<br></br>
<div class="content__inner">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">My Team</h4>
                            <hr>
                            <form method="post" action="{{ url('/my-team') }}">
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
                                    
                                    @if(Auth::user()->role_id!="2")
                                        @if($subscription_plans->max_team_size==$member_reached)
                                            <div class="row">
                                         <div class="col-md-12">
                                           <b> You have reached maximum number of user in this plan <b>
                                           <button type="button" name="back" class="btn btn-primary btn-sm"><a href="upgrade-plan" style="color: white !important;"> UPGRADE</a></button> plan
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
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button type="submit" name="send" class="btn btn-primary btn-sm">Send</button>
                                        </div>
                                    </div>
                                </div>

                                <hr> @endif
                                @endif
 <div class="row">
           <div class="table-responsive data-table">
                                <table id="data-table" class="table">
                                    <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th> Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        
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
                                        
                                        </tr> 
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
</div>
                            </form>

                        </div>
                    </div>

                </div>

@stop