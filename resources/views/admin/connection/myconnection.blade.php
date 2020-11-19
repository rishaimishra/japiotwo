@extends('admin.layouts.dashboard_v3')
@section('content1')
<style>
.swal2-styled.swal2-confirm {
    background-color: #633141 !important;
    
    
}
</style>

<br>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Your Connectors</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                You have connected the below apps to get data from. You can add more apps from <b><a target="_blank" href="{{route('datasources')}}">Data Sources</a></b> section.
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content" >
	
@if(Session::has('success'))
<div class="row">
	<div class="alert alert-success  card-body col-md-11" role="alert">   

		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>        
		{{ Session::get('success') }}
	</div>
</div>
@elseif(Session::has('error'))
<div class="row">
	<div class="alert alert-danger  card-body col-md-11" role="alert">   

		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>        
		{{ Session::get('error') }}
	</div>
</div>
@endif
@if($data_sources->count()>0)            
    <div class="row">
                                    
                         @foreach($data_sources as $data_sources_row)
               
                                            <div class="col-lg-3">
                                                <div class="ibox ">
                                                    <div class="ibox-title">
                                                        <div class="ibox-tools">
                                                            <span class="float-right"><img src="{{ $data_sources_row->connection_img }}"  width="25" height="29"></span>
                                                        </div>
                                                        <h5>{{ $data_sources_row->name }}
                                                    </h5>
                                                    </div>
                                                    <div class="ibox-content">
                                                        <div class="stat-percent font-bold text-navy"></div>
                                                        <small>
                                                        <div  style="float: left;">
                                                            @if($data_sources_row->connection_status == '2')
                                                                <!--
                                                                    Some error connecting the API<br><br>
                                                                    <a href="{{ route('connections',['param'=>$data_sources_row->id])}}" type="button" class="add_btn"> 
                                                                    Reconfigure &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    </a>
                                                                !-->
                                                                <a href="{{ url('/alert') }}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="There are some error fetching data from API. Click to see the error."><i class="fa fa-circle text-danger"></i></a>

                                                            @elseif($data_sources_row->connection_status == '1')
                                                                <a href="{{ url('/alert') }}" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Active! Data is being feed from API"><i class="fa fa-circle text-success"></i></a>
                                                            @elseif($data_sources_row->connection_status == '0')
                                                                        
                                                                <?php      /*  <a href="{{ route('connections',['param'=>$data_sources_row->id])}}" type="button" class="add_btn"> */ ?>
                                                                <a href='{{ url("/dataset/$data_sources_row->id") }}' data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Dataset is not added, add one to fetch the data"><i class="fa fa-circle text-warning" style="color:YELLOW;"></i></a>
                                                                
                                                                <?php      /*     </a> */ ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            
                                                            @endif
                                                            <?php /* href="{{ route('connections-delete',['param'=>$data_sources_row->id])}}" */ ?>

                                                            <script type="text/javascript">

                                                                function deleteLessonData(id,name)
                                                                { 
                                                                    var ids=id;
                                                                    
                                                                    var url_redir='<?php echo url("/connections-delete")?>/'+id;
                                                                
                                                                    Swal.fire({
                                                                    title: 'Are you sure to remove '+name+'?',
                                                                    text: 'You will not be able to recover this data!',
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonText: 'Yes, delete it!',
                                                                    cancelButtonText: 'No, keep it'
                                                                    }).then((result) => {

                                                                            if (result.value) {
                                                                                
                                                                        window.location.href = url_redir;        
                                                                            } else {
                                                                        
                                                                            }
                                                                    
                                                                    }
                                                                )
                                                                }
                                                            </script>

                                                        </div>
                                                        <div  style="float: right;">
                                                            <a  onclick="deleteLessonData('{{ $data_sources_row->id }}','{{ $data_sources_row->name }}')"  type="button" class="add_btn">Remove</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <a href='{{ route("list-datasets", $data_sources_row->user_connectors_id) }}'   type="button" class="add_btn"><i class="fa fa-cog"></i></a>
                                                            
                                                        </div>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                    
                        
                        
                        
                            @endforeach

                            <div class="col-lg-3">
                                <a title="Add more data sources" href="{{ route('datasources')}}"><button class="btn btn-primary btn-circle btn-lg" type="button"><i class="fa fa-plus"></i></button></a>
                            </div>
              </div>             
@else
<!-- Sho empty !-->
        <div class="middle-box text-center animated fadeInRightBig">
            <h3 class="font-bold">You have not added any connection yet</h3>
            <div class="error-desc">
            To see the magic of Japio, add a data source, click on below button to get started!
                    <br/><a href="{{ url('data-sources') }}" class="btn btn-primary m-t">Add Data Source</a>
            </div>
        </div>
@endif

            </div>
            
            
            
            
            
            
@stop
