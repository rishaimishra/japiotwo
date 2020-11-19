@extends('admin.layouts.dashboard_v3')
@section('content1')
<style type="text/css">
    #ui-datepicker-div{
        background: #e70f21 !important;
    }
    #ui-datepicker-header{
        background: #e70f21 !important;
       
    }
    .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
        padding-left: 3px !important;
        padding-right: 5px !important;
        background: transparent !important;
        border: none !important;
        color: #fff !important;
    }
    .ui-datepicker-month{
        width:50% !important;
    }
    .ui-datepicker-year{
        width: 50% !important;
    }
    .ui-datepicker-calendar tr th span{
        color: #fff !important;
    }
</style>
<br>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2>Target Feed History</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                Check below the feed history for your connected target [ {{ $datawareHouse->name }} ].
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight"  style="padding-bottom: 9px !important;padding-right: 10px !important;">


 
            <div class="row">    

                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            
                        </div>
                    </div>
                    <div class="ibox-content">

                    <div class="table-responsive">
                    
                       <div class="container">
                          <div class="col-md-4 pull-right">
                            <div class="row">
                                <div class="input-group input-daterange">

                                  <input type="text" id="min" class="form-control date-range-filter" name="min" placeholder="From:" style="height: 31px;">

                                  <div class="input-group-addon" style="height: 31px;">to</div>

                                  <input type="text" id="max" class="form-control date-range-filter" name="max" placeholder="To:" style="height: 31px;">

                                </div>
                            </div>
                            
                          </div>
                        </div>


                    <table class="table table-striped table-bordered table-hover dataTables-datawareHouse" >


                    <thead>
                    <tr>
                        <th>Dataset Name </th>
                        <th>Target Name </th>
                        <th>Status</th>
                        <th>Error Response</th>
                        <th>Formatted Error Message</th>
                        <th>Date & Time</th>
                    </tr>
                    </thead>
                    <tbody>

                        @foreach($datawareHouseDats as $datawareHouseDat)

                            <tr class="gradeU">
                            <td> {{ $datawareHouseDat->dataset_name?$datawareHouseDat->dataset_name:''}} </td>
                            <td> {{ $datawareHouseDat->target_name?$datawareHouseDat->target_name:''}} </td>
                            <td>
                                <?php if($datawareHouseDat->status==1){ ?> 
                                    <span class="badge badge-success">Success</span>
                                <?php }else{ ?>
                                    <span class="badge badge-danger">failed</span>
                                <?php } ?>
                            </td>
                            <td> {{ $datawareHouseDat->error_response?$datawareHouseDat->error_response:''}} </td>
                            <td> {{ $datawareHouseDat->formatted_error_message?$datawareHouseDat->formatted_error_message:''}} </td>

                            <td> {{ $datawareHouseDat->created_at?$datawareHouseDat->created_at:''}} </td>
                            </tr>
                        @endforeach
                    </tbody>
                  
                    </table>
                        </div>

                    </div>
                </div>
            </div>

</div>     
 </div>
 @stop