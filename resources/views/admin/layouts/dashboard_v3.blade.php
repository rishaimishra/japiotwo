<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>JAPIO-11</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
	<link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
@if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='home')) 
    
    <link href="{{ asset('css/plugins/c3/c3.min.css') }}" rel="stylesheet">
	


@endif
</head>


<body class="fixed-navigation">
    <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">

                    @if (Auth::user()->pro_img != '')
                        <img alt="image" class="rounded-circle" src="{{ asset(Auth::user()->pro_img) }}" style="height: 48px;width: 48px;"/>
                    @endif 
                   
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="block m-t-xs font-bold">{{ Auth::user()->name }}</span>
                            <span class="text-muted text-xs block">{{ Auth::user()->position }} <b class="caret"></b></span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class="dropdown-item" href="{{ url('/profile') }}">Manage Profile</a></li>
                            <li><a class="dropdown-item" href="{{ url('/public/profile-update') }}">Change Password</a></li>
                            <!--
                            <li><a class="dropdown-item" href="#">Contacts</a></li>
                            <li><a class="dropdown-item" href="#">Mailbox</a></li>
                            <li class="dropdown-divider"></li>
                            !-->
                            <li><a class="dropdown-item" href="{{ url('/logout') }}">Logout</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        JA+
                    </div>
                </li>

                <?php 
                    $roleId   = Auth::user()->role_id;
                    $roleName = DB::table('roles')->find($roleId);
                ?>
                <!--- administrator start --->

                <?php if (Auth::check() && $roleName->name == 'administrator') { ?>
                    
                    <li  @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='manage_teams')) class="active" @endif >
                    <a href="{{ url('/team-list') }}" @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='manage_teams')) aria-expanded="true"  @else aria-expanded="false" @endif >
                    <i class="fa fa-users"></i>
                    <span class="nav-label">Manage Teams</span>
                    <span class="fa arrow"></span>
                    </a>
            
                    <ul @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='manage_teams')) class="nav nav-second-level collapse in" aria-expanded="true"       @else  class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;" @endif>
            
                     <li @if(isset($page_data['sub_menu_selected'])&&($page_data['sub_menu_selected'] =='manage_list')) class="active" @endif><a href="{{ url('/team-list') }}">Team List</a></li>
                                
                    <li  @if(isset($page_data['sub_menu_selected'])&&($page_data['sub_menu_selected'] =='manage_add')) class="active" @endif><a href="{{ url('/team-add') }}">Team Add</a></li>
                    </ul>
                    </li>
                    
                    <!-- plans menu start--->
                    <li  @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='plans')) class="active" @endif >
                    <a href="{{ url('/plans') }}" @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='manage_teams')) aria-expanded="true"  @else aria-expanded="false" @endif >
                    <i class="fa fa-diamond"></i>
                    <span class="nav-label">Manage Plans</span>
                    <span class="fa arrow"></span>
                    </a>
            
                    <ul @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='plans')) class="nav nav-second-level collapse in" aria-expanded="true"       @else  class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;" @endif>
            
                     <li @if(isset($page_data['sub_menu_selected'])&&($page_data['sub_menu_selected'] =='plans')) class="active" @endif><a href="{{ url('plans') }}">Plan List</a></li>
                                
                    <li  @if(isset($page_data['sub_menu_selected'])&&($page_data['sub_menu_selected'] =='store')) class="active" @endif><a href="{{ url('plan-add') }}">Plan Add</a></li>

                    <!--  <li  @if(isset($page_data['sub_menu_selected'])&&($page_data['sub_menu_selected'] =='addons')) class="active" @endif><a href="{{ url('addons') }}">Addon Plans</a></li>
                             -->
                    </ul>
                    </li>
                    <!-- plans menu end--->
                <!--- administrator end --->

                <!---team administrator start --->
                <?php }else if (Auth::check() && $roleName->name == 'team_administrator') { ?>

                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='home')) class="active" @endif>
        				<a href="{{ url('/home') }}">
        					<i class="fa fa-th-large"></i>
        					<span class="nav-label">Dashboard</span>
        					
        				</a>
    				
                    </li>

                    <li  @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='datasources')) class="active" @endif >
                        <a href="{{ url('/data-sources') }}">
                            <i class="fa fa-cubes"></i>
                            <span class="nav-label">Data Sources</span>
                        </a>
                    </li>

                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='connection')) class="active" @endif>
                        <a href="{{ url('/my-connections') }}">
                            <i class="fa fa-list"></i>
                            <span class="nav-label">My Connections</span>
                        </a>
                    </li>
                    
                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='data_ware_houses')) class="active" @endif>
                        <a href="{{ url('/data-ware-houses') }}">
                            <i class="fa fa-database"></i>
                            <span class="nav-label">Data Warehouse</span>
                        </a>
                    </li>

                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='visualization_tools')) class="active" @endif>

                        <a href="{{ url('/visualization-tools') }}">
                            <i class="fa fa-bar-chart-o"></i>
                            <span class="nav-label">Visualization Tools</span>
                        </a>
                    </li>
                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='my_team')) class="active" @endif>
                        <a href="{{ url('/my-team') }}">
                            <i class="fa fa-users"></i>
                            <span class="nav-label">My Team</span>
                        </a>
                    </li>	
                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='alert')) class="active" @endif>
                        <a href="{{ url('/alert') }}">
                            <i class="fa fa-warning"></i>
                            <span class="nav-label">Alert</span>
                        </a>
                    </li>
                    <!---team administrator end --->
                    <!----- Business Users start ---->
                    <?php }else if (Auth::check() && $roleName->name == 'business_users') { ?>
                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='home')) class="active" @endif>
                        
                        <a href="{{ url('/home') }}">
                            <i class="fa fa-th-large"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    
                    </li>


                    <li  @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='datasources')) class="active" @endif >
                        <a href="{{ url('/data-sources') }}">
                            <i class="fa fa-cubes"></i>
                            <span class="nav-label">Data Sources</span>
                        </a>
                    </li>

                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='connection')) class="active" @endif>
                        <a href="{{ url('/my-connections') }}">
                            <i class="fa fa-list"></i>
                            <span class="nav-label">My Connections</span>
                        </a>
                    </li>

                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='data_ware_houses')) class="active" @endif>
                        <a href="{{ url('/data-ware-houses') }}">
                            <i class="fa fa-database"></i>
                            <span class="nav-label">Data Warehouse</span>
                        </a>
                    </li>

                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='visualization_tools')) class="active" @endif>

                        <a href="{{ url('/visualization-tools') }}">
                            <i class="fa fa-bar-chart-o"></i>
                            <span class="nav-label">Visualization Tools</span>
                        </a>
                    </li>
                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='my_team')) class="active" @endif>
                        <a href="{{ url('/my-team') }}">
                            <i class="fa fa-users"></i>
                            <span class="nav-label">My Team</span>
                        </a>
                    </li>   
                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='alert')) class="active" @endif>
                        <a href="{{ url('/alert') }}">
                            <i class="fa fa-warning"></i>
                            <span class="nav-label">Alert</span>
                        </a>
                    </li>
                    <!----- Business Users end ---->
                    <!----- Integrator Users end ---->
                    <?php }else if (Auth::check() && $roleName->name == 'integrator_users') { ?>
                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='home')) class="active" @endif>
                        
                        <a href="{{ url('/home') }}">
                            <i class="fa fa-th-large"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    
                    </li>


                    <li  @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='datasources')) class="active" @endif >
                        <a href="{{ url('/data-sources') }}">
                            <i class="fa fa-cubes"></i>
                            <span class="nav-label">Data Sources</span>
                        </a>
                    </li>

                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='connection')) class="active" @endif>
                        <a href="{{ url('/my-connections') }}">
                            <i class="fa fa-list"></i>
                            <span class="nav-label">My Connections</span>
                        </a>
                    </li>

                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='data_ware_houses')) class="active" @endif>
                        <a href="{{ url('/data-ware-houses') }}">
                            <i class="fa fa-database"></i>
                            <span class="nav-label">Data Warehouse</span>
                        </a>
                    </li>

                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='visualization_tools')) class="active" @endif>

                        <a href="{{ url('/visualization-tools') }}">
                            <i class="fa fa-bar-chart-o"></i>
                            <span class="nav-label">Visualization Tools</span>
                        </a>
                    </li>
                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='my_team')) class="active" @endif>
                        <a href="{{ url('/my-team') }}">
                            <i class="fa fa-users"></i>
                            <span class="nav-label">My Team</span>
                        </a>
                    </li>   
                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='alert')) class="active" @endif>
                        <a href="{{ url('/alert') }}">
                            <i class="fa fa-warning"></i>
                            <span class="nav-label">Alert</span>
                        </a>
                    </li>
                <?php } ?>


                <?php if (Auth::check() && $roleName->name != 'administrator') { ?>
                    <li @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='upgrade-plan')) class="active" @endif>
                        <a href="{{ url('/upgrade-plan') }}">
                            <i class="fa fa-users"></i>
                            <span class="nav-label">Upgrade Plan</span>
                        </a>
                    </li>
                <?php
                }
                ?>


