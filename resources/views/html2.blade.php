<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | ChartJS</title>

    <link href="temp-111/css/bootstrap.min.css" rel="stylesheet">
    <link href="temp-111/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="temp-111/css/animate.css" rel="stylesheet">
    <link href="temp-111/css/style.css" rel="stylesheet">
    <link href="temp-111/css/custom2.css" rel="stylesheet">
    <script type = "text/javascript" src = "temp-111/js/google_chart.js"></script>
  
</head>

<body>
    <div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="chart-div" style="padding: 10px;">
                    <!-- <a> -->
                      <div class="">
                        <div class="form-group">
                          <input type="text" class="form-control" id="chart-title" aria-describedby="chart-title" placeholder="Click to add a title">
                        </div>
                        <div class="form-group">
                          <input type="text" class="form-control" id="chart-description" aria-describedby="chart-description" placeholder="Click to add a description">
                        </div>
                      </div>
                      <div>
                        <div class="form-group">
                          <!-- <label for="chart-type" class="d-flex justify-content-between">
                            <span>Chart type</span>
                            <i class="fa fa-bar-chart-o"></i></label>
                          <select class="form-control" id="chart-type">
                            <option value="1" selected>Bar</option>
                            <option value="2">Pie</option>
                            <option value="3">Line</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                          </select> -->
                          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#changeChart">
                            <span>Select Chart type</span> 
                            &nbsp;&nbsp;
                            <i class="fa fa-bar-chart-o"></i>
                          </button>
                        </div>
                      </div>
                     <div class="pt-0 axis-select">
                        <label for="valuesY">Values (y-axis)</label>
                        <div id="yAxisDiv" class="dynamic-axis-append y-axis-parent-div">
                        	<button type="button" id="addYAxisData" onClick="tableShadow()" class="btn btn-info btn-sm my-1">+ Add value</button>
                        </div>
                      </div>
                      <div class="form-group axis-select">
                        <label for="valuesX">Values (x-axis)</label>
                        <div id="xAxisDiv" class="dynamic-axis-append x-axis-parent-div" style="display: none;">
                        <div class="d-flex justify-content-between">
                          <select class="form-control bb" id="Xvalues" onChange="drawXaxis(this.value)">
                           
                          </select>
                          <span class="aaof">by</span>
                          <select class="form-control aa" >
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
                                    class="text-danger">Separated link dasd</a></li>
                            </ul>
                          </div>
                        </div>
                        </div>
                        <!-- <button type="button" class="btn btn-info mt-1">+ Add value</button> -->
                        <button type="button" id="addXAxisData" class="btn btn-info btn-sm my-1" onclick="xaxis_option()">+ Add value</button>

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
                        <div class="date-range">
                          <div class="form-group">
                            <label for="date-range">Date range (by)</label>
                            <select name="date-range" id="date-range" class="form-control">
                              <option value="1">Last 3 Months</option>
                              <option value="1">Last 6 Months</option>
                              <option value="2">Last 8 Months</option>
                              <option value="3">Month</option>
                              <option value="4">Year</option>
                            </select>
                          </div>
                        </div>
                        <div class="d-block">
                          <button 
                            type="button"
                            class="btn btn-danger d-none"
                            onClick="updateChart()">UPDATE CHART</button>
                        </div>
                    <!-- </a> -->
                </li>
            </ul>

        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row wrapper border-bottom white-bg page-heading">
          <div class="col-6">
            <div class="btn-group" role="group" aria-label="Basic example">
              <button type="button" class="btn btn-secondary">
                <i class="fa fa-edit"></i>
                <!-- &nbsp; -->
                DATASET
              </button>
              <button type="button" class="btn btn-primary">
                <i class="fa fa-bar-chart-o"></i>
                <!-- &nbsp; -->
                CHART
              </button>
            </div>
          </div>
            <div class="col-6 text-right">
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
        <input type="number" class="form-contro" id="chartInput" value="20" style="display: none;">
        <div class="wrapper wrapper-content animated fadeInRight">
          <div class="row canvas-div">
            <div class="col-12">
              <div class="ibox ">
                <!-- <div class="ibox-title">
                  <h5>Bar Chart Example</h5>
                </div> -->
                <div class="ibox-content chart-container">
                  <!-- <div class="default-chart-div" style="position: relative;">
                    <div class="chart-default-bg">
                      <button type="button" class="btn btn-outline-danger" style="background-color: #fff; color: red;">+ Add Value</button>
                    </div>
                  </div> -->
                  <div id ="container" style = "width: 100%; height: 100vh;">
                  </div>
                  <button type="button" class="btn overlay-btn" style="background-color: #fff; color: red;">+ Add Value</button>
                  <!--  <div>
                    <canvas id="barChart" height="140"></canvas>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row chart-table">
          <div class="col-12">
            <div class="ibox ">
              <div class="ibox-title">
                <h5>Border Table </h5>
                <div class="ibox-tools">
                  <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                  </a>
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                      <i class="fa fa-wrench"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-user">
                    <li><a href="#" class="dropdown-item">Config option 1</a>
                    </li>
                    <li><a href="#" class="dropdown-item">Config option 2</a>
                    </li>
                  </ul>
                  <!-- <a class="close-link">
                      <i class="fa fa-times"></i>
                  </a> -->
                </div>
              </div>
              <div class="ibox-content">
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
<script src="temp-111/js/jquery-3.1.1.min.js"></script>
<script src="temp-111/js/popper.min.js"></script>
<script src="temp-111/js/bootstrap.js"></script>
<script src="temp-111/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="temp-111/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="temp-111/js/inspinia.js"></script>
<script src="temp-111/js/plugins/pace/pace.min.js"></script>

<!-- ChartJS-->
<script src="temp-111/js/plugins/chartJs/Chart.min.js"></script>
<!-- <script src="temp-111/js/demo/chartjs-demo.js"></script> -->
<script src="temp-111/js/demo/new-page.chart.js"></script>
<!-- <script src="temp-111/js/demo/moment.js"></script> -->
<!-- Modal -->

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
          <label class="form-check-label" for="chartType1">BAR CHART</label>
        </div>
        <div class="">
          <input class="form-check-input" type="radio" onclick="setchartype('bar','ColumnChart')" name="chartType" id="chartType2" value="option2">
          <label class="form-check-label" for="chartType2">STACKED CHART</label>
        </div>
        <div class="">
          <input class="form-check-input" type="radio" onclick="setchartype('line','LineChart')" name="chartType" id="chartType3" value="option3">
          <label class="form-check-label" for="chartType3">LINE CHART</label>
        </div>
        <div class="">
          <input class="form-check-input" type="radio" name="chartType" onclick="setchartype('line','LineChart')" id="chartType4" value="option4">
          <label class="form-check-label" for="chartType4">LINE CHART</label>
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
// new chart responsive code
var chartwidth = $('.chart-container').width();
var chartheight = $('.chart-container').height();
// new chart responsive code

function setchartype(c,v){
  corechart = c;
  visualization = v;
  var data = google.visualization.arrayToDataTable(yDataArr2);
          // Set chart options
          var options = {
             title : '',
             legend: {position: 'top', maxLines: 6},
             vAxis: {title: ''},
             hAxis: {title: ''},
             colors: color,
             // new chart responsive code
             width: chartwidth - 25,
             height: chartheight - 25,
             chartArea: {
              left:50,
              top:50,
              width:chartwidth,
              height:chartheight
             }
             // new chart responsive code
          };

    var chart = new google.visualization[visualization](document.getElementById('container'));
    chart.draw(data, options);
}
</script>

</body>
</html>
