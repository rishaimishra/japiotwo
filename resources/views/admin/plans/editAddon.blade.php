@extends('admin.layouts.dashboard_v3')
@section('content1')
<style type="text/css">
.planbutton{
    background: #e70f21;
    color: #fff;
    border-radius: 5px;
    border: 2px solid #e70f21;
}
.planbutton:hover{
	color: #fff;
}
#plan-form {
	margin-bottom: 5%;
}
</style>
<div class="container pt-3">
		@if ($message = Session::get('editSuccess'))
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>	
		        <strong>{{ $message }}</strong>
		</div>
		@endif
		<form action="{{ url('addon-edit/'.$id) }}" method="POST" id="plan-form">
			@csrf
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group">
				      <label for="name">Name: </label>
				      <input type="text" class="form-control" id="name" placeholder="Enter plan name" name="name" value="{{ $plan->plan_name }}">
			    	</div>
				</div>
			    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				    <div class="form-group">
				      <label for="description1">Description :</label>
				      <input type="text" class="form-control" id="description1" placeholder="Enter description name" name="description" value="{{ $plan->plan_description }}">
				    </div>
			    </div>
			</div>

		    <div class="row">
		    	
			    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				    <div class="form-group">
				      <label for="monthly_price">Monthly Price:</label>
				      <input type="number" class="form-control" id="monthly_price" placeholder="Enter monthly price" name="monthly_price" value="<?php if($price->price_type=='monthly'){ echo $price->price; }else{ echo '0';}?>"<?php if($price->price>0 && $price->price_type=='monthly'){ echo 'disabled'; }?>>
				    </div>
			    </div>
			    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
			      	<div class="form-group">
				      <label for="quaterly_price">Quaterly Price:</label>
				      <input type="number" class="form-control" id="quaterly_price" placeholder="Enter quaterly price" name="quaterly_price" value="<?php if($price->price_type=='quarterly'){echo $price->price;}else{ echo '0';}?>" <?php if($price->price>0 && $price->price_type=='quarterly'){ echo 'disabled'; }?>>
				    </div>
			    </div>
		    </div>
		    <div class="row">
			    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				    <div class="form-group">
				      <label for="half_yealry_price">Half Yealry Price:</label>
				      <input type="number" class="form-control" id="half_yealry_price" placeholder="Enter half yealry price" name="half_yealry_price" value="<?php if($price->price_type=='halfyearly'){echo $price->price;}else{ echo '0';}?>" <?php if($price->price>0 && $price->price_type=='halfyearly'){ echo 'disabled'; }?>>
				    </div>
			    </div>
			    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
			      	<div class="form-group">
				      <label for="yearly_price">Yearly Price:</label>
				      <input type="number" class="form-control" id="yearly_price" placeholder="Enter yearly price" name="yearly_price" value="<?php if($price->price_type=='yearly'){echo $price->price;}else{ echo '0';}?>" <?php if($price->price>0 && $price->price_type=='yearly'){ echo 'disabled'; }?>>
				    </div>
			    </div>
		    </div>


			<div class="row">
		    	<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
			      	<div class="form-group">
				      <label for="max_data_sources">Data Sources:</label>
				      <input type="number" class="form-control" id="max_data_sources" placeholder="Enter data sources" name="max_data_sources" value="{{ $plan->max_data_sources }}" required="required">
				    </div>
			    </div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
			      	<div class="form-group">
				      <label for="max_business_users">Business Teams:</label>
				      <input type="number" class="form-control" id="max_business_users" placeholder="Enter data sources" name="max_business_users" value="{{ $plan->max_business_users }}" required="required">
				    </div>
			    </div>

		    </div>

		    <div class="row">
		    	
			    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
			      	<div class="form-group">
				      <label for="max_team_size">Integrator Teams:</label>
				      <input type="number" class="form-control" id="max_team_size" placeholder="Enter integrator size" name="max_team_size" value="{{ $plan->max_integrator_user }}" required="required">
				    </div>
			    </div>

			     <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
			      	<div class="form-group">
				      <label for="max_team_size">Status:</label>
				      <select name="is_active" class="form-control">
				      	<option>Select status</option>
				      	<option value="1" <?php if($plan->is_active == 1){ echo 'selected';}?>>Active</option>
				      	<option value="0" <?php if($plan->is_active == 0){ echo 'selected';}?>>Inactive</option>
				      
				      </select>
				     
				    </div>
			    </div>
			    
		    </div>

			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
		    		<button type="submit" class="btn planbutton">Update Add-on Plan</button>
		    	</div>
			</div>
  		</form>

</div>

@stop 