<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | ChartJS</title>

    <link href="{{asset('assets-builder/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets-builder/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{asset('assets-builder/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('assets-builder/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets-builder/css/all-style-01.css')}}" rel="stylesheet">
    <link href="{{asset('assets-builder/css/custom2.css')}}" rel="stylesheet">
    <script type = "text/javascript" src = "{{asset('assets-builder/js/google_chart.js')}}"></script>
  
   </head>
   <body>
      <header class="bg-light navbar top-head">
         <button
            type="button"
            id="navButtonMenu"
            class="btn btn-light btn-menu">
            <!-- &#8801; -->
            <i class="fa fa-align-left"></i>
         </button>
         <a href="#">JAPIO</a>    
      </header>
      <div id="wrapper" class="builder-wrap">
      <div class="nav-hide-overlay"></div>
      <nav class="navbar-default navbar-static-side builder-nav" role="navigation">
         <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
               <li class="chart-div" style="padding: 10px;">
                  <!-- <a> -->
                  <!-- <div class="">
                     <div class="form-group">
                        <input type="text" class="form-control chart-title" id="chart-title" aria-describedby="chart-title" placeholder="Click to add a title">
                     </div>
                     <div class="form-group">
                        <input type="text" class="form-control chart-description" id="chart-description" aria-describedby="chart-description" placeholder="Click to add a description">
                     </div>
                  </div> -->
                  <div>
                     <div class="form-group">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changeChart">
                        <span>Select Chart type</span> 
                        &nbsp;&nbsp;
                        <i class="fa fa-bar-chart-o"></i>
                        </button>
                     </div>
                  </div>
                  <div class="pt-0 axis-select all column">
                     <label for="valuesY">Values (y-axis)</label>
                     <div id="yAxisDiv" class="dynamic-axis-append y-axis-parent-div">
                        <button type="button" id="addYAxisData" onClick="tableShadow()" class="btn btn-primary btn-sm my-1">+ Add value</button>
                     </div>
                  </div>
                  <div class="form-group axis-select all column">
                     <label for="valuesX">Values (x-axis)</label>
                     <div id="xAxisDiv" class="dynamic-axis-append x-axis-parent-div" style="display: none;">
                        <div class="d-flex justify-content-between">
                           <div class="dropdown dropdown-axis" id="xaxis_dd">
                                 <input type="hidden" id="x_axis" name="x_axis">
                                 <input type="hidden" id="x_axis_sort" name="x_axis_sort">
                                 <button type="button" id="x-axis_drop" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
                                 <span>Choose...</span>
                                 <span><i class="fa fa-chevron-down svg1"></i></span>
                                 </button>
                                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="x-axis_drop" id="Xvalues">
                                 </div>
                           </div>
                           <!-- d-none -->
                           <!-- code:srv-101 hide when slect is other than date -->
                           <span class="aaof x-by">by</span>
                           <!-- code:srv-101 hide when slect is other than date -->
                           <select class="form-control x-filter" >
                              <option value="1">Day</option>
                              <option value="2">Week</option>
                              <option value="3">Month</option>
                              <option value="4">Year</option>
                           </select>
                           <div class="">
                              <button data-toggle="dropdown" class="btn btn-white dropdown-toggle option" type="button">
                              <i class="fa fa-ellipsis-v"></i>
                              </button>
                              <ul class="dropdown-menu float-right">
                                 <li><a href="#">Action</a></li>
                                 <li><a href="#">Another action</a></li>
                                 <li><a href="#">Something else here</a></li>
                                 <li class="dropdown-divider"></li>
                                 <li>
                                    <a 
                                       href="#" 
                                       class="text-danger">Separated link dasd</a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                    </div>
                     <!-- <button type="button" class="btn btn-primary mt-1">+ Add value</button> -->
                     <button type="button" id="addXAxisData" class="btn btn-primary btn-sm my-1 all column" onclick="xaxis_option()">+ Add value</button>
                     <div id="colorModal" class="modalHide">
                        <div class="overlay-color-modal" onClick="hideModal()"></div>
                        <div class="card">
                           <form class="demoForm" id="demoForm">
                              <div>
                                 <div class="color-div">
                                    <div>
                                       <input id="colormod1" type="radio" name="colorModal" class="color-pallet" onChange="setChartColor(this)" value="#FF1A66">
                                       <label for="colormod1"></label>
                                    </div>
                                    <div>
                                       <input id="colormod2" type="radio" name="colorModal" class="color-pallet" onChange="setChartColor(this)" value="#991AFF">
                                       <label for="colormod2"></label>
                                    </div>
                                    <div>
                                       <input id="colormod3" type="radio" name="colorModal" class="color-pallet" onChange="setChartColor(this)" value="#CCFF1A">
                                       <label for="colormod3"></label>
                                    </div>
                                    <div>
                                       <input id="colormod4" type="radio" name="colorModal" class="color-pallet" onChange="setChartColor(this)" value="#00E680">
                                       <label for="colormod4"></label>
                                    </div>
                                    <div>
                                       <input id="colormod5" type="radio" name="colorModal" class="color-pallet" onChange="setChartColor(this)" value="#1AFF33">
                                       <label for="colormod5"></label>
                                    </div>
                                 </div>
                                 <div class="mt-2">
                                    <label for="colorInput" class="text-dark">Color Pallet</label>
                                    <input id="colorInput" name="colorModal" type="color" class="color-input" onChange="setChartColor(this)" value="#aaffaa">
                                 </div>
                                 <div class="mt-2">
                                    <input 
                                       id="colorInput2"
                                       name="colorModal"
                                       type="text"
                                       class="color-input"
                                       onKeyUp="setChartColor(this)"
                                       placeholder="format #XXXXXX">
                                 </div>
                              </div>
                           </form>
                           <div class="card-footer d-flex p-0 justify-content-end">
                              <button type="button" class="btn btn-sm mt-2 btn-danger" onClick="removeChart()">Remove</button>&nbsp;
                              <button 
                                 type="button"
                                 class="btn btn-sm mt-2 btn-secondary"
                                 data-dismiss="modal"
                                 onClick="hideModal()">Close</button>
                           </div>
                        </div>
                     </div>
                     
                     <div class="d-block">
                        <button 
                           type="button"
                           class="btn btn-primary d-none"
                           onClick="updateChart()">UPDATE CHART</button>
                     </div>
                     <!-- my-html-code-input -->
                     <!-- my-html-code-input -->
                     <!-- </a> -->
                     <!-- pie & donut chart start -->
                     <div class="pt-0 axis-select all ">
                        <label for="valuesY">Data Series</label>
                        <div class="dynamic-axis-append y-axis-parent-div">
                           <button type="button" class="btn btn-primary btn-sm my-1">+ Add data series</button>
                           <!-- only 1 input field for pie & donut chart -->
                           <div class="d-flex justify-content-between axis-append-div">
                              <input type="text" class="axis-append-input" placeholder="yAx1">
                              <div class="dropdown dropdown-axis">
                                 <button type="button" class="btn btn-light dropdown-toggle" id="pieChartSums" data-toggle="dropdown">
                                 <span>Sum</span>
                                 <span><i class="fa fa-chevron-down svg1"></i></span>
                                 </button>
                                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pieChartSums">
                                    <a href="#" class="drow-item1 selected">Sum</a>
                                    <a href="#" class="drow-item1">Count</a>
                                    <a href="#" class="drow-item1">Average</a>
                                    <a href="#" class="drow-item1">Max</a>
                                    <a href="#" class="drow-item1">Min</a>
                                    <a href="#" class="drow-item1">Median</a>
                                 </div>
                              </div>
                              <span class="aaof">of</span>
                              <div class="dropdown dropdown-axis">
                                 <button type="button" class="btn btn-light dropdown-toggle" id="pieChartColumn" data-toggle="dropdown">
                                 <span>Choose...</span>
                                 <span><i class="fa fa-chevron-down svg1"></i></span>
                                 </button>
                                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pieChartColumn">
                                    <a href="#" class="drow-item1 selected">Column 1</a>
                                    <a href="#" class="drow-item1">Column 2</a>
                                    <a href="#" class="drow-item1">Column 3</a>
                                 </div>
                              </div>
                              <div class="">
                                 <button class="btn btn-white option test" type="button" onclick="openColorModal('1')">
                                 <i class="fa fa-eyedropper"></i>
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="pt-0 axis-select all">
                        <!-- only for pie & donut -->
                        <label for="valuesY">Slices</label>
                        <div class="dynamic-axis-append y-axis-parent-div">
                           <button type="button" class="btn btn-primary btn-sm my-1">+ Add grouping</button>
                           <!-- only 1 input field -->
                           <div class="d-flex justify-content-between axis-append-div">
                              <div class="dropdown dropdown-axis">
                                 <button type="button" class="btn btn-light dropdown-toggle" id="pieChartColumns2" data-toggle="dropdown">
                                 <span>Choose...</span>
                                 <span><i class="fa fa-chevron-down svg1"></i></span>
                                 </button>
                                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pieChartColumns2">
                                    <a href="#" class="drow-item1 selected">Column 1</a>
                                    <a href="#" class="drow-item1">Column 2</a>
                                    <a href="#" class="drow-item1">Column 3</a>
                                 </div>
                              </div>
                              <div class="">
                                 <button class="btn btn-white option test" type="button"><i class="fa fa-trash"></i></button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- pie & donut chart end -->
                     <!-- gauge chart start -->
                     <div class="pt-0 axis-select all gauge">
                        <label for="valuesY">Gauge value</label>
                        <div class="dynamic-axis-append y-axis-parent-div">
                           <button type="button" onclick="show_gauge_value()" class="btn btn-primary btn-sm my-1">+ Add value</button>
                           <!-- only 1 input field -->
                           <div class="d-flex justify-content-between axis-append-div hide" id="gauge_value">
                              <div class="dropdown-axis">
                                <button type="button" class="btn btn-light">
                                  <span>Select a cell</span>
                                </button>
                              </div>
                              <div class="">
                                 <button class="btn btn-white option test" type="button">
                                    <i class="fa fa-eyedropper"></i>
                                  </button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="pt-0 axis-select all gauge">
                        <label for="valuesY">Min value</label>
                        <div class="dynamic-axis-append y-axis-parent-div">
                           <button type="button" class="btn btn-primary btn-sm my-1">+ Add min</button>
                           <!-- only 1 input field -->
                           <div class="d-flex justify-content-between axis-append-div">
                            <div class="dropdown-axis">
                              <button type="button" class="btn btn-light">
                                <span>Select a cell</span>
                              </button>
                            </div>
                              <div class="">
                                 <button class="btn btn-white option test" type="button"><i class="fa fa-trash"></i></button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="pt-0 axis-select all gauge">
                        <label for="valuesY">Max value</label>
                        <div class="dynamic-axis-append y-axis-parent-div">
                           <button type="button" class="btn btn-primary btn-sm my-1">+ Add max</button>
                           <!-- only 1 input field -->
                           <div class="d-flex justify-content-between axis-append-div">
                            <div class="dropdown-axis">
                              <button type="button" class="btn btn-light">
                                <span>Select a cell</span>
                              </button>
                            </div>
                              <div class="">
                                 <button class="btn btn-white option test" type="button"><i class="fa fa-trash"></i></button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- gauge chart end -->
                     <!-- bubble chart start -->
                     <div class="pt-0 axis-select bubble all">
                        <label for="valuesY">Y-Axis</label>
                        <div class="dynamic-axis-append y-axis-parent-div">
                           <button type="button" class="btn btn-primary btn-sm my-1">+ Y-Axis</button>
                           <!-- only 1 input field -->
                           <div class="d-flex justify-content-between axis-append-div">
                            <div class="dropdown-axis">
                              <button type="button" class="btn btn-light">
                                <span>Select a cell</span>
                              </button>
                            </div>
                            <input type="text" class="form-control input-field1" placeholder="Enter a title">
                            <div class="">
                               <button class="btn btn-white option test" type="button">
                                  <i class="fa fa-trash"></i>
                                </button>
                            </div>
                              
                           </div>
                        </div>
                     </div>
                     <div class="pt-0 axis-select bubble all">
                        <label for="valuesY">X-Axis</label>
                        <div class="dynamic-axis-append y-axis-parent-div">
                           <button type="button" class="btn btn-primary btn-sm my-1">+ X-Axis</button>
                           <!-- only 1 input field -->
                           <div class="d-flex justify-content-between axis-append-div">
                            <div class="dropdown-axis">
                              <button type="button" class="btn btn-light">
                                <span>Select a cell</span>
                              </button>
                            </div>
                            <input type="text" class="form-control input-field1" placeholder="Enter a title">
                            <div class="">
                               <button class="btn btn-white option test" type="button">
                                  <i class="fa fa-trash"></i>
                                </button>
                            </div>
                           </div>
                        </div>
                     </div>
                     <div class="pt-0 axis-select bubble all">
                        <label for="valuesY">Bubbles Values</label>
                        <div class="dynamic-axis-append y-axis-parent-div">
                           <button type="button" class="btn btn-primary btn-sm my-1">+ Add Bubbles Values</button>
                           <!-- only 1 input field -->
                           <div class="d-flex justify-content-between axis-append-div">
                            <div class="dropdown-axis">
                              <button type="button" class="btn btn-light">
                                <span>Select a cell</span>
                              </button>
                            </div>
                            <input type="text" class="form-control input-field1" placeholder="Enter a title">
                            <div class="">
                               <button class="btn btn-white option test" type="button">
                                  <i class="fa fa-eyedropper"></i>
                                </button>
                            </div>
                           </div>
                        </div>
                     </div>
                     <div class="pt-0 axis-select bubble all">
                        <label for="valuesY">Lables</label>
                        <div class="dynamic-axis-append y-axis-parent-div">
                           <button type="button" class="btn btn-primary btn-sm my-1">+ Add labels</button>
                           <!-- only 1 input field -->
                           <div class="d-flex justify-content-between axis-append-div">
                            <div class="dropdown-axis">
                              <button type="button" class="btn btn-light">
                                <span>Select a cell</span>
                              </button>
                            </div>
                            <input type="text" class="form-control input-field1" placeholder="Enter a title">
                            <div class="">
                               <button class="btn btn-white option test" type="button">
                                  <i class="fa fa-trash"></i>
                                </button>
                            </div>
                           </div>
                        </div>
                     </div>
                     <!-- bubble chart end -->
                     <!-- table chart start -->
                     <div class="pt-0 axis-select all table">
                        <label for="valuesY">Data Series</label>
                        <div class="dynamic-axis-append y-axis-parent-div " id="table-dropdown">
                           <button type="button" class="btn btn-primary btn-sm my-1" onclick="tableShadow()">+ Add data series</button>
                           <!-- multiple input field for pie & donut chart -->
                           
                        </div>
                     </div>
                     <div class="pt-0 axis-select all table">
                        <label for="valuesY">Grouping (optional)</label>
                        <div class="dynamic-axis-append y-axis-parent-div">
                           <button type="button" class="btn btn-primary btn-sm my-1">+ Add grouping</button>
                           <!-- only 1 input field -->
                           <div class="d-flex justify-content-between axis-append-div">
                              <div class="dropdown dropdown-axis">
                                 <button type="button" class="btn btn-light dropdown-toggle" id="TableChartColumns2" data-toggle="dropdown">
                                 <span>Choose...</span>
                                 <span><i class="fa fa-chevron-down svg1"></i></span>
                                 </button>
                                 <div class="dropdown-menu dropdown-menu-right " aria-labelledby="TableChartColumns2">
                                    <a href="#" class="drow-item1 selected">Column 1</a>
                                    <a href="#" class="drow-item1">Column 2</a>
                                    <a href="#" class="drow-item1">Column 3</a>
                                 </div>
                              </div>
                              <div class="">
                                 <button class="btn btn-white option test" type="button"><i class="fa fa-trash"></i></button>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- table chart end -->
                     <!-- map chart start -->
                     <div class="pt-0 axis-select bubble all">
                      <label for="valuesY">Region</label>
                      <div class="dynamic-axis-append y-axis-parent-div">
                         <button type="button" class="btn btn-primary btn-sm my-1">+ Add Region</button>
                         <!-- only 1 input field -->
                         <div class="d-flex justify-content-between axis-append-div">
                          <div class="dropdown-axis">
                            <button type="button" class="btn btn-light">
                              <span>Select a cell</span>
                            </button>
                          </div>
                          <div class="">
                             <button class="btn btn-white option test" type="button">
                                <i class="fa fa-trash"></i>
                              </button>
                          </div>
                            
                         </div>
                      </div>
                   </div>
                   <div class="pt-0 axis-select bubble all">
                      <label for="valuesY">Data Series</label>
                      <div class="dynamic-axis-append y-axis-parent-div">
                         <button type="button" class="btn btn-primary btn-sm my-1">+ X-Axis</button>
                         <!-- only 1 input field -->
                         <div class="d-flex justify-content-between axis-append-div">
                          <div class="dropdown-axis">
                            <button type="button" class="btn btn-light">
                              <span>Select a cell</span>
                            </button>
                          </div>
                          <input type="text" class="form-control input-field1" placeholder="Enter a title">
                          <div class="">
                             <button class="btn btn-white option test" type="button">
                                <i class="fa fa-eyedropper"></i>
                              </button>
                          </div>
                         </div>
                      </div>
                   </div>
                   <!-- map chart end -->
