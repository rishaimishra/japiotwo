<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>JAPIO</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
@if(isset($page_data['menu_selected'])&&($page_data['menu_selected'] =='home')) 
    
    <link href="{{ asset('css/plugins/c3/c3.min.css') }}" rel="stylesheet">


@endif

<style>
#page-wrapper {
    padding: 50px;
    position: relative !important;
    flex-shrink: 1;
    width: 100%;
}
</style>
</head>


<body class="fixed-navigation">
    <div id="wrapper">
    
	
        <div id="page-wrapper" class="gray-bg sidebar-content">
        


	@yield('content1')
    
	@yield('content2')
        

	   <div class="footer">
            <div class="float-right">
            <a href="{{ route('data-policies') }}">Data Policies</a> | <a href="{{ route('terms-and-conditions') }}">Terms and Conditions</a> | <a href="{{route('membership-agreement')}}">Membership Agreement</a>
            </div>
            <div>
                <strong>Copyright</strong> JAPIO &copy; 2020
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
      
        $('#notifiation').html(output.data);
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