<li>
    <a href="{{route('metricdata',50)}}">
        <i class="fa fa-warning"></i>
        <span class="nav-label">Html1</span>
    </a>
</li>

<li>
    <a href="{{route('metricdata.filter')}}">
        {{-- ,[30,50,'Close Date'] --}}
        <i class="fa fa-warning"></i>
        <span class="nav-label">filter 30</span>
    </a>
</li>

<li>
    <a href="{{route('metricdata.arithmetic')}}">
        {{-- ,['max',50,'id'] --}}
        <i class="fa fa-warning"></i>
        <span class="nav-label">sum of id</span>
    </a>
</li>

<li>
    <a href="{{route('metricdata.comparator')}}">
        {{-- ,[50,'id','>=','5'] --}}
        <i class="fa fa-warning"></i>
        <span class="nav-label">Comparator</span>
    </a>
</li>

<li>
    <a href="{{route('metricdata.filter.groupby','deal_name')}}">
        <i class="fa fa-warning"></i>
        <span class="nav-label">Group by</span>
    </a>
</li>

<li>
    <a href="{{route('metricdata', 50)}}">
        <i class="fa fa-warning"></i>
        <span class="nav-label">Metric</span>
    </a>
</li>



                <!------ Integrator Users end ------->
                </ul>

        </div>
    </nav>

	
        <div id="page-wrapper" class="gray-bg sidebar-content">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
		
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="#" style="visibility:hidden;">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>

            <ul class="nav navbar-top-links navbar-right">
                <li>
                  <span class="m-r-sm text-muted welcome-message">Welcome to JAPIO</span>
                </li>
                <li>
                <?php 
                
                 if(Session::get("subscribed_plan_type")=="free"){
                    $days = Session::get("plan_validity_days");
                    $da="days";
                    if($days=="1"){
                        $da="day";
                    }
                    echo "<b>".$days." ".$da." left</b>";
                
                  ?>
                    <button type="button" name="back" class="btn btn-primary btn-sm"><a href="{{ url('/upgrade-plan') }}" style="color: white !important;"> UPGRADE </a></button>
                
                <?php 
                 }elseif (Auth::check() && $roleName->name != 'administrator') {?>
                    <a href="{{ url('/upgrade-plan') }}" style="display: inline !important;">
                    <i class="fa fa-diamond"></i></a>
                <?php 
                }
                ?>
                    
                  
                </li>
               <!--
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a class="dropdown-item float-left" href="#">
                                    <img alt="image" class="rounded-circle" src="{{ asset('img/a7.jpg') }}">
                                </a>
                                <div>
                                    <small class="float-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a class="dropdown-item float-left" href="#">
                                    <img alt="image" class="rounded-circle" src="{{ asset('img/a4.jpg') }}">
                                </a>
                                <div>
                                    <small class="float-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a class="dropdown-item float-left" href="#">
                                    <img alt="image" class="rounded-circle" src="{{ asset('img/profile.jpg') }}">
                                </a>
                                <div>
                                    <small class="float-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html" class="dropdown-item">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                !-->
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" onclick="change_satus()">
                        <i class="fa fa-bell"></i>  
						<div id="notifiation_hideshow" class="notifiation_hideshow" style="display: none">
						<span class="label label-primary"><div id="notifiation_num" class="notifiation_num">
                    
                    </div></span>
					</div>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">

					<div id="notifiation" class="notifiation">
                        No notifications yet
                    </div>

				  </ul>
                </li>


                <li>
                    <a href="{{ url('/logout') }}">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
                <!--
                <li>
                    <a class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li>
                !-->
            </ul>

        </nav>
		
		
		
		
		
		
        </div>
        


	@yield('content1')
    
	@yield('content2')
        

	   <div class="footer">
            <div class="float-right">
            <a href="{{ route('privacy-policies') }}">Privacy Policies</a> | <a href="{{ route('data-policies') }}">Data Policies</a> | <a href="{{ route('terms-and-conditions') }}">Terms and Conditions</a> | <a href="{{route('membership-agreement')}}">Membership Agreement</a>
            </div>
            <div>
                <strong>Copyright</strong> JAPIO &copy; 2020
            </div>
        </div>

        </div>
		
        <div id="right-sidebar">
		
		
            <div class="sidebar-container">

                <ul class="nav nav-tabs navs-3">
                    <li>
                        <a class="nav-link active" data-toggle="tab" href="#tab-1"> Notes </a>
                    </li>
                    <li>
                        <a class="nav-link" data-toggle="tab" href="#tab-2"> Projects </a>
                    </li>
                    <li>
                        <a class="nav-link" data-toggle="tab" href="#tab-3"> <i class="fa fa-gear"></i> </a>
                    </li>
                </ul>

                <div class="tab-content">


                    <div id="tab-1" class="tab-pane active">

                        <div class="sidebar-title">
                            <h3> <i class="fa fa-comments-o"></i> Latest Notes</h3>
                            <small><i class="fa fa-tim"></i> You have 10 new message.</small>
                        </div>

                        <div>

                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="{{ asset('img/a1.jpg') }}">

                                        <div class="m-t-xs">
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">

                                        There are many variations of passages of Lorem Ipsum available.
                                        <br>
                                        <small class="text-muted">Today 4:21 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="{{ asset('img/a2.jpg') }}">
                                    </div>
                                    <div class="media-body">
                                        The point of using Lorem Ipsum is that it has a more-or-less normal.
                                        <br>
                                        <small class="text-muted">Yesterday 2:45 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="{{ asset('img/a3.jpg') }}">

                                        <div class="m-t-xs">
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        Mevolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                                        <br>
                                        <small class="text-muted">Yesterday 1:10 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="{{ asset('img/a4.jpg') }}">
                                    </div>

                                    <div class="media-body">
                                        Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the
                                        <br>
                                        <small class="text-muted">Monday 8:37 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="{{ asset('img/a8.jpg') }}">
                                    </div>
                                    <div class="media-body">

                                        All the Lorem Ipsum generators on the Internet tend to repeat.
                                        <br>
                                        <small class="text-muted">Today 4:21 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="{{ asset('img/a7.jpg') }}">
                                    </div>
                                    <div class="media-body">
                                        Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                                        <br>
                                        <small class="text-muted">Yesterday 2:45 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="{{ asset('img/a3.jpg') }}">

                                        <div class="m-t-xs">
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below.
                                        <br>
                                        <small class="text-muted">Yesterday 1:10 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="float-left text-center">
                                        <img alt="image" class="rounded-circle message-avatar" src="{{ asset('img/a4.jpg') }}">
                                    </div>
                                    <div class="media-body">
                                        Uncover many web sites still in their infancy. Various versions have.
                                        <br>
                                        <small class="text-muted">Monday 8:37 pm</small>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div id="tab-2" class="tab-pane">

                        <div class="sidebar-title">
                            <h3> <i class="fa fa-cube"></i> Latest projects</h3>
                            <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                        </div>

                        <ul class="sidebar-list">
                            <li>
                                <a href="#">
                                    <div class="small float-right m-t-xs">9 hours ago</div>
                                    <h4>Business valuation</h4>
                                    It is a long established fact that a reader will be distracted.

                                    <div class="small">Completion with: 22%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                    </div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small float-right m-t-xs">9 hours ago</div>
                                    <h4>Contract with Company </h4>
                                    Many desktop publishing packages and web page editors.

                                    <div class="small">Completion with: 48%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small float-right m-t-xs">9 hours ago</div>
                                    <h4>Meeting</h4>
                                    By the readable content of a page when looking at its layout.

                                    <div class="small">Completion with: 14%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-primary float-right">NEW</span>
                                    <h4>The generated</h4>
                                    <!--<div class="small float-right m-t-xs">9 hours ago</div>-->
                                    There are many variations of passages of Lorem Ipsum available.
                                    <div class="small">Completion with: 22%</div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small float-right m-t-xs">9 hours ago</div>
                                    <h4>Business valuation</h4>
                                    It is a long established fact that a reader will be distracted.

                                    <div class="small">Completion with: 22%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                    </div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small float-right m-t-xs">9 hours ago</div>
                                    <h4>Contract with Company </h4>
                                    Many desktop publishing packages and web page editors.

                                    <div class="small">Completion with: 48%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small float-right m-t-xs">9 hours ago</div>
                                    <h4>Meeting</h4>
                                    By the readable content of a page when looking at its layout.

                                    <div class="small">Completion with: 14%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-primary float-right">NEW</span>
                                    <h4>The generated</h4>
                                    <!--<div class="small float-right m-t-xs">9 hours ago</div>-->
                                    There are many variations of passages of Lorem Ipsum available.
                                    <div class="small">Completion with: 22%</div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>

                        </ul>

                    </div>

                    <div id="tab-3" class="tab-pane">

                        <div class="sidebar-title">
                            <h3><i class="fa fa-gears"></i> Settings</h3>
                            <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                        </div>

                        <div class="setings-item">
                    <span>
                        Show notifications
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example">
                                    <label class="onoffswitch-label" for="example">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Disable Chat
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" checked class="onoffswitch-checkbox" id="example2">
                                    <label class="onoffswitch-label" for="example2">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Enable history
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example3">
                                    <label class="onoffswitch-label" for="example3">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Show charts
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example4">
                                    <label class="onoffswitch-label" for="example4">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Offline users
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example5">
                                    <label class="onoffswitch-label" for="example5">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Global search
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example6">
                                    <label class="onoffswitch-label" for="example6">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                    <span>
                        Update everyday
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example7">
                                    <label class="onoffswitch-label" for="example7">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-content">
                            <h4>Settings</h4>
                            <div class="small">
                                I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                And typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                                Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                            </div>
                        </div>

                    </div>
                </div>

            </div>



        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    
   
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Flot -->
    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.symbol.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/curvedLines.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Jvectormap -->
    <script src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('js/demo/sparkline-demo.js') }}"></script>

    <!-- ChartJS-->
    <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="http://webapplayers.com/inspinia_admin-v2.9.3/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script type="text/javascript" src="{{ asset('js/modernizr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin-plans.js') }}"></script>
 <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script>
        $(document).ready(function(){
            $('.dataTables-teamList').DataTable({
               pageLength: 25,
                responsive: true,
                buttons: [

                    {
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
             
            

            $('#inputSearch').keyup(function(){
              var text = $(this).val();
              $('.data-source-div').hide();
              $('.data-source-div :contains("'+text+'")').closest('.data-source-div').show();
             });
             $.expr[":"].contains = $.expr.createPseudo(function(arg) {
              return function( elem ) {
               return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
              };
            });

            $("body").on("change",".switch-input" ,function(){
                var is_active =$(this).val();
                var id =$(this).data('id');
                $.ajax({
                  type: "POST",
                  url: "{{ url('change-team-status') }}",
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  data: {id:id,is_active:is_active},
                  
                  success: function(data){
                     console.log(data);
                     if(data.success){
                        //location.reload();
                     }
                  }
                });
            });

        });

         $(document).ready(function () { 
        
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#min').datepicker("getDate");
                    var max = $('#max').datepicker("getDate");
                    var startDate = new Date(data[5]);
                    
                    if (min == null && max == null) { return true; }
                    if (min == null && startDate <= max) { return true; }
                    if(max == null && startDate >= min) { return true; }
                    if (startDate <= max && startDate >= min) { return true; }
                    return false;
                }
            );

      
            $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true , dateFormat:"yy-mm-dd"});
            $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true, dateFormat:"yy-mm-dd" });

             var table = $('.dataTables-datawareHouse').DataTable({
               pageLength: 25,
                "order": [[ 5, "desc" ]],
                responsive: true,
                buttons: [

                    {
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

            $('#min, #max').change(function () {
                table.draw();
            });
        });

    </script>

<script>
          
	function   change_satus(){
$.ajax({
      type:"get",
      url:"{{ url('/change_notification_status') }}",
      datatype:"text",
      success:function(data)
      {
		
        
      }
    });
 
	   }
	   
	   
	  
       setInterval(function()
{ 
  var feedback =  $.ajax({
      type:"get",
      url:"{{ url('/notification') }}",
      datatype:"json",
      success:function(data)
      {
		var output=  JSON.parse(data);
      
        if(output.data!=''){
            $('#notifiation').html(output.data);
        }else{
            $('#notifiation').html('<div style="text-align:center;">No notifications yet</div>');
        }
		if(output.total_num=="0"){
	
			$("#notifiation_hideshow").hide();
			
		} else {
			$("#notifiation_hideshow").show();
			 $('#notifiation_num').html(output.total_num);
		}
       
      
          //do something with response data
      }
    });
   

}, 1000);//time in milliseconds
       
       
    
        $(document).ready(function(){

 $(".select2_demo_2").select2({
                theme: 'bootstrap4',
            });
            
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

       });
    </script>
    @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='home')) 
    
    <script src="{{ asset('js/plugins/d3/d3.min.js') }}"></script>
        <script src="{{ asset('js/plugins/c3/c3.min.js') }}"></script>
 <script>


        $(document).ready(function () {           
 <?php 
 if(isset($chart) && is_array($chart)){
 foreach($chart as $chart_key=>$chart_value){  
 if((count($chart_value['failure'])=="0")&&(count($chart_value['success'])=="0")){
 } else {
     
 
 ?>  
            c3.generate({
                bindto: '#<?php echo $chart_key; ?>',
                data:{
                    columns: [
                        ['Failure', <?php echo count($chart_value['failure']);?>],
                        ['Success', <?php echo count($chart_value['success']);?>]
                    ],
                    colors:{
                        Failure: '#dc3545',
                        Success: '#28a745'
                    },
                    type : 'pie'
                }
            });
 <?php 
 }
 } 
}?>
        });

    </script>
@endif

    @if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] !='connection')) 
    
    <script>
        $(document).ready(function() {

            var lineData = {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [
                    {
                        label: "Example dataset",
                        backgroundColor: "rgba(26,179,148,0.5)",
                        borderColor: "rgba(26,179,148,0.7)",
                        pointBackgroundColor: "rgba(26,179,148,1)",
                        pointBorderColor: "#fff",
                        data: [28, 48, 40, 19, 86, 27, 90]
                    },
                    {
                        label: "Example dataset",
                        backgroundColor: "rgba(220,220,220,0.5)",
                        borderColor: "rgba(220,220,220,1)",
                        pointBackgroundColor: "rgba(220,220,220,1)",
                        pointBorderColor: "#fff",
                        data: [65, 59, 80, 81, 56, 55, 40]
                    }
                ]
            };

            var lineOptions = {
                responsive: true
            };


            var ctx = document.getElementById("lineChart").getContext("2d");
            new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});

        });
        
    </script>
 @endif
</body>
</html>