<!-- acc dropdown filter,slice -->
<!-- acc dropdown filter,slice -->
<!-- data-parent="#sidePanel1" -->
<div class="accordion" id="sidePanel1">
  <div class="card">
    <div class="card-header" id="headingOne">
        <button class="btn btn-link btn-header-filter" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <span>Key Values</span>
          <i class="fa fa-chevron-right svg1"></i>
        </button>
    </div>
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#sidePanel1">
      <div class="card-body">
         <div class="dynamic-axis-append y-axis-parent-div" id="key-dd">
           <!-- multiple field for pie & donut chart -->
           
           <button type="button" class="btn btn-primary btn-sm my-1" onclick="keyvalue_dropdown()">+ Add a key value</button>
         </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
        <button class="btn btn-link btn-header-filter collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          <span>Date Range</span>
          <i class="fa fa-chevron-right svg1"></i>
        </button>
      
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#sidePanel1">
      <div class="card-body">
         <div class="date-range ">
            <div class="form-group">
               <label for="date-range">Display date range</label>
               <div class="dropdown dropdown-axis">
                  <button type="button" class="btn btn-light dropdown-toggle" id="daterange_filter" data-toggle="dropdown">
                  <span>Display All Data</span>
                  <span><i class="fa fa-chevron-down svg1"></i></span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right date-range-dropdown 
                  seach-filter-list-div" aria-labelledby="daterange_filter">
                     <input type="text" class="form-control search-input1" placeholder="search">
                     <a href="#" onclick="daterange_filter('Display All Data')" class="d-block selected">Display All Data</a>
                     <h5>Day</h5>
                     <div class="dropdown-divider"></div>
                     <a href="#" onclick="daterange_filter('Current Day','1')">Current Day</a>
                     <a href="#" onclick="daterange_filter('Yesterday','1')">Yesterday</a>
                     <a href="#" onclick="daterange_filter('Last 7 Days','7')">Last 7 Days</a>
                     <a href="#" onclick="daterange_filter('Last 14 Days','14')">Last 14 Days</a>
                     <a href="#" onclick="daterange_filter('Last 30 Days','30')">Last 30 Days</a>
                     <a href="#" onclick="daterange_filter('Last 60 Days','60')">Last 60 Days</a>
                     <a href="#" onclick="daterange_filter('Last 90 Days','90')">Last 90 Days</a>
                     <a href="#" onclick="daterange_filter('Last 90 Days','180')">Last 180 Days</a>
                     <a href="#" onclick="daterange_filter('Last 365 Days','365')">Last 365 Days</a>
                     <h5>Week</h5>
                     <div class="dropdown-divider"></div>
                     <a href="#" onclick="daterange_filter('This Week','7')">This Week</a>
                     <a href="#" onclick="daterange_filter('Week to Date','7')">Week to Date</a>
                     <a href="#" onclick="daterange_filter('Last Week','7')">Last Week</a>
                     <a href="#" onclick="daterange_filter('Last 2 Weeks','14')">Last 2 Weeks</a>
                     <h5>Month</h5>
                     <div class="dropdown-divider"></div>
                     <a href="#" onclick="daterange_filter('This Month')">This Month</a>
                     <a href="#" onclick="daterange_filter('Month to Date')">Month to Date</a>
                     <a href="#" onclick="daterange_filter('Last Month')">Last Month</a>
                     <a href="#" onclick="daterange_filter('Last 6 Months')">Last 6 Months</a>
                     <h5>Quarter</h5>
                     <div class="dropdown-divider"></div>
                     <a href="#" onclick="daterange_filter('This Quarter')">This Quarter</a>
                     <a href="#" onclick="daterange_filter('This Fiscal Quarter')">This Fiscal Quarter</a>
                     <a href="#" onclick="daterange_filter('Quarter to Date')">Quarter to Date</a>
                     <a href="#" onclick="daterange_filter('Fiscal Quarter to Date')">Fiscal Quarter to Date</a>
                     <a href="#" onclick="daterange_filter('Last Quarter')">Last Quarter</a>
                     <a href="#" onclick="daterange_filter('Last Fiscal Quarter')">Last Fiscal Quarter</a>
                     <h5>Year</h5>
                     <div class="dropdown-divider"></div>
                     <a href="#" onclick="daterange_filter('This Year')">This Year</a>
                     <a href="#" onclick="daterange_filter('Year to Date')">This Fiscal Year</a>
                     <a href="#" onclick="daterange_filter('Year to Date')">Year to Date</a>
                     <a href="#" onclick="daterange_filter('Fiscal Year to Date')">Fiscal Year to Date</a>
                     <a href="#" onclick="daterange_filter('Last Year')">Last Year</a>
                     <a href="#" onclick="daterange_filter('Last Fiscal Year')">Last Fiscal Year</a>
                     <a href="#" onclick="daterange_filter('Last 2 Years')">Last 2 Years</a>
                     <a href="#" onclick="daterange_filter('Last 2 Fiscal Years')">Last 2 Fiscal Years</a>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label for="date-range">What date column do you want to use?</label>
               <div class="dropdown dropdown-axis">
                  <button type="button" class="btn btn-light dropdown-toggle" id="daterange_col" data-toggle="dropdown">
                  <span>Choose..</span>
                  <span><i class="fa fa-chevron-down svg1"></i></span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right seach-filter-list-div date-range-dropdown" id="daterange_op" aria-labelledby="daterange_col">
                     <input type="text" class="form-control search-input1" placeholder="search">
                  </div>
               </div>
            </div>
         </div>
      </div>
    </div>
  </div>
  <div class="card">
   <div class="card-header" id="headingThree">
       <button class="btn btn-link btn-header-filter collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
         <span>Filter</span>
         <i class="fa fa-chevron-right svg1"></i>
       </button>
     
   </div>
   <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#sidePanel1">
     <div class="card-body">
        <div class="dynamic-axis-append y-axis-parent-div" id="filter-dd">
          
           <button type="button" class="btn btn-primary btn-sm my-1" onclick="filtervalue_dropdown()">+ Add a filter</button>
        </div>
     </div>
   </div>
 </div>
  <div class="card">
    <div class="card-header" id="headingFour">
        <button class="btn btn-link btn-header-filter collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          <span>Compare Dates</span>
          <i class="fa fa-chevron-right svg1"></i>
        </button>
      
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#sidePanel1">
      <div class="card-body">
         <div class="dynamic-axis-append y-axis-parent-div">
           <div class="d-flex justify-content-between axis-append-div hide" id="compare_div">
             <div class="dropdown dropdown-axis">
               <button type="button" class="btn btn-light dropdown-toggle" id="dateCompareDropdown1" data-toggle="dropdown" aria-expanded="false">
               <span>Choose...</span>
               <span><i class="fa fa-chevron-down svg1"></i></span>
               </button>
               <div class="dropdown-menu dropdown-menu-right seach-filter-list-div" aria-labelledby="dateCompareDropdown1">
                  <input type="text" class="form-control search-input-mb search-input1" placeholder="search">
                 <a href="#" onclick="set_compare('same period a day before','1','1')" class="drow-item1 cp_dd com1">same period a day before</a>
                 <a href="#" onclick="set_compare('same period a week before','2','7')" class="drow-item1 cp_dd com2">same period a week before</a>
                 <a href="#" onclick="set_compare('same period a month before','3','30')" class="drow-item1 cp_dd com3">same period a month before</a>
                 <a href="#" onclick="set_compare('same period a year before','4','360')" class="drow-item1 cp_dd com4">same period a year before</a>
               </div>
             </div>
             <div class="">
               <button class="btn btn-white option test" type="button">
               <i class="fa fa-trash"></i>
               </button>
             </div>
           </div>
           <input type="hidden" value="" id="compare_val">
           <button type="button" class="btn btn-primary btn-sm my-1" id="compare_btn" onclick="show_compare()">+ Add comparator</button>
         </div>
      </div>
    </div>
  </div>



  <div class="card">
   <div class="card-header" id="headingFive">
       <button class="btn btn-link btn-header-filter collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
         <span>Slice</span>
         <i class="fa fa-chevron-right svg1"></i>
       </button>     
   </div>
   <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#sidePanel1">
     <div class="card-body">
        <div class="dynamic-axis-append y-axis-parent-div">
          <div class="d-flex justify-content-between axis-append-div" id="slice_div">
            <div class="dropdown dropdown-axis">
              <button type="button" class="btn btn-light dropdown-toggle" id="sliceMetric" data-toggle="dropdown" aria-expanded="false">
              <span>Choose...</span>
              <span><i class="fa fa-chevron-down svg1"></i></span>
              </button>
              <div class="dropdown-menu dropdown-menu-right seach-filter-list-div" aria-labelledby="sliceMetric">
                 <input type="text" class="form-control search-input-mb search-input1" placeholder="search">
                <a class="drow-item1">Column name 1</a>
                <a class="drow-item1">Column name 2</a>
                <a class="drow-item1">Column name 3</a>
                <a class="drow-item1">Column name 4</a>
              </div>
            </div>
            <div class="">
              <button class="btn btn-white option test" type="button">
              <i class="fa fa-trash"></i>
              </button>
            </div>
          </div>
          <!-- slice list -->
          <div class="d-block slice-list-div">
            <div>
               <button class="btn btn-white bg-slice" type="button" onclick="openColorModal('slice-color-code')" style="    background: #afa;"></button>
               <p>column item 1</p>
            </div>
            <div>
               <button class="btn btn-white bg-slice" type="button" onclick="openColorModal('slice-color-code')" style="    background: #f50;"></button>
               <p>column item 2</p>
            </div>
          </div>
          <input type="hidden" value="" id="slice_val">
          <!-- only one field -->
          <button type="button" class="btn btn-primary btn-sm my-1" id="slice_btn">+ Add slice</button>
        </div>
     </div>
   </div>
 </div>



  <div class="card">
    <div class="card-header" id="headingSix">
        <button class="btn btn-link btn-header-filter collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
          <span>Sort & Limit</span>
          <i class="fa fa-chevron-right svg1"></i>
        </button>
      
    </div>
    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#sidePanel1">
      <div class="card-body">
         <p class="mini-label">Sort by</p>
         <!-- sort data -->
         <div class="dynamic-axis-append y-axis-parent-div">
           <div class="d-flex justify-content-between axis-append-div hide" id="sort_div">
             <div class="dropdown dropdown-axis">
               <button type="button" class="btn btn-light dropdown-toggle" id="sortMetric" data-toggle="dropdown" aria-expanded="false">
               <span>Default</span>
               <span><i class="fa fa-chevron-down svg1"></i></span>
               </button>
               <div class="dropdown-menu dropdown-menu-right seach-filter-list-div" aria-labelledby="sortMetric">
                  <input type="text" class="form-control search-input-mb search-input1" placeholder="search">
                 <a class="drow-item1 sort" id="sortMetric1" onclick="set_sort_value('1','Default','ASC')">Default</a>
                 <a class="drow-item1 sort" id="sortMetric2" onclick="set_sort_value('2','Ascending order','ASC')">Ascending order</a>
                 <a class="drow-item1 sort" id="sortMetric3" onclick="set_sort_value('3','Descending order','DESC')">Descending order</a>
               </div>
             </div>
             <div class="">
               <button class="btn btn-white option test" type="button">
               <i class="fa fa-trash"></i>
               </button>
             </div>
           </div>
           <input type="hidden" value="" id="sort_val">
           <!-- only one field -->
           <button type="button" class="btn btn-primary btn-sm my-1" onclick="show_sort()" id="sort_btn">+ Add sort</button>
         </div>
         <!-- limit data -->
         <p class="mini-label">Limit entries</p>
         <div class="dynamic-axis-append y-axis-parent-div">
           <div class="d-flex justify-content-between axis-append-div hide" id="limit_div">
             <div class="dropdown dropdown-axis">
               <button type="button" class="btn btn-light dropdown-toggle" id="limitMetric" data-toggle="dropdown" aria-expanded="false">
               <span>Show All</span>
               <span><i class="fa fa-chevron-down svg1"></i></span>
               </button>
               <div class="dropdown-menu dropdown-menu-right seach-filter-list-div" aria-labelledby="limitMetric">
                  <input type="text" class="form-control search-input-mb search-input1" placeholder="search">
                 <a class="drow-item1 limit" id="limitMetric1" onclick="set_limit_value('1','Show All','')">Show All</a>
                 <a class="drow-item1 limit" id="limitMetric2" onclick="set_limit_value('2','Last 10','10')">Last 10</a>
                 <a class="drow-item1 limit" id="limitMetric3" onclick="set_limit_value('3','Last 25','25')">Last 25</a>
                 <a class="drow-item1 limit" id="limitMetric4" onclick="set_limit_value('4','Last 50','50')">Last 50</a>
                 <a class="drow-item1 limit" id="limitMetric5" onclick="set_limit_value('5','Last 100','100')"> Last 100</a>
                 <a class="drow-item1 limit" id="limitMetric6" onclick="set_limit_value('6','Last 500','500')">Last 500</a>
                 <a class="drow-item1 limit" id="limitMetric7" onclick="set_limit_value('7','Last 1000','1000')">Last 1000</a>
               </div>
             </div>
             <div class="">
               <button class="btn btn-white option test" type="button">
               <i class="fa fa-trash"></i>
               </button>
             </div>
           </div>
           <input type="hidden" value="" id="limit_val">
           <!-- only one field -->
           <button type="button" class="btn btn-primary btn-sm my-1" id="limit_btn" onclick="show_limit()">+ Add Limit value</button>
         </div>
      </div>
    </div>
  </div>
