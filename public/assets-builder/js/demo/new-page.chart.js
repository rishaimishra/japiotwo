color = ['#D90368','#F26419','#F6AE2D','#3F3047','#2E294E','#820263','#5171A5','#FFD400','#EEF36A','#22577A','#38A3A5','#57CC99','#80ED99','#6F1A07','#00171F','#003459','#007EA7','#00A8E8','#44FFD2','#FFBFA0'];

barColor_pos = 1;
tabIndDY = 0;
pos = '';
deletebar = 0;
yDataArr2 = [];
colorpos = '';
table_status = 0;
corechart = 'bar';
visualization = 'ColumnChart';
table_col = '';
current_id = 1;
var tabledata = [];
var col = [];
var options = [];
var chartData = [];
// new chart responsive code
var chartwidth = $('.chart-container').width();
var chartheight = $('.chart-container').height();
// new chart responsive code

//Resize respect to window
$(window).resize(function(){
  var chartwidth = $('.chart-container').width();
  var chartheight = $('.chart-container').height();
  options = {
    title : '',
    legend: {position: 'top', maxLines: 6},
    vAxis: {title: ''},
    hAxis: {title: ''},
    colors: color,
    width: chartwidth - 25,
    height: chartheight - 25,
    chartArea: {
     left:50,
     top:50,
     width:chartwidth,
     height:chartheight - 100
    }
  };
  len = yDataArr2[1].length;
  if(len > 1){
    var data = google.visualization.arrayToDataTable(yDataArr2);
    var chart = new google.visualization[visualization](document.getElementById('container'));
    chart.draw(data, options);
  }
});


// Set chart options
function setOptions(){
  options = {
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
     height:chartheight - 150
    }
    // new chart responsive code
  };
}

