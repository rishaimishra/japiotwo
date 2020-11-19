@extends('admin.layouts.dashboard_v3')
@section('content1')

<br>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Visualization Tools</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                You can visualise your data received from <b><a target="_blank" href="{{route('my-connections')}}">Your Connected Apps</a></b> into popular Visualization Tools
            </li>
        </ol>
    </div>
</div>
<br>
<div class="wrapper wrapper-content">            
    <div class="row">                
        <?php $i=0; ?>
        @foreach($visualization_tools_data as $visualization_tools_data_row)                
        <?php $i++; ?>
            <div class="col-lg-4">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            <span class="float-right"><img src="{{ $visualization_tools_data_row->visualization_tools_logo }}"  width="25" height="25"></span>
                        </div>
                        <h5>{{ $visualization_tools_data_row->visualization_tools_name }} </h5>
                    </div>
                    <div class="ibox-content">                                
                        <div class="stat-percent font-bold text-navy"></div>
                        <small><a href="{{ url('/visualization-db-view/'.$visualization_tools_data_row->visualization_tools_id) }}" type="button" class="add_btn">View Details</a></small>
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
@stop