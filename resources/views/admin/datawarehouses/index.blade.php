@extends('admin.layouts.dashboard_v3')
@section('content1')
<br>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Dataware Houses</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                Connect these app to get data from Japio which you can further use in your <b><a target="_blank" href="{{route('visualization.tools')}}">Visualisation tools</a></b> like PowerBI, Google Data Studio etc.
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content">
    @include('common.message')        
    <div class="row">                
        <?php $i=0; ?>
        @foreach($datawarehouses as $datawarehousess_row)                

            <?php $i++; ?>
            <div class="col-lg-4" >
                <div class="ibox " >
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            <span class="float-right"><img src="{{ $datawarehousess_row->dataware_houses_logo }}"  width="25" height="25"></span>
                        </div>
                        <h5>{{ $datawarehousess_row->dataware_houses_name }}
                        </h5>
                    </div>
                    <div class="ibox-content" style="padding-bottom:30px;">                                
                        <div class="stat-percent font-bold text-navy"></div>
                        <div style="float: left;">
                            <a href="{{route('dataware.house.feeds',$datawarehousess_row->dataware_houses_id)}}" title="Click to view the feed history">
                            @if($datawarehousess_row->user_connectors_connection_status==1)
                                <span class="badge badge-success">Connected</span>
                            @elseif($datawarehousess_row->user_connectors_connection_status==2)
                                <span class="label label-danger">Disconnected</span>
                            @elseif($datawarehousess_row->user_connectors_connection_status!=null && $datawarehousess_row->user_connectors_connection_status==0)
                                <span class="label label-warning">In Progress</span>
                            @endif
                            </a>

                        </div>
                        <div style="float: right;">
                            @if(!empty($datawarehousess_row->user_connectors_id))
                                <a href="javascript:void(0)" onclick="removeConnection({{$datawarehousess_row->id_connector}},'{{$datawarehousess_row->dataware_houses_name}}')" class="text-danger" >Disconnect</a> &nbsp;&nbsp;&nbsp;
                            @else
                                <a href="{{ route('dataware.add',['param'=>$datawarehousess_row->dataware_houses_id])}}" type="button" class="add_btn"><i class="fa fa-plus"></i>&nbsp;Connect</a>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>
    
        @endforeach
    </div>
                 <?php if($i==0){ ?>
                 <div class="row">



                    <div class="col-lg-4">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <div class="ibox-tools">
                                    <span class="label label-primary float-right">XXXXX</span>
                                </div>
                                <h5> Many other warehouse sources are coming soon      </h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">XXXXXX</h1>
                                <div class="stat-percent font-bold text-navy">XXXX <i class="fa fa-level-up"></i></div>
                                <small>XXXXX</small>
                            </div>
                        </div>
                    </div>
                    
              
              </div>
                 
                 
                    <?php }?>
              
</div>


<script type="text/javascript">

function removeConnection(id,name)
{ 
    var ids=id;
    
    var url_redir='<?php echo url("/connections-delete")?>/'+id+"/dataware_house";

    Swal.fire({
    title: 'Are you sure to disconnect '+name+'?',
    text: 'Data pushed by Japio will NOT be removed.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, disconnect it!',
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
@stop