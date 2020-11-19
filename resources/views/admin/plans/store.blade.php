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
.custom-checkbox{
	height: 20px;
    width: 26px;
}
.custom-label{
	position: absolute;
}
</style>
<div class="container pt-3">
		<form action="{{ url('plan-add') }}" method="POST" id="plan-form">
			@csrf
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				<div class="form-group">
			      <label for="name">Name: </label>
			      <input type="text" class="form-control" id="name" placeholder="Enter plan name" name="name">
		    	</div>
				</div>
			    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				    <div class="form-group">
				      <label for="description1">Description:</label>
				      <input type="text" class="form-control" id="description1" placeholder="Enter description name" name="description">
				    </div>
			    </div>
			</div>
		
		    <div class="row">
		    	
			    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				    <div class="form-group">
				      <label for="monthly_price">Monthly Price:</label>
				      <input type="number" class="form-control" id="monthly_price" placeholder="Enter monthly price" name="monthly_price"  value="0">
				    </div>
			    </div>
			    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
			      	<div class="form-group">
				      <label for="quaterly_price">Quaterly Price:</label>
				      <input type="number" class="form-control" id="quaterly_price" placeholder="Enter quaterly price" name="quaterly_price"  value="0">
				    </div>
			    </div>
		    </div>
		    <div class="row">
		    	
			    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
				    <div class="form-group">
				      <label for="half_yealry_price">Half Yealry Price:</label>
				      <input type="number" class="form-control" id="half_yealry_price" placeholder="Enter half yealry price" name="half_yealry_price"  value="0">
				    </div>
			    </div>
			    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
			      	<div class="form-group">
				      <label for="yearly_price">Yearly Price:</label>
				      <input type="number" class="form-control" id="yearly_price" placeholder="Enter yearly price" name="yearly_price"  value="0" required="required">
				    </div>
			    </div>
		    </div>

		    

		    <div class="row">
		    	<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
			      	<div class="form-group">
				      <label for="max_data_sources">Max. Data Sources: [Enter -1 for Unlimited]</label>
				      <input type="number" class="form-control" id="max_data_sources" placeholder="Enter data sources" name="max_data_sources"  value="0" required="required">
				    </div>
			    </div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
			      	<div class="form-group">
				      <label for="max_business_users">Max. Business Users: [Enter -1 for Unlimited]</label>
				      <input type="number" class="form-control" id="max_business_users" placeholder="Enter data sources" name="max_business_users"  value="0" required="required">
				    </div>
			    </div>
			    
		    </div>

		    <div class="row">

			    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
			      	<div class="form-group">
				      <label for="max_team_size">Max. Integrator Users: [Enter -1 for Unlimited]</label>
				      <input type="number" class="form-control" id="max_team_size" placeholder="Enter integrator size" name="max_team_size" value="0" required="required">
				    </div>
			    </div>
			    
		    </div>
		    <div class="row">
		    	<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
		      		<input type="checkbox" id="customised" name="customised_plan" value="customise">
				  	<label for="customised"> Check if this is a customised plan</label><br>
				  	
			    </div>
		    </div>
		    <div class="row" id="custom_teams">
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
					<div class="form-group">
						<label for="max_team_size">Select the company(s) you would like to assign this plan </label>
						<?php $i= 1; ?>
						@foreach($teams as $team)
						<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-2">
							<input type="checkbox" id="team{{ $i }}" class="custom-checkbox" name="team[]" value="{{ $team->id }}">
							<label for="team{{ $i }}" class="custom-label">{{ $team->team_name }}</label><br>  	
						</div>
						<?php $i++; ?>
						@endforeach
					</div>
				</div>
		    </div>
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 pt-3">
		    		<button type="submit" class="btn planbutton">Create</button>
		    	</div>
			</div>
  		</form>

</div>
<script src= 
"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> 
  </script>
  <script type="text/javascript">
      $(document).ready(function() { 
      	$('#custom_teams').hide();
        $('#customised').click(function(){
          if($(this).prop("checked") == true){
              $('#custom_teams').show();
          }
          else if($(this).prop("checked") == false){
              $('#custom_teams').hide();
          }
        });
        

      });
      
</script>
@stop 