</div>

               </li>
            </ul>
            </div>
      </nav>
      <div id="page-wrapper" class="gray-bg">
         <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-3">
               <div class="btn-group top-btn-group" role="group" aria-label="Basic example">
                  <button type="button" class="btn btn-secondary btn-sm">
                  <i class="fa fa-edit"></i>
                  <!-- &nbsp; -->
                  DATASET
                  </button>
                  <button type="button" class="btn btn-primary btn-sm">
                  <i class="fa fa-bar-chart-o"></i>
                  <!-- &nbsp; -->
                  CHART
                  </button>
               </div>
            </div>
            <div class="col-6 title-des-div">
               <input type="text" class="form-control chart-title" id="chart-title" aria-describedby="chart-title" placeholder="Click to add a title">
               <input type="text" class="form-control chart-description" id="chart-description" aria-describedby="chart-description" placeholder="Click to add a description">
            </div>
            <div class="col-3 text-right top-btn-group">
               <button type="button" class="btn btn-secondary mr-1">
               <i class="fa fa-close"></i>
               <!-- &nbsp; -->
               Cancle
               </button>
               <button type="button" class="btn btn-success">
               <i class="fa fa-save"></i>
               <!-- &nbsp; -->
               Save
               </button>
            </div>
            </div>
      <div class="row" id="key_value_show">
       
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
      <div class="row canvas-div">
      <div class="col-12">
      <div class="ibox ">
      <!-- <div class="ibox-title">
         <h5>Bar Chart Example</h5>
         </div> -->
      <div class="ibox-content chart-container chart-d-bg">
            <div class="my-spinner hide" >
               <div class="lds-ring">
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
               </div>
            </div>
      <!-- 
         ** code:srv-100 **
         remove class=> chart-d-bg
         add class=> hide-items1
         to above <DIV>
         -->
      <div id ="container" style = "width: 100%; height: 100vh;"></div>
      <button type="button" onclick="table_highlight()" class="btn btn-primary btn-sm add-d-yaxis trigger_button">+ Add Value</button>
      <span class="d-yaxis-line my-span1"></span>
      <button type="button" class="btn btn-primary btn-sm add-d-xaxis">+ Add Value</button>
      <span class="d-xaxis-line my-span1"></span>
      </div>
      </div>
      </div>
      </div>
      </div>
      <div class="row chart-table">
      <div class="col-12">
      <div class="ibox ">
      <div class="ibox-title">
      <h5>Metric Builder Dataset</h5>
      <div class="ibox-tools">
      <a class="collapse-link">
      <i class="fa fa-chevron-up"></i>
      </a>
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
      <i class="fa fa-wrench"></i>
      </a>
      <ul class="dropdown-menu dropdown-user">
      <li><a href="#" class="dropdown-item">Show only 300 rows</a>
      </li>
      <li><a href="#" class="dropdown-item">SHow all rows</a>
      </li>
      </ul>
      <!-- <a class="close-link">
         <i class="fa fa-times"></i>
         </a> -->
      </div>
      </div>
      <div class="ibox-content my-table2">
      <div class="table-div table-responsive">
      <table class="table table-bordered mb-0 header-table">
      </table>
      <table id="data-table" class="table table-bordered">
      <thead class="top-thead">
      </thead>
      <thead class="top-thead2">
      </thead>
      <thead class="t-title">
      </thead>
      <tbody id="t-body">
      </tbody>
      </table>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>
      <!-- Mainly scripts -->
