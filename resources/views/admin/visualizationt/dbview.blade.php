@extends('admin.layouts.dashboard_v3')
@section('content1')
<br>
<style>
.tooltip {
  position: relative;
  display: inline-block;
 
  opacity: 1;
}
.tooltip .tooltiptext {
  visibility: hidden;
  width: 236px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 5px;
  
  /* Position the tooltip */
  position: absolute;
  z-index: 1;
  top: -5px;
  right: 105%;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}
</style>
@if (Session::has('message'))
       <div class="alert alert-success  col-md-12" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                            {!! Session::get('message') !!}
                                 </div>
                            @endif

<?php 
//if ($request->session()->get('sess_data')!=""){
?>
    @if(@$err!="")
                                        <div class="alert alert-danger  col-md-12" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
											{{ @$err }}
 <?php //echo $request->session()->get('sess_data');?>
                                        </div>
                                    
<?php //} ?>
  @endif
 <div class="wrapper wrapper-content animated fadeIn" style="padding-right: 0px !important;">

 
            <div class="row">
			
                <div class="col-lg-12" >
				<div class="ibox " style="margin-bottom: 0px !important;">
                        
                        </div>
                    
				
                
                
                
                
                
               
                <div class="row">
            <div class="col-lg-6">
                <div class="ibox ">
                    <div class="ibox-title">
                    <img src="{{URL::asset($visualization_tools->logo)}}"  width="25" height="25">
                        <h5>{{$visualization_tools->name}}</h5>
                      
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12" style="min-height: 126px;"><h3 class="m-t-none m-b">Description</h3>
                                <p>{{$visualization_tools->description}}</p>
                               
                            </div>
                            
                        </div>
                    </div>
                    @if(isset($team_database_data->team_database_team_id) && $team_database_data->team_database_team_id!='')
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-sm-12" style="min-height: 126px;"><h3 class="m-t-none m-b">How to connect MySQL Database with {{$visualization_tools->name}}?</h3>
                                    <?php
                                        $guides = json_decode($visualization_tools->guides,true);
                                    ?>
                                    <?php
                                    if(isset($guides['article']) && $guides['article']!=''){
                                    ?>
                                        <p><a target="_blank" href="{{$guides['article']}}">{{$guides['article']}}</a></p>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if(isset($guides['video']) && $guides['video']!=''){
                                    ?>
                                    <figure>
                                        <iframe width="425" height="349" src="{{$guides['video']}}" frameborder="0" allowfullscreen></iframe>
                                    </figure>
                                    <?php
                                    }
                                    ?>
                                </div>
                                
                            </div>
                        </div>
                    @endif
                </div>
            </div>
                <div class="col-lg-6">
                    @if($dataware_houses->count()>0)
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>You already have these connections which you may use to feed {{$visualization_tools->name}}</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row col-sm-12">
                                    Japio feeds data twice a day into below connections you have made. 
                                </div>
                                <div class="row col-sm-12">
                                    &nbsp; 
                                </div>
                                <div class="row col-sm-12">
                                    @foreach($dataware_houses as $key=>$details)
                                        <a class="float-left" href="#">
                                            <img src="{{URL::asset($details->logo)}}" class="rounded-circle" width="65px" height="65px" alt="{{$details->name}}" title="{{$details->name}}" >    
                                        </a>&nbsp;&nbsp;&nbsp;
                                    @endforeach
                                    <a title="Add a new connection" href="{{ route('data.ware.houses')}}"><button class="btn btn-primary btn-circle btn-lg" type="button"><i class="fa fa-plus"></i></button></a>
                                </div>
                            </div>
                        </div>
                    @else

                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>You don't have any connections which you may use to feed {{$visualization_tools->name}}</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row col-sm-12">
                                    Add a connection so that Japio can feed the data and further you can use it to feed {{$visualization_tools->name}}
                                </div>
                                <div class="row col-sm-12">
                                    &nbsp; 
                                </div>
                                <div class="row col-sm-12 align-center">
                                    <a title="Add a new connection" href="{{ route('data.ware.houses')}}"><button class="btn btn-primary btn-circle btn-lg" type="button"><i class="fa fa-plus"></i></button></a>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($team_database_data->team_database_team_id) && $team_database_data->team_database_team_id!='')
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>You can connect our MySQL Database to feed your {{$visualization_tools->name}}</h5>
                            <?php  $team_database_data= json_decode($team_database_data->team_database_db_credentials) ;?>
                            </div>
                            <div class="ibox-content">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th>Host: </th>
                                        <td>{{ $team_database_data->host }}</td>
                                    </tr>
                                    <tr>
                                        <th>User: </th>
                                        <td>{{ $team_database_data->database_user }}</td>
                                    </tr>
                                    <tr>
                                        <th>Password: </th>
                                        <td>{{ $team_database_data->database_password }}</td>
                                    </tr>
                                    <tr>
                                        <th>Port: </th>
                                        <td>{{ isset($team_database_data->port)?$team_database_data->port:3306 }}</td>
                                    </tr>
                                    <tr>
                                        <th>Database: </th>
                                        <td>{{ $team_database_data->database_name }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            
                            </div>
                        </div>
                    @else
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>Alternatively, you can use our MySQL Database to feed your {{$visualization_tools->name}}</h5>
                            
                            </div>
                            <div class="ibox-content">
                                <div class="row col-sm-12">
                                    <a href="{{route('createMySqlDB',$visualization_tools->id)}}"><button class="btn btn-primary " type="button"><i class="fa fa-plus"></i>&nbsp;Create a MySQL DB for me</button> </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
                
                
                
                
                
                
                
                
                
                
               
               </div>
                
            </div>

        </div>





@stop