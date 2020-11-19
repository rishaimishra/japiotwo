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
                        <div class="ibox-title">
						<img alt="image" class="" src="{{ asset($user_connectors->connection_img) }}" style="height: 48px;width: 48px;"/>
                            <h5>{{ $user_connectors->data_sources_name }} <small></small></h5>
                            
                        </div>
                        </div>
                    
				
                    <div class="tabs-container">
					
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Datasets</a></li>
                            
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">
								
								
								
								
								
<form method="post">
                              @csrf
                              <br><br>
                                    <strong></strong>
                                    <?php foreach($data_set as $data_set_key=>$data_set_value){ 
                                    $input_key_header=$data_set_key;
									$input_key_is_multiple="0";
                                    $input_placeholder_name="";
                                    $input_key_required="0";
                                    $input_key_label="";
                                    $input_key_value ="";
                                    foreach($data_set_value as $data_set_value_k=>$data_set_value_v){ 
                                   
                                   
                                     if($data_set_value_k=="placeholder"){
                                        $input_placeholder_name=$data_set_value_v;
                                    }
                                    
                                     if($data_set_value_k=="name"){
                                        $input_key_name=$data_set_value_v;
                                    }
									
                                     if($data_set_value_k=="required"){
                                        $input_key_required=$data_set_value_v;
                                    }
                                    if($data_set_value_k=="is_multiple"){
                                       $input_key_is_multiple=$data_set_value_v;
                                    }
                                    
                                    if($data_set_value_k=="value"){
                                        $input_key_value=$data_set_value_v;
                                    }
                                    
                                    if($data_set_value_k=="label"){
                                       $input_key_label=$data_set_value_v;
                                    }
                                    $input_key_description="";
                                    if($data_set_value_k=="description"){
                                        $input_key_description=$data_set_value_v;
                                    }
                                     if($data_set_value_k=="hint"){
                                        $input_key_hint=$data_set_value_v;
                                    }
                                     if($data_set_value_k=="selected"){
                                         if(is_array($data_set_value_v)){
                                             foreach($data_set_value_v as $input_key_selected_value){
                                                 $input_key_selected[$input_key_selected_value]=$input_key_selected_value;
                                             }
                                         } else {
                                                $input_key_selected[$data_set_value_v]=$data_set_value_v;
                                         }
                                         
                                   
                                    }
                                     if($data_set_value_k=="option"){
                                         $input_key_option=$data_set_value_v;
                                    }
                                    

                                    
                                    if($data_set_value_k=="type"){
                                       $input_type= $data_set_value_v;
                                    }
                                        
                                    }
                                    if($input_type=="radio"){
                                        
                                    }
                                    
                                   
                                    ?>                       
                                    
                                    
                                    <?php
                                   if($input_type=="hidden"){
                                     ?>
                                    
                                     <input type="hidden" id="{{ $input_key_name }}" name="{{ $input_key_name }}" class="form-control" value="<?php
                                        foreach($input_key_selected as $input_key_selectedkey=>$input_key_selectedrow){
                                            echo $input_key_selectedkey;
                                       }
                                     ?>">
                                    
                                    <?php                                     
                                    } else {
                                   ?>
                                    
                                    
                                    
                                   <div class="form-group  row">
                                   <label class="col-sm-2 col-form-label">{{ ucfirst($input_key_header) }}</label>
                                   
                                   <?php
                                   if($input_type=="text"){
                                     ?>
                                     <div class="col-sm-8">
                                     <input type="text" <?php if(isset($input_key_required)&&($input_key_required=="1")){echo "required";}?> id="{{ $input_key_name }}" name="{{ $input_key_name }}" class="form-control"  placeholder="{{ @$input_placeholder_name }}" 
                                     value="<?php
                                        foreach($input_key_selected as $input_key_selectedkey=>$input_key_selectedrow){
                                            echo $input_key_selectedkey;
                                      }?>">
                                      </div>
                                    <?php                                     
                                    }
                                   ?>
                                   
                                   
                                   <?php
                                   if($input_type=="textarea"){
                                     ?>
                                     <div class="col-sm-8">
                                     <textarea rows="4" <?php if(isset($input_key_required)&&($input_key_required=="1")){echo "required";}?> id="{{ $input_key_name }}" name="{{ $input_key_name }}" class="form-control"  placeholder="{{ $input_placeholder_name }}"><?php
                                        foreach($input_key_selected as $input_key_selectedkey=>$input_key_selectedrow){
                                            echo $input_key_selectedkey;
                                       }
                                     ?></textarea>
                                      </div>
                                    <?php                                     
                                    }
                                   ?> 
                                  <?php if($input_type=="select"){ ?>
                                    <div class="col-sm-8">
                                        <select name="{{ $input_key_name }}<?php if($input_key_is_multiple=="1"){echo "[]";}?>"  id="{{ $input_key_name }}" class="form-control" 
                                        
                                        <?php if(isset($input_key_required)&&($input_key_required=="1")){echo "required";}?>
                                        
										<?php if($input_key_is_multiple=="1"){echo "multiple";}?>
                                        
                                        >
                                        <option value="">{{ $input_key_label }} </option>
                                    @foreach($input_key_option as $input_key_option_value)
                                    <option value="{{ $input_key_option_value['value'] }}"
                                    
                                       @if(isset($input_key_selected[$input_key_option_value['value']]))
                                           selected
                                           @endif
                                       
                                    >{{ @$input_key_option_value['text'] }}</option>
                                     @endforeach
                                    </select>
                                    </div>
                                    
                                   <?php }  if(isset($input_key_hint)&&($input_key_hint!="")){ ?>
								   	<div class="col-sm-1 tooltip" style="padding-left: 6px;">
																	<i class="fa fa-question-circle"></i>	
																	<span class="tooltiptext">{!! $input_key_hint !!}</span>
                                                                        </div>	

                                    
									<?php 
										
									}
									?>
                                </div>
                                    <?php
                                   $input_key_is_multiple="0";
                                    $input_placeholder_name="";
                                    $input_key_required="0";
                                    $input_key_label="";
                                    $input_key_value ="";
                                    $input_key_selected=array();
                                    }
                                    } ?>
									
                                   <div class="form-group  row">
                                   <label class="col-sm-2 col-form-label">Dataset name</label>
								   
                                                                        <div class="col-sm-8">
                                    <input type="text" id="dataset_name" name="dataset_name" class="form-control" value="{{ @$user_connectors->dataset_name }}" required>			
															
																	</div>	</div>	
																	
																	
                                   <div class="form-group  row">
                                   <label class="col-sm-2 col-form-label">Description</label>
								   
                                                              <div class="col-sm-8">
								<textarea id="description" name="description" class="form-control" required>{{ @$user_connectors->dataset_description }}</textarea>			
																
																	</div>	
																
																	</div>	
																	
																	
                                     <div class="form-group  row">
                                  <div class="col-sm-8">    
                                <button type="submit" name="save_dataset" class="btn btn-primary btn-sm">Save</button>       
                                    
                                </div>
								
								

                                </div>
                                </div>
                                
                              
                               
                                </form>
								
                            </div>
							
                        </div>

                    </div>
                </div>
                
            </div>

        </div>





@stop