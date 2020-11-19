@extends('admin.layouts.dashboard_v3')
@section('content1')
<br>
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
 <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Add Team <small></small></h5>
                            
                        </div>
                        <div class="ibox-content">
                            <form method="post">
                              @csrf
                            <div class="form-group  row"><label class="col-sm-2 col-form-label">Team Name</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name="team_name" id="company_name" required></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Company Name</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name="company_name" id="company_name" required></div>
                                </div>
                                 <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Website</label>

                                    <div class="col-sm-10"><input type="url" class="form-control" name="website" id="website"  required></div>
                                </div>
                                
                                
                                
                                
                                
                                
                                 <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Email address</label>

                                    <div class="col-sm-10"><input type="email" class="form-control" name="email" id="email"  required></div>
                                </div>
                                        <div class="hr-line-dashed"></div>
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Mobile Number</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name="mobile_number" id="mobile_number"  required></div>
                                </div>                         
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">                                
                                        <button class="btn btn-primary btn-sm" type="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>






@stop