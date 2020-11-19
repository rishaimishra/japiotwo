@extends('admin.layouts.dashboard_v3')
@section('content1')
<style type="text/css">
	.addAddonPlan{
	    background: #e70f21;
	    padding: 9px;
	    color: #fff;
	}
	.addAddonPlan:hover{
		color: #fff;
	}
</style>
<div class="container pt-3">
	@if ($message = Session::get('success'))
	<div class="alert alert-success alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>	
	        <strong>{{ $message }}</strong>
	</div>
	@endif
	@if ($message = Session::get('deleteSuccess'))
	<div class="alert alert-info alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>	
		<strong>{{ $message }}</strong>
	</div>
	@endif
	<div class="row">
		<div class="col-sm-6 col-md-6 col-lg-6">
			<h1>Addon Plans</h1>
		</div>
		<div class="col-sm-6 col-md-6 col-lg-6 text-right">
			<a href="{{ url('addon-store/'.$id) }}" class="addAddonPlan">Add Addon</a>
		</div>
	</div>
	
	<table class="table table-bordered">
	    <thead>
	      <tr>
	        <th>#</th>
	        <th>Name</th>
	        <th>Monthly </th>
	        <th>Quaterly </th>
	        <th>Half Yealry </th>
	        <th>Yearly</th>
	       <!--  <th>Description</th> -->
	        <th>Days</th>
	        <th>Status</th>
	        <th>Action</th>
	      </tr>
	    </thead>
	    <tbody>
	    	<?php $i = 1; ?>
	    	@foreach($plans as $plan)
		      <tr>
		        <td>{{ $i }}</td>
		        <td>{{ $plan->plan_name }}</td>
				<td>{{ ($plan->price_type =='monthly' ) ? $plan->price : 'N/A' }}</td>
		        <td>{{ ($plan->price_type =='quarterly') ? $plan->price: 'N/A' }}</td>
		        <td>{{ ($plan->price_type =='halfyearly') ? $plan->price:'N/A' }}</td>
		        <td>{{ ($plan->price_type =='yearly') ? $plan->price : 'N/A' }}</td>
		        <!-- <td>{{ $plan->plan_description }}</td> -->
		        <?php 
					if($plan->price_type =='monthly'){
					 $days 		= '30';
					}elseif($plan->price_type =='yearly'){
					  $days 	=  '365';
					}elseif($plan->price_type =='quarterly'){
					   $days 	= '90';
					}elseif($plan->price_type =='halfyearly') {
					 	$days 	= '180';
					}else{
					 	$days 	=  $plan->valid_days; 
					}
				?>
		        <td>{{ $days }}</td>
		        <td><?php if($plan->is_active=='1'){ echo 'Active';}else{ echo 'N/A';} ?></td>
		        <td>
		        	<span>
		        		<a href="{{ url('addon-edit/'.$plan->id) }}" ><i class="fa fa-pencil-square-o"></i></a>
		        	</span>
		        	<span>
		        		<a href="{{ url('addon-delete/'.$plan->id) }}" style="color:red;"><i class="fa fa-trash"></i></a>
		        	</span>
		        	
				</td>
		       
		      </tr>
  			<?php $i++; ?>
	      @endforeach
	    </tbody>
  	</table>
</div>
@stop 