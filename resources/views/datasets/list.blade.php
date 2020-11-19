@extends('admin.layouts.dashboard_v3')
@section('content1')

<div class="wrapper wrapper-content" >
@if (Session::has('message'))
	<div class="alert alert-success  col-md-12" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		{!! Session::get('message') !!}
	</div>
@endif
@if($datasets->count()>0)    
	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-12 text-right pb-5">
			<a href="{{ route('my-connections') }}"><button class="btn btn-primary m-t" type="button"><i class="fa fa-step-backward"></i> Back to Your Connections</button></a>&nbsp;&nbsp;<a href="{{ route('add-dataset',request()->route('user_connectors_id')) }}"><button class="btn btn-primary m-t" type="button"><i class="fa fa-plus"></i> Add new Dataset</button></a>
			</div>
			<div class="ibox ">
				<div class="ibox-title">
					<img alt="image" class="" src="{{ asset($datasets->first()->connection_img) }}" style="height: 35px;width: 35px;"/>
					<h5>Datesets for {{$datasets->first()->data_sources_name}}</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						
					</div>
				</div>
				<div class="ibox-content">

					<table class="table">
						<thead>
						<tr>
							<th>Name</th>
							<th>Last Successful Run</th>
							<th>Current Status</th>
							<th>Download</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
						@foreach($datasets as $dataset)
						<tr>
							<td>{{$dataset->dataset_name}}</td>
							<td>{{$dataset->last_run}}</td>
							<td>
								@if($dataset->run_status==0)
									Awaiting
								@elseif($dataset->run_status==1)
									Running
								@elseif($dataset->run_status==2)
									Error
								@elseif($dataset->run_status==3)
									Incorrect Details 
								@else
									-
								@endif
							</td>
						<td>
							@if(!empty($dataset->api_data))
								@include('datasets.download',['dataset_id'=>$dataset->user_dataset_id,'api_data'=>$dataset->api_data])
							@endif
						</td>
						<td>
							<a href="{{route('edit-dataset',[$dataset->user_connectors_id,$dataset->user_dataset_id])}}" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
							@if($dataset->run_status==0 || $dataset->run_status==1)
								&nbsp;&nbsp;<a title="Refresh the API Data" href="{{route('refresh-dataset',[$dataset->user_connectors_id,$dataset->user_dataset_id])}}" ><i class="fa fa-refresh" aria-hidden="true"></i></a>
							@endif
						</td>
						</tr>
						@endforeach
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>                              
@else
    <!-- Show empty !-->
	<div class="middle-box text-center animated fadeInRightBig">
		<h3 class="font-bold">You have not added any dataset yet for this Data Source</h3>
		<div class="error-desc">
		Add a Dataset to get data from this data source
			<br/>
			@if(!empty(request()->route('user_connectors_id')))
			<a href="{{ route('add-dataset',request()->route('user_connectors_id')) }}"><button class="btn btn-primary m-t" type="button"><i class="fa fa-plus"></i> Add a Dataset</button></a>&nbsp;&nbsp;<a href="{{ route('my-connections') }}"><button class="btn btn-primary m-t" type="button"><i class="fa fa-step-backward"></i> Back to Your Connections</button></a>
			@endif
		</div>
	</div>
@endif
</div>

@stop