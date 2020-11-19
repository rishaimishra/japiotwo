@extends('admin.layouts.dashboard_v3')
@section('content1')
<style type="text/css">
    .searchButton{
        height: 36px;
    }
</style>


<br>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Data Sources</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                You can connect following apps/data sources to get the data into Japio
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">  
    @if(Session::has('success'))
        <div class="col-lg-12">
            <div class="alert alert-success  card-body col-md-11" role="alert">   
        
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>        
                {{ Session::get('success') }}
            </div>
        </div>
    @elseif(Session::has('error'))
        <div class="col-lg-12">
            <div class="alert alert-danger  card-body col-md-11" role="alert">   
                
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>        
                {{ Session::get('error') }}
            </div>
        </div>
    @endif

        <div class="container pb-4 pt-1">
            <div class="col-md-6 offset-md-3">
                <input type="text" id="inputSearch" placeholder="Search for a data source"  class="form-control">
            </div>

        </div>  
        <?php $i=0; ?>
        
           
        @foreach($data_sources as $data_sources_row)
            @if($data_sources_row->user_id != $auth_id)
            <?php $i++; ?>
                <div class="col-lg-3 data-source-div">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <div class="ibox-tools">
                                <span class="float-right"><img src="{{ $data_sources_row->connection_img }}"  width="25" height="29"></span>
                            </div>
                            <h5>{{ $data_sources_row->name }}</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="stat-percent font-bold text-navy"></div>
                            <a href="{{ route('connections',['param'=>$data_sources_row->id])}}" type="button" class="add_btn">
                                @if($data_sources_row->provider=="google")
                                    <img src="{{ asset('img/btn_google_signin_dark_normal_web.png')}}" width="75%" height="75%" />
                                @else
                                    <i class="fa fa-plus"></i>&nbsp;Connect
                                @endif

                            </a>
                        </div>
                    </div>
                </div>
            @endif
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
                        <h5> Many other data sources are coming soon      </h5>
                    </div>
                </div>
            </div>
        </div>            
    <?php }?>
              
</div>
@stop