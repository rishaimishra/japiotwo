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
				<div class="ibox ">
                        <div class="ibox-title" style="min-height:75px;">
						    <div class="col-lg-6 float-left">
                                <img alt="image" class="" src="{{ asset($user_connectors->connection_img) }}" style="height: 48px;width: 48px;"/>
                                <h5>{{ $user_connectors->data_sources_name }} <small></small></h5>
                            </div>
                            <div class="col-lg-6 float-right" style="text-align:right;">
                                @if(isset($user_connectors->api_data) && $user_connectors->api_data!='')
                                <span style="color:GREEN;font-weight:bold">Download the data received in last run at {{$user_connectors->last_run}} </span>&nbsp;&nbsp;&nbsp;<a href="{{ url('download').'/'.$user_connectors->user_datasource_data_id }}" title="Download JSON Data"><i class="fa fa-download" aria-hidden="true"></i></a>
                                @endif
                            </div>    
                        </div>
                    </div>
                    
				    <div class="tabs-container">
					
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Datasets</a></li>
                            
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    
                                    <?php 
                                    if(is_array($data_set) && count($data_set)>0){
                                    ?>
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
									 if($data_set_value_k=="childelements"){
                                       // $input_key_hint=$data_set_value_v;
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
										onchange="jsfunction(this.options[this.selectedIndex].value.trim(),'<?php echo $input_key_name;?>')"
                                        >
                                        <option value="">{{ $input_key_label }} </option>
                                    @foreach($input_key_option as $input_key_option_value)
                                    <option value="<?php 
									$ids =str_replace(" ","_",$input_key_option_value['value']); 
									?>{{ $ids }}"
                                    
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
								if($data_set_value_k=="childelements"){
									//print_r($data_set_value_v);
								foreach($data_set_value_v as $data_set_value_v_key=>$data_set_value_v_value){
									
								//echo $data_set_value_v_key;	
								//echo "<br>";
								foreach($data_set_value_v_value as $data_set_value_v_key_k=>$data_set_value_v_value_v){


							
							//	echo $data_set_value_v_key_k;
if(isset($data_set_value_v_value_v['name'])){
                                        $input_key_name_child=$data_set_value_v_value_v['name'];	
}

if(isset($data_set_value_v_value_v['value'])){
		$input_key_value_child=$data_set_value_v_value_v['value'];
		
}
								

$input_key_required_child="0";
if(isset($data_set_value_v_value_v['required'])){
	 $input_key_required_child='1';
}
  
                                     
                                  //  }
									
//echo $data_set_value_v_value_v['label']; echo"<br>";


								    $input_key_selected_child =array();
									
if(isset($data_set_value_v_value_v['selected'])){
	
	$data_set_value_v_value_v;


                                         if(is_array($data_set_value_v_value_v['selected'])){											 
                                             foreach($data_set_value_v_value_v['selected'] as $input_key_selected_value_child){
												// echo $input_key_selected_value_child;
												 if($input_key_selected_value_child!=""){
													 if(!empty($input_key_selected_value_child)){
														$input_key_selected_child[$input_key_selected_value_child]=$input_key_selected_value_child;
													 }
												 }
											
                                             }
											
                                         } else {
											if($data_set_value_v_value_v['selected']!=""){
												
                                                $input_key_selected_child[$data_set_value_v_value_v['selected']]=$data_set_value_v_value_v['selected'];
												
											 }
                                         }                                   
                                   
}

if(isset($data_set_value_v_value_v['placeholder'])){
                                        $input_key_placeholder_child=$data_set_value_v_value_v;	
}

if(isset($data_set_value_v_value_v['label'])){
	                                       $input_key_label_child=$data_set_value_v_value_v;
}
if(isset($data_set_value_v_value_v['hint'])){
	   $input_key_hint_child=$data_set_value_v_value_v;
}
if(isset($data_set_value_v_value_v['type'])){
	      $input_type_child= $data_set_value_v_value_v['type'];
}
if(isset($data_set_value_v_value_v['description'])){
                                        $input_key_description_child=$data_set_value_v_value_v;	
}
							         
                           
									$input_key_is_multiple_child="0";
									if(isset($data_set_value_v_value_v['is_multiple'])){
                                       $input_key_is_multiple_child=$data_set_value_v;
                                    }						
 
if(isset($data_set_value_v_value_v['option'])){
                                        $input_key_option_child=$data_set_value_v_value_v['option'];	
}
                               
			  if($data_set_value_k=="option"){
                                         $input_key_option=$data_set_value_v;
                                    }						
								//echo $data_set_value_v_value_v['type'];
//print_r($input_key_selected_child);									
									
								//echo count($input_key_selected_child);	
									
								$is_nonedisplay='style="display:none;"';

if(count($input_key_selected_child)!="0"){
								//	echo count($input_key_selected_child);	
								if(isset($input_key_selected[$data_set_value_v_key])&&($input_key_selected[$data_set_value_v_key]!="")){
									$is_nonedisplay='';
								}	
}
									
								//	echo $is_nonedisplay;
								//	echo $input_key_name;
									?>
							
								<div class="form-group   row <?php echo $input_key_name;?> <?php echo $ids =str_replace(" ","_",$data_set_value_v_key);?>" dclass="<?php echo $input_key_name;?>" id="<?php $ids =str_replace(" ","_",$data_set_value_v_key);?>{{ $ids }}" <?php echo $is_nonedisplay;?>>
							
									<label class="col-sm-2 col-form-label">{{ ucfirst($data_set_value_v_value_v['name']) }}</label>
								 
								<?php if($data_set_value_v_value_v['type']=="select"){?>
								 <div class="col-sm-8">
                                        <select name="{{ $data_set_value_v_value_v['name'] }}<?php if($input_key_is_multiple_child=="1"){echo "[]";}?>"  id="<?php echo $input_key_name."_1" ;?>" class="form-control <?php echo $ids;?>"                                         
                                        <?php if(isset($input_key_required_child)&&($input_key_required_child=="1")){echo "required";}?>
										<?php if($input_key_is_multiple_child=="1"){echo "multiple";}?> onchange="jsfunction1(this.options[this.selectedIndex].value.trim(),'<?php echo $data_set_value_v_value_v['name'];?>')">
										
                                        <option value="">{{ $data_set_value_v_value_v['label'] }} </option>
								@if(is_array($input_key_option_child))
                                    @foreach($input_key_option_child as $input_key_option_value)
                       <option value="<?php	echo str_replace(" ","_",$input_key_option_value['value']); ?>"
                                    
                                       @if(isset($input_key_selected_child[$input_key_option_value['value']]))
                                           selected
                                           @endif                                       
                                    >{{ @$input_key_option_value['text'] }}</option>
                                     @endforeach
                                @endif
                                    </select>
                                    </div>
								  <?php
								}
                                   if($data_set_value_v_value_v['type']=="textarea"){									             
												 ?>
									
                                     <div class="col-sm-8">
									  <textarea rows="4" <?php if(isset($input_key_required_child)&&($input_key_required_child=="1")){echo "required";}?> id="<?php echo $input_key_name."_1" ;?>" name="{{ $data_set_value_v_value_v['name'] }}" class="form-control <?php echo $ids;?>" placeholder="{{ @$data_set_value_v_value_v['placeholder'] }}" ><?php
                                        foreach($input_key_selected_child as $input_key_selectedkey_child=>$input_key_selectedrow_child){
                                            echo $input_key_selectedkey_child;
                                      }?></textarea>									  
                                      </div>
                                    <?php                                     
                                    }
								  
                                   if($data_set_value_v_value_v['type']=="hidden"){
                                     ?>
                                     <div class="col-sm-8">
                                     <input type="text" <?php if(isset($input_key_required_child)&&($input_key_required_child=="1")){echo "required";}?> id="<?php echo $input_key_name."_1" ;?>" name="{{ $data_set_value_v_value_v['name'] }}" class="form-control <?php echo $ids;?>"  placeholder="{{ @$data_set_value_v_value_v['placeholder'] }}" 
                                     value="<?php
                                        foreach($input_key_selected_child as $input_key_selectedkey_child=>$input_key_selectedrow_child){
                                            echo $input_key_selectedkey_child;
                                      }?>">
                                      </div>
                                    <?php                                     
                                    }
								  
                                   if($data_set_value_v_value_v['type']=="text"){
									 
                                     ?>
                                     <div class="col-sm-8">
                                     <input type="text" <?php if(isset($input_key_required_child)&&($input_key_required_child=="1")){echo "required";}?> id="<?php echo $input_key_name."_1" ;?>" name="{{ $data_set_value_v_value_v['name'] }}" class="form-control <?php echo $ids;?>"  placeholder="{{ @$data_set_value_v_value_v['placeholder'] }}" 
                                     value="<?php
									
                                        foreach($input_key_selected_child as $input_key_selectedkey_child=>$input_key_selectedrow_child){
                                            echo $input_key_selectedrow_child;
                                      }?>">
                                      </div>
                                    <?php                                     
                                    }
									
									if(isset($data_set_value_v_value_v['hint'])&&($data_set_value_v_value_v['hint']!="")){ ?>
								   	<div class="col-sm-1 tooltip" style="padding-left: 6px;">
																	<i class="fa fa-question-circle"></i>	
																	<span class="tooltiptext">{!! $data_set_value_v_value_v['hint'] !!}</span>
                                                                        </div>	
									<?php 										
									}
									?>

							</div>
								
								
								
								<?php 
								} }
								}
								?> 
								
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
																	
<input type="hidden" name="japio" id ="japio" value="<?php if(isset($selected_data)){ echo $selected_data;}?>">																	
                                     <div class="form-group  row">
                                  <div class="col-sm-8">    
                                <button type="submit" name="save_dataset" class="btn btn-primary btn-sm"><i class="fa fa-check"></i>&nbsp;Save</button>       
                                    
                                </div>
								
								

                                </div>
                                </div>
                                
                              
                               
                                </form>
                                <?php
                                    }else{
                                ?>
                                    <div class="alert alert-danger  col-md-12" role="alert">
                                        Unable to show the data set fields, please contact web master.
                                    </div>
                                <?php
                                    }
                                ?>
								
                            </div>
							
                        </div>

                    </div>
                </div>
                
            </div>

        </div>
<script src="{{ asset('js/jquery-3.1.1.min.js')}}"></script>

		
									<script>
									function jsfunction1(input_value,sel_name){
											var inputF = document.getElementById("japio");
											inputF.value = input_value+" "+sel_name; 
									}
									function jsfunction(id,clname){
									var inputF = document.getElementById("japio");
											inputF.value = ''; 
										$("."+id).prop('selectedIndex',0);
										$("."+id).val("");									
										$('.'+clname).hide();		
										//$('#'+id).show();
										$('.'+id).show();
									}
									</script>


@stop