<script src="{{asset('assets-builder/js/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('assets-builder/js/popper.min.js')}}"></script>
<script src="{{asset('assets-builder/js/bootstrap.js')}}"></script>
<script src="{{asset('assets-builder/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{asset('assets-builder/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- Custom and plugin javascript -->
<script src="{{asset('assets-builder/js/inspinia.js')}}"></script>
<script src="{{asset('assets-builder/js/plugins/pace/pace.min.js')}}"></script>

<!-- ChartJS-->
<script src="{{asset('assets-builder/js/plugins/chartJs/Chart.min.js')}}"></script>
<!-- <script src="{{asset('assets-builder/js/demo/chartjs-demo.js')}}"></script> -->
<script src="{{asset('assets-builder/js/demo/new-page.chart.js')}}"></script>
<!-- <script src="{{asset('assets-builder/js/demo/moment.js')}}"></script> -->
<!-- Modal -->

      <!-- Modal -->
<style>
#changeChart input{
   position: absolute;
   top: -99999px;
   left: -99999px;
   opacity: 0;
}
.modal-body div {
    display: inline-block;
    margin: 4px 10px 4px;
}
</style>
      <div class="modal fade" id="changeChart" tabindex="-1" role="dialog" aria-labelledby="changeChartLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="changeChartLabel">Selct Chart type</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
                 </button>
              </div>
              <div class="modal-body">
                 <div class="">
                    <input class="form-check-input" type="radio" onclick="setchartype('bar','ColumnChart')" name="chartType" id="chartType1" value="option1" checked>
                    <label class="form-check-label btn btn-primary" for="chartType1">COLUMN CHART</label>
                 </div>
                 <div class="">
                    <input class="form-check-input" type="radio" onclick="setchartype('bar','BarChart')" name="chartType" id="chartType2" value="option2">
                    <label class="form-check-label btn btn-primary" for="chartType2">BAR CHART</label>
                 </div>
                 <div class="">
                    <input class="form-check-input" type="radio" onclick="setchartype('line','LineChart')" name="chartType" id="chartType3" value="option3">
                    <label class="form-check-label btn btn-primary" for="chartType3">LINE CHART</label>
                 </div>
                 <div class="">
                    <input class="form-check-input" type="radio" name="chartType" onclick="setchartype('corechart','Donut')" id="chartType4" value="option4">
                    <label class="form-check-label btn btn-primary" for="chartType4">DONUT CHART</label>
                 </div>
                 <div class="">
                    <input class="form-check-input" type="radio" name="chartType" onclick="setchartype('corechart','AreaChart')" id="chartType5" value="option5">
                    <label class="form-check-label btn btn-primary" for="chartType5">AREA CHART</label>
                 </div>
                 <div class="">
                    <input class="form-check-input" type="radio" name="chartType" onclick="setchartype('corechart','PieChart')" id="chartType6" value="option6">
                    <label class="form-check-label btn btn-primary" for="chartType6">PIE CHART</label>
                 </div>
                 <div class="">
                    <input class="form-check-input" type="radio" name="chartType" onclick="setchartype('corechart','Stack')" id="chartType7" value="option7">
                    <label class="form-check-label btn btn-primary" for="chartType7">STACK CHART</label>
                 </div>
                 <div class="">
                    <input class="form-check-input" type="radio" name="chartType" onclick="setBubbleChart('corechart','BubbleChart')" id="chartType8" value="option8">
                    <label class="form-check-label btn btn-primary" for="chartType8">BUBBLE CHART</label>
                 </div>
                 <div class="">
                    <input class="form-check-input" type="radio" name="chartType" onclick="setTableChart('table','Table')" id="chartType9" value="option9">
                    <label class="form-check-label btn btn-primary" for="chartType9">TABLE CHART</label>
                 </div>
                 <div class="">
                    <input class="form-check-input" type="radio" name="chartType" onclick="setGaugeChart('gauge','Gauge')" id="chartType10" value="option10">
                    <label class="form-check-label btn btn-primary" for="chartType10">GAUGE CHART</label>
                 </div>
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
           </div>
        </div>
     </div>
     <script>
        $('#changeChart .modal-body input').click(function(){
          $('#changeChart').modal('hide');
        })
        
        $('#navButtonMenu').click(function() {
          $('.nav-hide-overlay').addClass('show1');
          $('.builder-nav').addClass('show1');
        });
        $('.nav-hide-overlay').click(function() {
          $('.nav-hide-overlay').removeClass('show1');
          $('.builder-nav').removeClass('show1');
        });
        cell = 0; 
        $('.all').addClass('hide');
        $('.column').removeClass('hide');
        //====================================================GAUGE CHART======================================================================//
        google.charts.load('current', {'packages':['gauge']});
        function setGaugeChart(c,v){
            $('.chart-container').removeClass('chart-d-bg');
            $('.chart-container').addClass('hide-items1');  
            $('.all').addClass('hide');
            $('.gauge').removeClass('hide');
            corechart = c;
            visualization = v;
            var data = google.visualization.arrayToDataTable([
               ['Label', 'Value'],
               ['', cell],
               ]);

            var options = {
               width: chartwidth, height: chartheight,
               min: 0,
               max: 1000
            };

            var chart = new google.visualization.Gauge(document.getElementById('container'));

            chart.draw(data, options);
         }

         function show_gauge_value(){
            table_status = '1';
            $('#gauge_value').removeClass('hide');
         }
         //==================================================
         
         
         function setChartbyTable(id){
            val =  $('tbody .hover'+id).html();
            cell = parseInt(val);
            if(table_status == 1){
               colname = $('#colname'+id).val();
               $('.control'+tabIndDY).val(id).prop('selected', true);
               if(visualization == 'Gauge'){
                  setGaugeChart(corechart,visualization);
               }else{
                  drawChart(id,tabIndDY);
               }
               
            }
         }
     </script>
    
<script>
$('body').on('click', '.filter-dropdown-btn', function() {
  $(this).nextAll('.filter-drop-card').show();
});
$('body').on('click', '.filter-submit-btn', function() {
  $(this).parent('.filter-drop-card').hide()
})
</script>
  </body>
</html>


