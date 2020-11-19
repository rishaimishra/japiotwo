@extends('admin.layouts.dashboard_v3')
@section('content1')
<style type="text/css">
  .tab-content small{
    font-size: 100%;
  }
</style>
<div class="wrapper wrapper-content animated fadeIn" style="padding-right: 0px !important;">
   <div class="row">
      <div class="col-lg-12">
         <div class="tabs-container">
            <ul class="nav nav-tabs" role="tablist">
               <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> All</a></li>
               <li><a class="nav-link" data-toggle="tab" href="#tab-2">Failure</a></li>
               <li><a class="nav-link" data-toggle="tab" href="#tab-3">Success</a></li>
            </ul>
            <div class="tab-content">
               <div role="tabpanel" id="tab-1" class="tab-pane active">
                  <div class="panel-body">
                     <?php 
                        foreach($alldata as $all_data_row){
                          ?>
                     <a href="{{ route('edit-dataset',[$all_data_row['user_connectors_id'],$all_data_row['user_dataset_id']]) }}" style="color: black;">
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="col-lg-3" style="float: left;">
                                 <div style="float: left;padding-right: 23px;"><img alt="user image"  src="{{ asset($all_data_row['connection_img']) }}" style="height: 48px;width: 48px;"/>      </div>
                                 <div >
                                    <strong> {{ $all_data_row['dataset_name'] }}</strong><br><br />
                                    {{ $all_data_row['data_sources_name'] }}
                                 </div>
                              </div>
                              <div class="col-lg-3"  style="float: left;"><small>
                                 {{ $all_data_row['who'] }}</small><br><br />
                                 <img alt="user image" class="rounded-circle" src="{{ asset($all_data_row['pro_img']) }}" style="height: 24px;width: 24px;"/>      
                                 {{ $all_data_row['name'] }}
                              </div>
                              <div class="col-lg-3"  style="float: left;">
                                 <small>Last Run</small>
                                 <br><strong><br />
                                 {{ $all_data_row['created_date'] }}
                                 <?php 
                                    // echo $last_run[$all_data_row['user_id']][$all_data_row['id_connector']][$key_id];
                                     
                                     /* 
                                    if(isset($last_run[$all_data_row['user_id']][$all_data_row['id_connector']])){
                                     $lenth=count($last_run[$all_data_row['user_id']][$all_data_row['id_connector']]);
                                    $key_id = max(array_keys($last_run[$all_data_row['user_id']][$all_data_row['id_connector']]));
                                     echo $last_run[$all_data_row['user_id']][$all_data_row['id_connector']][$key_id];
                                    } */
                                    ?></strong>
                              </div>
                              <div class="col-lg-3"  style="float: right;">

                                    <?php
                                    if(isset($all_data_row['api_data']) && $all_data_row['api_data']!=''){
                                    ?>
                                       <div class="row">
                                          @include('datasets.download',['dataset_id'=>$all_data_row['user_dataset_id'],'api_data'=>$all_data_row['api_data']]) 
                                      </div>
                                    <?php
                                    }

                                    ?>

                                 <?php 
                                    if($all_data_row['formatted_error_message']!=""){
                                        ?>
                                 <small>Error</small>
                                 <br><strong  style="color: red;"><br />
                                 <?php
                                    $errr=json_decode($all_data_row['formatted_error_message']);
                                       echo $errr->error;
                                    }
                                    ?>
                                 </strong>
                              </div>
                           </div>
                        </div>
                     </a>
                     <hr>
                     <?php }?>
                  </div>
               </div>
               <div role="tabpanel" id="tab-2" class="tab-pane">
                  <div class="panel-body">
                     <?php 
                        foreach($failure as $failure_row){ ?>
                     <a href="{{ url('/dataset_v2/'.$failure_row['id_connector']) }}" style="color: black;">
                        <div class="row">
                           <div class="col-lg-3" style="float: left;">
                              <div style="float: left;padding-right: 23px;"><img alt="user image"  src="{{ asset($failure_row['connection_img']) }}" style="height: 48px;width: 48px;"/>      </div>
                              <div >
                                 <strong> {{ $failure_row['dataset_name'] }}</strong><br><br />
                                 {{ $failure_row['data_sources_name'] }}
                              </div>
                           </div>
                           <div class="col-lg-3"  style="float: left;"><small>
                              {{ $failure_row['who'] }}</small><br><br />
                              <img alt="user image" class="rounded-circle" src="{{ asset($failure_row['pro_img']) }}" style="height: 24px;width: 24px;"/>      
                              {{ $failure_row['name'] }}
                           </div>
                           <div class="col-lg-3"  style="float: right;">
                              <small>Last Run</small>
                              <br><strong><br />
                              {{ $failure_row['created_date'] }}
                              <?php 
                                 /* if(isset($last_run[$failure_row['user_id']][$failure_row['id_connector']])){
                                     $lenth=count($last_run[$failure_row['user_id']][$failure_row['id_connector']]);
                                   $key_id = max(array_keys($last_run[$failure_row['user_id']][$failure_row['id_connector']]));
                                     echo $last_run[$failure_row['user_id']][$failure_row['id_connector']][$key_id];
                                 } */
                                 ?></strong>
                           </div>
                           <div class="row">
                              <?php
                                 if(isset($failure_row['api_data']) && $failure_row['api_data']!=''){
                                 ?>
                                    <div class="row">
                                    @include('datasets.download',['dataset_id'=>$failure_row['user_dataset_id'],'api_data'=>$failure_row['api_data']])
                                    </div>
                                 <?php
                                 }

                              ?>
                           </div>
                           <div class="col-lg-3"  style="float: right;">
                           
                              <?php 
                                 if($failure_row['formatted_error_message']!=""){
                                     ?>
                              <small>Error</small>
                              <br><strong  style="color: red;"><br />
                              <?php
                                 $errr=json_decode($failure_row['formatted_error_message']);
                                 echo $errr->error;
                                 }
                                 
                                 ?></strong>
                           </div>
                        </div>
                     </a>
                     <hr>
                     <?php }?>
                  </div>
               </div>
               <div role="tabpanel" id="tab-3" class="tab-pane">
                  <div class="panel-body">
                     <?php 
                        foreach($success_data as $success_data_row){ ?>
                     <a href="{{ url('/dataset_v2/'.$success_data_row['id_connector']) }}" style="color: black;width:75%;">
                        <div class="row">
                           <div class="col-lg-3" style="float: left;">
                            
                              <div style="float: left;padding-right: 23px;"><img alt="user image"  src="{{ asset($success_data_row['connection_img']) }}" style="height: 48px;width: 48px;"/>      </div>
                              <div >
                                 <strong> {{ $success_data_row['dataset_name'] }}</strong><br><br />
                                 {{ $success_data_row['data_sources_name'] }}
                              </div> 
                           </div>
                           <div class="col-lg-3"  style="float: left;">
                            <small>
                              {{ $success_data_row['who'] }}</small><br /><br />
                              <img alt="user image" class="rounded-circle" src="{{ asset($success_data_row['pro_img']) }}" style="height: 24px;width: 24px;"/>      
                              {{ $success_data_row['name'] }}

                           </div>
                           <div class="col-lg-3"  style="float: left;">
                              <small>Last Run</small>
                              <br /><br /><strong>
                              <?php
                                 echo $success_data_row['created_date'];
                                 /*  
                                 if(isset($last_run[$success_data_row['user_id']][$success_data_row['id_connector']])){
                                     $lenth=count($last_run[$success_data_row['user_id']][$success_data_row['id_connector']]);
                                   $key_id = max(array_keys($last_run[$success_data_row['user_id']][$success_data_row['id_connector']]));
                                    // echo $last_run[$success_data_row['user_id']][$success_data_row['id_connector']][$key_id];
                                 } */
                                 ?></strong>
                           </div>
                         <!-------- json data div start---------->
                          <div class="col-lg-3"  style="float: left;">
                              <?php
                                 if(isset($success_data_row['api_data']) && $success_data_row['api_data']!=''){
                                 ?>
                                    <div class="row">
                                       @include('datasets.download',['dataset_id'=>$success_data_row['user_dataset_id'],'api_data'=>$success_data_row['api_data']]) 
                                    </div>
                                 <?php
                                 }

                              ?>
                          </div>
                        <!-------- json data div end---------->
                     </div>

                     </a>
                     <hr>
                     <?php }?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@stop