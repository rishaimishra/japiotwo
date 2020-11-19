@extends('admin.layouts.dashboard_v3')
@section('content1')
<style type="text/css">
.switch {
  display: block;
  margin: 12px auto;
}

.switch {
  position: relative;
  display: inline-block;
  vertical-align: top;
  width: 56px;
  height: 20px;
  padding: 3px;
  background-color: white;
  border-radius: 18px;
  cursor: pointer;
  background-image: -webkit-linear-gradient(top, #eeeeee, white 25px);
  background-image: -moz-linear-gradient(top, #eeeeee, white 25px);
  background-image: -o-linear-gradient(top, #eeeeee, white 25px);
  background-image: linear-gradient(to bottom, #eeeeee, white 25px);
}

.switch-input {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
}

.switch-label {
  position: relative;
  display: block;
  height: inherit;
  font-size: 10px;
  text-transform: uppercase;
  background: #eceeef;
  border-radius: inherit;
 
  -webkit-transition: 0.15s ease-out;
  -moz-transition: 0.15s ease-out;
  -o-transition: 0.15s ease-out;
  transition: 0.15s ease-out;
  -webkit-transition-property: opacity background;
  -moz-transition-property: opacity background;
  -o-transition-property: opacity background;
  transition-property: opacity background;
}
.switch-label:before, .switch-label:after {
  position: absolute;
  top: 50%;
  margin-top: -.5em;
  line-height: 1;
  -webkit-transition: inherit;
  -moz-transition: inherit;
  -o-transition: inherit;
  transition: inherit;
}
.switch-label:before {
  content: attr(data-off);
  right: 11px;
  color: #aaa;
  text-shadow: 0 1px rgba(255, 255, 255, 0.5);
}
.switch-label:after {
  content: attr(data-on);
  left: 11px;
  color: white;
  text-shadow: 0 1px rgba(0, 0, 0, 0.2);
  opacity: 0;
}
.switch-input:checked ~ .switch-label {
  background: #e70f21;
}
.switch-input:checked ~ .switch-label:before {
  opacity: 0;
}
.switch-input:checked ~ .switch-label:after {
  opacity: 1;
}

.switch-handle {
  position: absolute;
  top: 4px;
  left: 4px;
  width: 18px;
  height: 18px;
  background: white;
  border-radius: 10px;
  
  background-image: -webkit-linear-gradient(top, white 40%, #f0f0f0);
  background-image: -moz-linear-gradient(top, white 40%, #f0f0f0);
  background-image: -o-linear-gradient(top, white 40%, #f0f0f0);
  background-image: linear-gradient(to bottom, white 40%, #f0f0f0);
  -webkit-transition: left 0.15s ease-out;
  -moz-transition: left 0.15s ease-out;
  -o-transition: left 0.15s ease-out;
  transition: left 0.15s ease-out;
}
.switch-handle:before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  margin: -6px 0 0 -6px;
  width: 12px;
  height: 12px;
  background: #f9f9f9;
  border-radius: 6px;
  background-image: -webkit-linear-gradient(top, #eeeeee, white);
  background-image: -moz-linear-gradient(top, #eeeeee, white);
  background-image: -o-linear-gradient(top, #eeeeee, white);
  background-image: linear-gradient(to bottom, #eeeeee, white);
}
.switch-input:checked ~ .switch-handle {
  left: 40px;
  
}
.addTeamButton{
    background: #e70f21;
    color: #fff;
    padding: 11px 50px;
}
.addTeamButton:hover{
  color: #fff;
}
</style>
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
<div class="wrapper wrapper-content animated fadeInRight"  style="padding-bottom: 9px !important;padding-right: 10px !important;">


          <div class="text-right mb-4">
            <a href="{{ url('team-add')}}" type="button" class="addTeamButton"><i class="fa fa-plus"></i>&nbsp;Add a Team</a>
            
          </div>
            <div class="row">    

                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Teams</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            
                        </div>
                    </div>
                    <div class="ibox-content">

                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-teamList" >
                    <thead>
                    <tr>
                        <th>Name </th>
                        <th>Total members </th>
                        <th>Active members</th>
                        <th>Invitaion pending</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($team_data as $team_data_row)

                            <tr class="gradeU">
                            <td>{{ $team_data_row['team_name'] }}</td>
                            <td>
                                <?php 
                                    if(isset($team_data_row['acepted'])) { 
                                    echo count($team_data_row['acepted']);                            
                                    } else { echo "0";}
                                ?>
                                
                            </td>
                            <td>
                                <?php if(isset($team_data_row['active'])) { 
                                    echo count($team_data_row['active']);                            
                                    } else { echo "0";}
                                ?>
                            </td>
                            <td>
                            <?php if(isset($team_data_row['pending'])) { 
                            echo count($team_data_row['pending']);                            
                            } else { echo "0";}
                            ?>
                            </td>
                            <td>
                               <label class="switch">
                                  <input type="checkbox" class="switch-input" data-id="<?php echo $team_data_row['team_id']; ?>" value="<?php echo $team_data_row['teams_is_active']; ?>" <?php if($team_data_row['teams_is_active']==1){ echo 'checked';} ?>>
                                  <span class="switch-label" data-on="On" data-off="Off"></span>
                                  <span class="switch-handle"></span>
                                </label>

                            </td>
                                <td>

                                <a href="<?php echo url('/team-edit/'.$team_data_row['team_id'].'') ;?>">
                                <button name="checkout" id="checkout" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i></button>
                                </a>
                                    
                                <a href="<?php echo url('/team-members/'.$team_data_row['team_id'].'') ;?>">
                                <button name="checkout"  id="checkout"  class="btn btn-primary" > <i class="fa fa-users"></i> </button>
                                </a>
                                </td>
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