// tabledata = [ 
// 	{
// 		"dimension_ga: sessionCount":"1",
// 		"dimension_ga:daysSinceLastSession":"22-10-2020",
// 		"dimension_ga:sessionDurationBucket":"01-02-2020",
// 		"metric_ga:percentNewSessions":"100.0",
// 		"metric_ga:avgSessionDuration":"0.0",
// 		"metric_ga:bounceRate":"100.0",
// 		"metric_ga:goalCompletionsAll":"0",
// 		"metric_ga:goalConversionRateAll":"0.0",
// 		"metric_ga:goalValueAll":"0.0",
// 		"metric_ga:newUsers":"8",
// 		"metric_ga:pageviewsPerSession":"1.0",
// 		"metric_ga:sessions":"6"
// 	},
// 	{
// 		"dimension_ga: sessionCount":"1",
// 		"dimension_ga:daysSinceLastSession":"23-10-2020",
// 		"dimension_ga:sessionDurationBucket":"02-02-2020",
// 		"metric_ga:percentNewSessions":"110.0",
// 		"metric_ga:avgSessionDuration":"1470.0",
// 		"metric_ga:bounceRate":"0.0",
// 		"metric_ga:goalCompletionsAll":"0",
// 		"metric_ga:goalConversionRateAll":"0.0",
// 		"metric_ga:goalValueAll":"0.0",
// 		"metric_ga:newUsers":"10",
// 		"metric_ga:pageviewsPerSession":"2.0",
// 		"metric_ga:sessions":"11"
// 	},
// 	{
// 		"dimension_ga: sessionCount":"1",
// 		"dimension_ga:daysSinceLastSession":"24-10-2020",
// 		"dimension_ga:sessionDurationBucket":"03-02-2020",
// 		"metric_ga:percentNewSessions":"120.0",
// 		"metric_ga:avgSessionDuration":"493.0",
// 		"metric_ga:bounceRate":"0.0",
// 		"metric_ga:goalCompletionsAll":"0",
// 		"metric_ga:goalConversionRateAll":"0.0",
// 		"metric_ga:goalValueAll":"0.0",
// 		"metric_ga:newUsers":"12",
// 		"metric_ga:pageviewsPerSession":"12.0",
// 		"metric_ga:sessions":"16"
// 	},
// 	{
// 		"dimension_ga: sessionCount":"1",
// 		"dimension_ga:daysSinceLastSession":"25-10-2020",
// 		"dimension_ga:sessionDurationBucket":"04-02-2020",
// 		"metric_ga:percentNewSessions":"130.0",
// 		"metric_ga:avgSessionDuration":"493.0",
// 		"metric_ga:bounceRate":"0.0",
// 		"metric_ga:goalCompletionsAll":"0",
// 		"metric_ga:goalConversionRateAll":"0.0",
// 		"metric_ga:goalValueAll":"0.0",
// 		"metric_ga:newUsers":"14",
// 		"metric_ga:pageviewsPerSession":"12.0",
// 		"metric_ga:sessions":"21"
// 	},
// 	{
// 		"dimension_ga: sessionCount":"1",
// 		"dimension_ga:daysSinceLastSession":"26-10-2020",
// 		"dimension_ga:sessionDurationBucket":"05-02-202093",
// 		"metric_ga:percentNewSessions":"140.0",
// 		"metric_ga:avgSessionDuration":"493.0",
// 		"metric_ga:bounceRate":"0.0",
// 		"metric_ga:goalCompletionsAll":"0",
// 		"metric_ga:goalConversionRateAll":"0.0",
// 		"metric_ga:goalValueAll":"0.0",
// 		"metric_ga:newUsers":"16",
// 		"metric_ga:pageviewsPerSession":"12.0",
// 		"metric_ga:sessions":"26"
// 	}
// ]
tabledata = [];
//Load Api data table data
$(function(){
  setOptions();
  $.ajax({
    beforeSend: function() {
      $("#preloader").fadeIn();
    },
    url: '../all-data',
    method: 'get',
    dataType: 'json',
    processData: false,
    data: $.param({"dataset_id": "50"}),
    success: function(res) {
      tabledata = res;
      for (var i = 0; i < tabledata.length; i++) {
          for (var key in tabledata[i]) {
              if (col.indexOf(key) === -1) {
                  col.push(key);
              }
          }
      }
      var top_thead = '<tr class="thead1 thead-a-1">';
      var thead = '<tr>';
      for (var i = 0,j = 65; i < col.length; i++,j++) {
        var v = i;
        h_id = col[i].replace(/ /g,"_");
        thead += '<th class="hover'+(v+1)+' h'+(v+1)+'" id="colname'+(v+1)+'" onclick="setChartbyTable('+"'"+(v+1)+"'"+')" onmouseleave="heighlight_remove('+"'"+(v+1)+"'"+')" onmouseover="heighlight('+"'"+(v+1)+"'"+')">'+col[i]+'</th><input type="hidden" id="'+h_id+'">';
        top_thead += '<th class="p-0 hover'+(v+1)+' h'+(v+1)+'" onclick="setChartbyTable('+"'"+(v+1)+"'"+')" onmouseleave="heighlight_remove('+"'"+(v+1)+"'"+')" onmouseover="heighlight('+"'"+(v+1)+"'"+')"><button type="button" onclick="setChartbyTable('+"'"+(v+1)+"'"+')" class="btn p-0 m-0 border-0 w-100 btn-tab-11">'+ String.fromCharCode(j)+'</button></th>';
      }
      thead += '</tr>';
      top_thead += '</tr>';
      $('.top-thead').html(top_thead);
      $('.top-thead2').html(top_thead);
      $('.t-title').html(thead);
      // ADD JSON DATA TO THE TABLE AS ROWS.
      var tbody = '';
      yDataArr2.push([""]);
      d1 = [];
      z = 0;
      for (var i = 0,c = 1; i < tabledata.length; i++,c++) {
      if(i < 300){
        tbody += '<tr>';
        for (var j = 0; j < col.length; j++) {
            h_id = col[j].replace(/ /g,"_");
            type = typeof tabledata[i][col[j]];
            $('#'+h_id).val(type);
            x = j;
            z++;
            // var cc = tabledata[i][col[j]];
            // var dateformat = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
            // if(cc.match(dateformat)){
            //   console.log('1');
            // }
            tbody += '<td class="hover'+(z)+' h'+(x+1)+'" onclick="setChartbyTable('+"'"+(x+1)+"'"+')" onmouseleave="heighlight_remove('+"'"+(x+1)+"'"+","+"'"+z+"'"+')" onmouseover="heighlight('+"'"+(x+1)+"'"+","+"'"+z+"'"+')">'+tabledata[i][col[j]]+'</td>';
        }
        tbody += '</tr>';
      }
      //set chart initials value
        if(d1.length != 0){
          $r = d1[0];
          yDataArr2.push([tabledata[i][col[$r]].toString()]);
        }else{
          yDataArr2.push([c.toString()]);
        }
      }
      $('#x_axis').val('Close Date');
      $('#x_axis_sort').val('day');
      $('#t-body').html(tbody);
    },
    error: function(xhr) {},
    complete: function() {
    $("#preloader").fadeOut();
    }
  })
})
function table_highlight(){
  table_status = 1;
  tableShadow();
  setTimeout(
    openFirstDropdown, 
  1);
}
// make this dynamic for every first chart type
function openFirstDropdown() {
  $(".yaxis_dd > .dropdown-toggle").dropdown('show');
  $(".yaxis_dd > .dropdown-menu").addClass('first-dropdown-open');
}
// put on every function that builds the first chart
function hideFirstDropdown() {
  $(".yaxis_dd > .dropdown-toggle").dropdown('hide');
  $(".yaxis_dd > .dropdown-menu").removeClass('first-dropdown-open');
}
// search filter list
function filterSearchList(filterItem, searchInput) {
  // Declare variables
  var input, filter, searchDivSel, a, searchDiv;
  input = searchInput.value;
  filter = input.toUpperCase();
  searchDivSel = '#filterList' + filterItem;
  searchDiv = $(searchDivSel);
  a = searchDiv.find('a');

  // Loop through all list items, and hide those who don't match the search query
  for (let i = 0; i < a.length; i++) {
    if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
$('.dropdown-menu a').on('click', function() {
  $('.dropdown-menu a').show();
  $('.dropdown-menu input').val('');
})
$(document).on('click' , function() {
  $('.dropdown-menu a').show();
  $('.dropdown-menu input').val('');
})
// filter list
// search filter list end
function drawChart(colid,id) {
  table_col = colid;
  current_id = id;
  $('.chart-container').removeClass('chart-d-bg');
  $('.chart-container').addClass('hide-items1');       
  abbrs = document.getElementsByClassName("test"),
  len = abbrs.length;
  for (var i= 0; i < len; i++){
      addEvent(abbrs[i],i);
  }

  table_status = 0;
  $('.table-div').removeClass('table-div-shadow');
  var colval = $(".control"+id+"").val();
  if(colval != ''){
     var colname = $(".control"+id+" option:selected").text();
     if(colname == ''){
      var colname = $("#colname"+colid).html();
     }
  }else{
    var colname = $("#colname"+colid).html();
  }
  $('#y_col'+id).val(colname);
  h_id = colname.replace(/ /g,"_");
  type = $('#'+h_id).val();
  $('f1').removeClass('disabled');
  if(type == 'string'){
    operation = 'count';
    $('.op_type'+id).addClass('disabled');
  }else{
    $('.op_type'+id).removeClass('disabled');
    operation = $('#y_op'+id+' span:first-child').html();
  }
  $('#y_op'+id+' span:first-child').html(operation);
  var x_axis = $('#x_axis').val();
  yDataArr2 = [];
  arr = [];
  arr.push("");
  arr.push(colname);
  yDataArr2.push(arr);
  $.ajax({
    beforeSend: function() {
      $(".my-spinner").removeClass('hide');
    },
    url: '../cordinate-filter',
    method: 'get',
    dataType: 'json',
    processData: false,
    data: $.param({"cname":x_axis,"column":colname,"dataset_id":"50","operation":operation}),
    success: function(res) {
      if(res != ''){
        $.each(res,function(idx,data){
          arr = [];
          arr.push(data.c_date);
          arr.push(parseInt(data.id));
          yDataArr2.push(arr);
        })
        
      }
    },
    error: function(xhr) {},
    complete: function() {
      $(".my-spinner").addClass('hide');
      var data = google.visualization.arrayToDataTable(yDataArr2);
      var chart = new google.visualization[visualization](document.getElementById('container'));
      chart.draw(data, options);
    }
  })
  $('#y_axis'+id).val(colname);
  var y_axis_arr = $("input[name='y_axis[]']")
  .map(function(){return $(this).val();}).get();
  var y_axis_operator_arr = $("input[name='y_axis_operator[]']")
  .map(function(){return $(this).val();}).get();
  YAxisData = [];
 
  XAxisData = [];
  for(v = 0; v < y_axis_arr.length;v++){
    a = [];
    a = {"operator":y_axis_operator_arr[v],"columnName":y_axis_arr[v]};
    var y_col ='YAxisData'+(v+1);
    YAxisData[y_col] = a;
    // YAxisData['YAxisData'+(v+1)+''] = a;
  }
  columnName = $('#x_axis').val();
  sort = $('#x_axis_sort').val();
  XAxisData = {"columnName":columnName,"sortBy":sort};
  // XAxisData['sortBy'] = sort;
  // chartData['YAxisData'] = YAxisData;
  chartData['XAxisData'] = XAxisData; 
  chartData['YAxisData'] = YAxisData;
  if(colname != ''){
    if(colname.length > 10){
      shortcolname = colname.substr(0,10)+'...';
    }else{
      shortcolname = colname;
    }
    $('#corechart-y'+id+' span:first-child').html(shortcolname);
  }
  
  // select value
  var index = colid;
  // select label
  var tableTitle = parseInt(index);
  selectedYAxis = index;
  selectedYAxis = parseInt(selectedYAxis)-1;

  //Set the title of the graph
  // yDataArr2[0][id] = colname;
  // for (var i = 0,c = 1; i < tabledata.length; i++,c++) {
  //     yDataArr2[c][id] = parseInt(tabledata[i][colname]);
  // }
  // var data = google.visualization.arrayToDataTable(yDataArr2);
  // var chart = new google.visualization[visualization](document.getElementById('container'));
  // chart.draw(data, options);
  xaxis_option();
  set_xaxis_option('Close Date','4');
  console.log(chartData);
}

function y_opertion(id,operation){
  yDataArr2 = [];
  var x_axis = $('#x_axis').val();
  var col = $('#y_col'+id).val();
  arr = [];
  arr.push("");
  arr.push(col);
  yDataArr2.push(arr);
  h_id = col.replace(/ /g,"_");
  type = $('#'+h_id).val();
  $('f1').removeClass('disabled');
  if(type == 'string'){
    $('.op_type'+id).addClass('disabled');
  }else{
    $('.op_type'+id).removeClass('disabled');
  }
  $('#y_op'+id+' span:first-child').html(operation);
  $.ajax({
    beforeSend: function() {
      $(".my-spinner").removeClass('hide');
    },
    url: '../cordinate-filter',
    method: 'get',
    dataType: 'json',
    processData: false,
    data: $.param({"cname":x_axis,"column":col,"dataset_id":"50","operation":operation}),
    success: function(res) {
      if(res != ''){
        $.each(res,function(idx,data){
          arr = [];
          arr.push(data.c_date);
          arr.push(parseInt(data.id));
          yDataArr2.push(arr);
         
        })
        console.log(yDataArr2);
        var data = google.visualization.arrayToDataTable(yDataArr2);
        var chart = new google.visualization[visualization](document.getElementById('container'));
        chart.draw(data, options);
      }
    },
    error: function(xhr) {},
    complete: function() {
      $(".my-spinner").addClass('hide');
    }
  })
}

// function removeChart(removeIndex) {
    
//     var kij = $(removeIndex).attr('removeChartIndex');
//     var kil = parseInt(kij);
//     chart.data.datasets.splice(kil,1);
//     chart.update();
// };
// end chart

function openColorModal(num) {
var i = 0,
abbrs = document.getElementsByClassName("test"),
len = abbrs.length;
for (i; i < len; i++){
    addEvent(abbrs[i],i);
}
barColor_pos = num;
$('#colorModal').removeClass('modalHide');
$('#colorModal').attr('numChart', num);
}
function addEvent(abbr,i) {
  abbr.addEventListener("click", function(event) {
      colorpos = i;
  })

}

function hideModal() {
$('#colorModal').addClass('modalHide');
// $('#colorModal').removeAttr('numChart');
};

function setChartColor(target1) {
  var chartDataIndex = $('#colorModal').attr('numChart');
  var chartColorNew = target1.value;
  var data = google.visualization.arrayToDataTable(yDataArr2);
  color[colorpos] = chartColorNew;
  // Instantiate and draw the chart.
  var chart = new google.visualization[visualization](document.getElementById('container'));
  chart.draw(data, options);
};
//  end bar chart

$('.top-thead').hide();
$('.top-thead button').click(function() {
$('.top-thead2').show();
$('.top-thead').hide(); 
});


function heighlight(id,clsid = 0){
  if(table_status == 1){
    if(visualization == 'BubbleChart' || visualization == 'Gauge'){
      $('.hover'+clsid).addClass('bg-primary');
    }else{
      $('.h'+id).addClass('outline-sel');
      // $('.table-div td:nth-child('+id+')').addClass('outline-sel');    
    } 
  }
}
function heighlight_remove(id,clsid = 0){
  $('.hover'+clsid).removeClass('bg-primary');
  $('.h'+id).removeClass('outline-sel');
  // $('.table-div td:nth-child('+id+')').removeClass('outline-sel');  
}

function setChart(id){
drawChart(id,tabIndDY)
}

function setChartbyTable(id){
  if(table_status == 1){
    colname = $('#colname'+id).val();
    $('.control'+tabIndDY).val(id).prop('selected', true);;
    drawChart(id,tabIndDY)
  }
}

//Values (y-axis)
function tableShadow(){
  google.charts.load('current', {'packages':['corechart']});
  table_status = 1;
  tabIndDY++;
  option = '';
  for (var i = 0; i < col.length; i++) {
      var s = i;
      
      option += '<a href="#" onclick="drawChart('+"'"+(s+1)+"'"+','+"'"+tabIndDY+"'"+')" class="drow-item1 control'+tabIndDY+'"">'+col[i]+'</a>';
  }
  // $('#Xvalues').html(option);
  var str = '<div class="d-flex justify-content-between axis-append-div" id="xAxisAppendDiv'+tabIndDY+'"><input type="hidden" id="y_axis'+tabIndDY+'" name="y_axis[]"><input type="hidden" id="y_axis_operator'+tabIndDY+'" value="sum" name="y_axis_operator[]"><input type="text" id="xAxisInputHidden1" class="axis-append-input" placeholder="yAx1"><div class="dropdown dropdown-axis f1_d"><button type="button" class="btn btn-light dropdown-toggle" id="y_op'+tabIndDY+'" data-toggle="dropdown"><span>Sum</span><span><i class="fa fa-chevron-down svg1"></i></span></button><div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink2"><a href="#" class="drow-item1  f1  sum op_type'+tabIndDY+'" onclick="y_opertion('+"'"+tabIndDY+"'"+","+"'"+'sum'+"'"+')" >Sum</a><a href="#" class="drow-item1 f1 count "  onclick="y_opertion('+"'"+tabIndDY+"'"+","+"'"+'count'+"'"+')" >Count</a><a href="#" class="drow-item1 f1 op_type'+tabIndDY+'" onclick="y_opertion('+"'"+tabIndDY+"'"+","+"'"+'average'+"'"+')" >Average</a><a href="#" class="drow-item1 f1 op_type'+tabIndDY+'" onclick="y_opertion('+"'"+tabIndDY+"'"+","+"'"+'max'+"'"+')" >Max</a><a href="#" class="drow-item1 f1 op_type'+tabIndDY+'" onclick="y_opertion('+"'"+tabIndDY+"'"+","+"'"+'min'+"'"+')" >Min</a><a href="#" class="drow-item1 f1 op_type'+tabIndDY+'" onclick="y_opertion('+"'"+tabIndDY+"'"+","+"'"+'median'+"'"+')" >Median</a></div></div><span class="aaof">of</span><div class="dropdown dropdown-axis yaxis_dd"><button type="button" class="btn btn-light dropdown-toggle corechart-y" id="corechart-y'+tabIndDY+'" data-toggle="dropdown" aria-expanded="false"><span >Choose...</span><span><input type="hidden" id="y_col'+tabIndDY+'"><i class="fa fa-chevron-down svg1"></i></span></button><div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink1"><input type="text" class="form-control"placeholder="search"><div class="dropdown-divider"></div>'+option+'</div></div><div class=""><button class="btn btn-white option test" type="button"onClick="openColorModal('+"'"+tabIndDY+"'"+')"><i class="fa fa-eyedropper"></i></button></div></div>';
  $('#yAxisDiv').append(str);
  $('.table-div').addClass('table-div-shadow');
  $('.top-thead2').hide();
  $('.top-thead').show();
  var i = 0,
  abbrs = document.getElementsByClassName("test"),
  len = abbrs.length;
  for (i; i < len; i++){
      addEvent(abbrs[i],i);
  }
}

//x-axis
function xaxis_option(){
  table_status = 1;
  option = '';
  for (var i = 0; i < col.length; i++) {
      var s = i;
      option += '<a href="#" onclick="set_xaxis_option('+"'"+col[i]+"'"+","+"'"+(s+1)+"'"+')" id="x_dd'+(s+1)+'" class="x-drop">'+col[i]+'</a>';
  }
  $('#xAxisDiv').show();
  $('#addXAxisData').hide();
  $('#Xvalues').html(option);
  $('.table-div').addClass('table-div-shadow');
  $('.top-thead2').hide();
  $('.top-thead').show();
}

function set_xaxis_option(name,id){
  // drawXaxis(this.value);
  h_id = name.replace(/ /g,"_");
  type = $('#'+h_id).val();
  if(name.length > 15){
    name = name.substr(0,15)+'...';
  }
  if(type == 'string'){
    $('.x-filter').addClass('hide');
    $('.x-by').addClass('hide');
  }else{
    $('.x-filter').removeClass('hide');
    $('.x-by').removeClass('hide');
  }
  $('.x-drop').removeClass('selected');
  $('#x_dd'+id).addClass('selected');
  $('#xaxis_dd span:first-child').html(name);
  //Set the title of the graph
  // for (var i = 0,c = 1; i < tabledata.length; i++,c++) {
  //   yDataArr2[c][0] = tabledata[i][name];
  // }
  // var data = google.visualization.arrayToDataTable(yDataArr2);
  // var chart = new google.visualization[visualization](document.getElementById('container'));
  // chart.draw(data, options);
}

function removeChart(){
  
  idx = colorpos;
  // if(pos != '' && pos < idx){
  //   idx = idx - deletebar;
  // }
  temparr = [];
  length =  parseInt(yDataArr2.length);
  for(var i = 0; i < length; i++){
    arr = [];
    sublength = yDataArr2[i].length;
    for(var j = 0; j < sublength; j++){
      if(j != idx ){
        arr.push(yDataArr2[i][j]);
      }
    }
    temparr.push(arr);
  }
  color.splice(idx, 1);
 
  yDataArr2 = [];
  yDataArr2 = temparr;
  tabIndDY--;
    var data = google.visualization.arrayToDataTable(yDataArr2);
    var chart = new google.visualization[visualization](document.getElementById('container'));
    chart.draw(data, options);
  
  $('#xAxisAppendDiv'+barColor_pos).remove();
  $('#colorModal').addClass('modalHide');
  pos = idx;
  deletebar++;

}
function drawXaxis(colid) {
  
  table_status = 0;
  $('.table-div').removeClass('table-div-shadow');
  var colval = $("#Xvalues").val();
  if(colval != ''){
     var colname = $("#Xvalues option:selected").text();
  }
  //Set the title of the graph
  for (var i = 0,c = 1; i < tabledata.length; i++,c++) {
      yDataArr2[c][0] = tabledata[i][colname];
  }
  var data = google.visualization.arrayToDataTable(yDataArr2);
  var chart = new google.visualization[visualization](document.getElementById('container'));
  chart.draw(data, options);
}

function setchartype(c,v){
  setOptions();
  corechart = c;
  visualization = v;
  if(c == 'bar' || c == 'line' || c == 'corechart' ){
    options = {
      title : '',
      legend: {position: 'top', maxLines: 6},
      vAxis: {title: ''},
      hAxis: {title: ''},
      colors: color,
      width: chartwidth - 25,
      height: chartheight - 25,
      chartArea: {
       left:50,
       top:50,
       width:chartwidth-100,
       height:chartheight - 150
      }
    };
    $('.all').addClass('hide');
    $('.column').removeClass('hide');
  }
  if(v == 'Donut'){
    visualization = 'PieChart';
    var options = {
      pieHole: 0.4
    };
  }
  if(v == 'Stack'){
      options = {
      title : '',
      legend: {position: 'top', maxLines: 6},
      vAxis: {title: ''},
      hAxis: {title: ''},
      colors: color,
      isStacked: true,
      // new chart responsive code
      width: chartwidth - 25,
      height: chartheight - 25,
      chartArea: {
      left:50,
      top:50,
      width:chartwidth,
      height:chartheight - 100
      }
      // new chart responsive code
    };
    visualization = 'ColumnChart';
  }

  len = yDataArr2[1].length;
  if(len > 1){
    var data = google.visualization.arrayToDataTable(yDataArr2);
    var chart = new google.visualization[visualization](document.getElementById('container'));
    chart.draw(data, options);
  }
}

function setBubbleChart(c,v){
  corechart = c;
  visualization = v;
  $('.all').addClass('hide');
  $('.bubble').removeClass('hide');
  // $('.chart-div').html('<div class=""><div class="form-group"><input type="text" class="form-control chart-title" id="chart-title" aria-describedby="chart-title" placeholder="Click to add a title"></div><div class="form-group"><input type="text" class="form-control chart-description" id="chart-description" aria-describedby="chart-description" placeholder="Click to add a description"></div></div><div><div class="form-group"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changeChart"><span>Select Chart type</span>&nbsp;&nbsp;<i class="fa fa-bar-chart-o"></i></button></div></div>');
      options = {
      title : '',
      legend: {position: 'top', maxLines: 6},
      vAxis: {title: ''},
      hAxis: {title: ''},
      colors: color,
      isStacked: true,
      // new chart responsive code
      width: chartwidth - 25,
      height: chartheight - 25,
      chartArea: {
      left:50,
      top:50,
      width:chartwidth,
      height:chartheight - 100
      }
      // new chart responsive code
    };

  len = yDataArr2[1].length;
  if(len > 1){
    var data = google.visualization.arrayToDataTable(yDataArr2);
    var chart = new google.visualization[visualization](document.getElementById('container'));
    chart.draw(data, options);
  }
}

function y_count(){
  data = [];
  $('.f1').removeClass('selected');
  $('.count').addClass('selected');
  colname =  $("#colname"+table_col+"").html();
  $('#dropdownMenuLink2 span:first-child').html('Count');

  for (var i = 0,c = 1; i < tabledata.length; i++,c++) {
    data.push(parseInt(tabledata[i][colname]));
  }
  var count = {};
  data.forEach(function(i) { count[i] = (count[i]||0) + 1;});
  for (var i = 0,c = 1; i < data.length; i++,c++) {
    yDataArr2[c][1] = parseInt('1');
  }
var data = google.visualization.arrayToDataTable(yDataArr2);
var chart = new google.visualization[visualization](document.getElementById('container'));
chart.draw(data, options);
}

  //=====================================================================================================================================//
 //====================================================TABLE CHART======================================================================//
//=====================================================================================================================================//
function setTableChart(c,v){
  corechart = c;
  visualization = v;
  google.charts.load('current', {'packages':['table']});
  $('.all').addClass('hide');
  $('.table').removeClass('hide');
  len = yDataArr2[1].length;
  if(len > 1){
    var data = google.visualization.arrayToDataTable(yDataArr2);
    var chart = new google.visualization[visualization](document.getElementById('container'));
    chart.draw(data, options);
  }
}

//=======================================================================================================
//=======================table data==================================================================
function tbldata_filter(limit = ''){
  $.ajax({
    beforeSend: function() {
      $("#preloader").fadeIn();
    },
    url: '../all-data',
    method: 'get',
    dataType: 'json',
    processData: false,
    data: $.param({"dataset_id": "50"}),
    success: function(res) {
      tabledata = res;
      for (var i = 0; i < tabledata.length; i++) {
          for (var key in tabledata[i]) {
              if (col.indexOf(key) === -1) {
                  col.push(key);
              }
          }
      }
      var top_thead = '<tr class="thead1 thead-a-1">';
      var thead = '<tr>';
      for (var i = 0,j = 65; i < col.length; i++,j++) {
        var v = i;
        thead += '<th class="hover'+(v+1)+'" id="colname'+(v+1)+'" onclick="setChartbyTable('+"'"+(v+1)+"'"+')" onmouseleave="heighlight_remove('+"'"+(v+1)+"'"+')" onmouseover="heighlight('+"'"+(v+1)+"'"+')">'+col[i]+'</th>';
        top_thead += '<th class="p-0 hover'+(v+1)+'" onclick="setChartbyTable('+"'"+(v+1)+"'"+')" onmouseleave="heighlight_remove('+"'"+(v+1)+"'"+')" onmouseover="heighlight('+"'"+(v+1)+"'"+')"><button type="button" onclick="setChartbyTable('+"'"+(v+1)+"'"+')" class="btn p-0 m-0 border-0 w-100 btn-tab-11">'+ String.fromCharCode(j)+'</button></th>';
      }
      thead += '</tr>';
      top_thead += '</tr>';
      $('.top-thead').html(top_thead);
      $('.top-thead2').html(top_thead);
      $('.t-title').html(thead);
      // ADD JSON DATA TO THE TABLE AS ROWS.
      var tbody = '';
      z = 0;
      if(limit == ''){
        limit =  tabledata.length;
      }
      for (var i = 0,c = 1; i < tabledata.length; i++,c++) {
        if(i < limit){
          tbody += '<tr>';
          for (var j = 0; j < col.length; j++) {
              x = j;
              z++;
              tbody += '<td class="hover'+(z)+'" onclick="setChartbyTable('+"'"+(x+1)+"'"+')" onmouseleave="heighlight_remove('+"'"+(x+1)+"'"+","+"'"+z+"'"+')" onmouseover="heighlight('+"'"+(x+1)+"'"+","+"'"+z+"'"+')">'+tabledata[i][col[j]]+'</td>';
          }
          tbody += '</tr>';
        } 
      }
      $('#t-body').html(tbody);
    },
    error: function(xhr) {},
    complete: function() {
    $("#preloader").fadeOut();
    }
  }) 
}
//=======================================================================================================
//=================================keyvalue dropdown====================================================
key_dd_id = 0;
function keyvalue_dropdown(){
  table_status = 1;
  option = '';
  key_dd_id++;
  for (var i = 0; i < col.length; i++) {
      var s = i + 1+'-'+key_dd_id;
      option += '<a href="#" id="key_sub'+s+'" onclick="set_keyvalue('+"'"+col[i]+"'"+","+"'"+key_dd_id+"'"+","+"'"+s+"'"+')" class="sub-key'+key_dd_id+'">'+col[i]+'</a>';
  }
  var str = '<div id="key_main'+key_dd_id+'" class="d-flex justify-content-between axis-append-div"><input type="text" id="xAxisInputHidden1" class="axis-append-input" placeholder="yAx1"><div class="dropdown dropdown-axis f1_d"><button type="button" class="btn btn-light dropdown-toggle" id="key_operator'+key_dd_id+'" data-toggle="dropdown"><span>Sum</span><span><i class="fa fa-chevron-down svg1"></i></span></button><div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink2"><a href="#" class="drow-item1  f1 sum key_op'+key_dd_id+'" onclick="key_sum('+"'"+key_dd_id+"'"+","+"'"+'sum'+"'"+')" id="key_sum'+key_dd_id+'">Sum</a><a href="#" class="drow-item1 f1 count " id="key_count'+key_dd_id+'"  onclick="key_sum('+"'"+key_dd_id+"'"+","+"'"+'count'+"'"+')">Count</a><a href="#" class="drow-item1 key_op'+key_dd_id+'" onclick="key_sum('+"'"+key_dd_id+"'"+","+"'"+'average'+"'"+')" id="key_avg'+key_dd_id+'">Average</a><a href="#" class="drow-item1 key_op'+key_dd_id+'" onclick="key_sum('+"'"+key_dd_id+"'"+","+"'"+'max'+"'"+')" id="key_max'+key_dd_id+'">Max</a><a href="#" class="drow-item1 key_op'+key_dd_id+'"  onclick="key_sum('+"'"+key_dd_id+"'"+","+"'"+'min'+"'"+')">Min</a><a href="#" class="drow-item1 key_op'+key_dd_id+'" id="key_med'+key_dd_id+'">Median</a></div></div><span class="aaof">of</span><div class="dropdown dropdown-axis yaxis_dd"><button type="button" id="key'+key_dd_id+'" class="btn btn-light dropdown-toggle"  data-toggle="dropdown" aria-expanded="false"><span>Choose...</span><span><i class="fa fa-chevron-down svg1"></i></span><input type="hidden" id="key_hidden'+key_dd_id+'"></button><div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink1"><input type="text" class="form-control"placeholder="search"><div class="dropdown-divider"></div>'+option+'</div></div><div class=""><button class="btn btn-white option test" type="button" onclick="remove_key('+"'"+key_dd_id+"'"+')"><i class="fa fa-trash"></i></button></div></div>';
  $('#key-dd').append(str);
  $('.table-div').addClass('table-div-shadow');
  $('.top-thead2').hide();
  $('.top-thead').show();
}
function set_keyvalue(name,p_id,id){
  $('#key_hidden'+p_id).val(name);
  if(name.length > 10){
    name = name.substr(0,10)+'...';
  }
  op = $('#key_operator'+p_id+' span:first-child').html();
  if(op != ''){
    key_sum(p_id,op);
  }else{
    key_sum(p_id,'sum');
  }
  $('#key'+p_id+' span:first-child').html(name);
  $('.sub-key'+p_id).removeClass('selected');
  $('#key_sub'+id).addClass('selected');
}
$('.disabled').click(function(e){
  e.preventDefault();
})
function key_sum(id,operator){
  $('#key_operator'+id+' span:first-child').html(operator);
  str = '';
  name = $('#key_hidden'+id).val();
  h_id = name.replace(/ /g,"_");
  type = $('#'+h_id).val();
  $('.key_op'+id).removeClass('disabled');
  if(type == 'string'){
    $('#key_operator'+id+' span:first-child').html('count');
    $('.key_op'+id).addClass('disabled');
    operator = 'count';
  }
  $.ajax({
    beforeSend: function() {
      $("#preloader").fadeIn();
    },
    url: '../arithmetic',
    method: 'get',
    dataType: 'json',
    processData: false,
    data: $.param({"operation": operator,"dataset_id": "50","cname": name}),
    success: function(res) {
      str = '<div class="col-md-3" id="key_show_col'+id+'"><input type="hidden" id="key_show'+id+'" value="1"><h3>'+res.toFixed(2)+'</h3><span class="text-capitalize">'+operator+' of '+name+'</span></div>';
      var z = $('#key_show'+id).val();
      if( z != '1'){
        $('#key_value_show').append(str);
      }else{
        $('#key_show_col'+id).html('<input type="hidden" id="key_show'+id+'" value="1"><h3>'+res.toFixed(2)+'</h3><span class="text-capitalize">'+operator+' of '+name+'</span>');
      }
      $('#key_value_show').show();
    },
    error: function(xhr) {},
    complete: function() {
    $("#preloader").fadeOut();
    }
})
}

function remove_key(id){
  $('#key_main'+id).remove();
  $('#key_show_col'+id).remove();
}

//=================================filter dropdown====================================================
filter_dd_id = 0;
function filtervalue_dropdown(){
  table_status = 1;
  option = '';
  filter_dd_id++;
  for (var i = 0; i < col.length; i++) {
      var s = i + 1+'-'+filter_dd_id;
      option += '<a href="#" id="key_sub'+s+'" onclick="set_keyvalue('+"'"+col[i]+"'"+","+"'"+filter_dd_id+"'"+","+"'"+s+"'"+')" class="sub-key'+filter_dd_id+'">'+col[i]+'</a>';
  }
  var str = '<div class="d-flex justify-content-between axis-append-div filter-dropdown-div"><button class="btn btn-light filter-dropdown-btn"><span>Id is less than 5</span><span><i class="fa fa-chevron-down svg1"></i></span></button><div class="filter-drop-card dropdown-menu"><div class="dropdown"><button type="button" class="btn btn-light dropdown-toggle filter-d-c-btn" id="filterDropdownMain1" data-toggle="dropdown" aria-expanded="false"><span>Choose...</span><span><i class="fa fa-chevron-down svg1"></i></span></button><div id="filterList12035" class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdownMain1"><div class="form-group"><input type="text" onkeyup="filterSearchList(12035, this)" class="form-control search-input-mb" placeholder="search"></div>'+option+'</div></div><div class="dropdown"> <button type="button" class="btn btn-light dropdown-toggle filter-d-c-btn" id="filterDropdownMain2" data-toggle="dropdown" aria-expanded="false"><span>operator</span><span><i class="fa fa-chevron-down svg1"></i></span></button><div id="filterList656451" class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdownMain2"><div class="form-group"><input type="text" onkeyup="filterSearchList(656451, this)" class="form-control search-input-mb" placeholder="search"></div><a href="#" class="drow-item1 op-all op-str">Equals</a><a href="#" class="drow-item1 op-all op-str">Does not equal</a><a href="#" class="drow-item1 op-all op-str">Contains</a><a href="#" class="drow-item1 op-all op-str">Does not contain</a><a href="#" class="drow-item1 op-all">Less than</a><a href="#" class="drow-item1 op-all">Less than or equal to</a><a href="#" class="drow-item1 op-all">Greater than</a><a href="#" class="drow-item1 op-all">Greater than or equal to</a><a href="#" class="drow-item1 op-all op-str">Is blank</a><a href="#" class="drow-item1 op-all op-str">Is not blank</a><a href="#" class="drow-item1 op-all op-str">Is one of</a><a href="#" class="drow-item1 op-all op-str">Is not one of</a></div></div><div class="form-group"><input type="text" class="form-control filter-d-c-btn" placeholder="enter your value"></div><button type="button" class="btn btn-sm btn-success filter-submit-btn">filter now</button></div><div class=""> <button class="btn btn-white option test" type="button"><i class="fa fa-trash"></i></button></div></div>';
  $('#filter-dd').append(str);
  $('.table-div').addClass('table-div-shadow');
  $('.top-thead2').hide();
  $('.top-thead').show();
}

//=======================================================================================================

//=================================compare dropdown====================================================
function show_compare(){
 $('#compare_div').removeClass('hide');
 $('#compare_btn').addClass('hide');
}

function set_compare(op,id){
  chartData['compareDate'] = {'operation':op};
  $('#dateCompareDropdown1 span:first-child').html(op);
  $('.cp_dd').removeClass('selected');
  $('.com'+id).addClass('selected');
}

//=======================================================================================================
//=================================daterange dropdown====================================================
function daterange_filter(text,day){
  $('#daterange_filter span:first-child').html(text);
  chartData['dateRange'] = {'days':day,'columnName':'Close Date'};
  console.log(chartData);
}

function getFilterdata(){
  console.log(chartData);
  // chartData = {
  //   "YAxisData": { 
  //     "YAxisData1":{
  //       "operator": "sum",
  //       "columnName": "Id",
  //     }, 
  //     "YAxisData2":{
  //       "operator": "average",
  //       "columnName": "Deal Name",
  //     }, 
  //     "YAxisData2":{
  //       "operator": "average",
  //       "columnName": "Deal Name",
  //     }
  //   },
  //   "XAxisData": { 
  //     "columnName": "closed date",
  //     "sortBy": "month"
  //   }
  // }
  console.log(chartData);
  $.ajax({
    beforeSend: function() {
      $("#preloader").fadeIn();
    },
    url: '../filteredata',
    method: 'get',
    dataType: 'json',
    processData: false,
    data: $.param({"chartData": chartData}),
    success: function(res) {
      
      alert('1');

    },
    error: function(xhr) {},
    complete: function() {
    $("#preloader").fadeOut();
    }
  })
}









