@extends('admin.layouts.dashboard_v3')
@section('content1')



<div class="wrapper wrapper-content">
	
                           
              
<style>
.swal2-styled.swal2-confirm {
    background-color: #633141 !important;
    
    
}
</style>                
              
   
                         @foreach($data_sources as $data_sources_row)
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <div class="ibox-tools">
                                    <span class="float-right"><img src="{{ $data_sources_row->connection_img }}"  width="25" height="29"></span>
                                </div>
                                <h5>{{ $data_sources_row->name }}
                               </h5>
                            </div>
                            <div class="ibox-content">
                                <div class="stat-percent font-bold text-navy"></div>
                                <small>
@if($data_sources_row->connection_status == '2')
    Some error connecting the API<br><br>
    <a href="{{ route('connections',['param'=>$data_sources_row->id])}}" type="button" class="add_btn"> 
    Reconfigure &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </a>

                      @elseif($data_sources_row->connection_status == '0')
                                 
                           <?php      /*  <a href="{{ route('connections',['param'=>$data_sources_row->id])}}" type="button" class="add_btn"> */ ?>
                                API Connection is in progress 
                           <?php      /*     </a> */ ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          
@endif
<?php /* href="{{ route('connections-delete',['param'=>$data_sources_row->id])}}" */ ?>

                    <script type="text/javascript">

                function deleteLessonData(id,name)
                { 
                    var ids=id;
                    Swal.fire({
                      title: 'Are you sure to remove '+name+'?',
                      text: 'You will not be able to recover this data!',
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonText: 'Yes, delete it!',
                      cancelButtonText: 'No, keep it'
                    }).then((result) => {

                             if (result.value) {
                        window.location.href = "{{ route('connections-delete',['param'=>$data_sources_row->id])}}";        
                            } else {
                        
                            }
                    
                    }
)
                }
                </script>

     <a  onclick="deleteLessonData('{{ $data_sources_row->id }}','{{ $data_sources_row->name }}')"  type="button" class="add_btn">Remove</a>
                      
                                </small>
                            </div>
                        </div>
                    </div>
                    
              
              </div>
  
  
    @endforeach
               
               
            </div>
            
            
            
            
            
            
@stop