@extends('admin.layouts.dashboard_v3')
@section('content1')

 <link href="http://webapplayers.com/inspinia_admin-v2.9.3/css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">






<br><br>










  <div class="content__inner">

                    <div class="card">
                        <div class="card-body">
                        <div class="row">
                        
                                <div class="col-md-10">
                                       <div class="form-group">
                                            <label> <h4 class="card-title">Profile Update </h4></label>
                                        </div>
                                    </div>
                        
                                <div class="col-md-2">
                                       <div class="form-group">
                                            <label><button type="button" name="back" class="btn btn-primary btn-sm"><a href="profile" style="color: white !important;"> Back</a></button> </label>
                                        </div>
                                    </div>
                        
                        </div>
                            
                            <hr>
                     
                             
                                   
                                       <form method="post" action="{{ url("profile-update") }}" enctype="multipart/form-data">     
                                         @csrf
                                                                             @if(Session::has('success1') && (Session::get('success1')!=""))
                                        <div class="alert alert-success col-md-12" role="alert">   
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>        
                                    {{ Session::get('success1') }}

                                        </div>
                                    @endif
                                    @if(Session::has('error1') && (Session::get('error1')!=""))
                                        <div class="alert alert-danger  col-md-12" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                    {{ Session::get('error1') }}
                                        </div>
                                    @endif

 <div class="row">
                                <div class="col-md-3">
                                       <div class="form-group">
                                            <label> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                       <div class="form-group">
                                        @if ($users->pro_img != '')                                                
                                       <img alt="image" class="rounded-circle" src="{{ @$users->pro_img }}" style="height: 100px;width: 100px;">   
                                         @endif 
                                                                               </div>                                        </div>
                                       <div class="col-md-7">
                                       <div class="form-group">
<!--
<div class="fileinput fileinput-new" data-provides="fileinput">
    <span class="btn btn-default btn-file"><span class="fileinput-new">Select img</span>
    <span class="fileinput-exists">Change</span>
    -->
    <br><br>
     <div class="fileinput fileinput-new" data-provides="fileinput">
    <span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span>
    <span class="fileinput-exists">Change</span><input type="file" id= "profile_img_update" name="profile_img_update" accept="image/*"  required/></span>
    <span class="fileinput-filename"></span>
    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
</div> 
    
  
    <!--
    
    </span>
    <span class="fileinput-filename"></span>
    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
</div>                                        
-->
<script>
        Dropzone.options.dropzoneForm = {
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            dictDefaultMessage: "<strong>Drop files here or click to upload. </strong></br> (This is just a demo dropzone. Selected files are not actually uploaded.)"
        };

        $(document).ready(function(){

            var editor_one = CodeMirror.fromTextArea(document.getElementById("code1"), {
                lineNumbers: true,
                matchBrackets: true
            });

            var editor_two = CodeMirror.fromTextArea(document.getElementById("code2"), {
                lineNumbers: true,
                matchBrackets: true
            });

            var editor_two = CodeMirror.fromTextArea(document.getElementById("code3"), {
                lineNumbers: true,
                matchBrackets: true
            });

            var editor_two = CodeMirror.fromTextArea(document.getElementById("code4"), {
                lineNumbers: true,
                matchBrackets: true
            });


            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

       });
    </script>

 <script src="http://webapplayers.com/inspinia_admin-v2.9.3/js/plugins/jasny/jasny-bootstrap.min.js"></script>
                                   
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                       <div class="form-group">
                                    
                                    <button type="submit" name="update1" value="update" class="btn btn-primary btn-sm">Update</button>
                                    </div></div>
                                </div>
                                
                                </form>
                                
                               <hr>  
  <a name="2">   </a>                               
   <form method="post" action='{{ url("profile-update#2") }}'>     
                                 @csrf
                                                                     @if(Session::has('success2') && (Session::get('success2')!=""))
                                        <div class="alert alert-success col-md-12" role="alert">   
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>        
                                    {{ Session::get('success2') }}

                                        </div>
                                    @endif
                                    @if(Session::has('error2') && (Session::get('error2')!=""))
                                        <div class="alert alert-danger  col-md-12" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                    {{ Session::get('error2') }}
                                        </div>
                                    @endif

                                <div class="row">
                                <div class="col-md-3">
                                       <div class="form-group">
                                            <label><b>Name</b> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                <input type="text" placeholder=" " name="name" id="name" class="form-control" value="{{ @$users->name }}" required>                       
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="row">
                                <div class="col-md-3">
                                       <div class="form-group">
                                            <label><b>Email</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                <input type="text" placeholder=" " name="email" id="email" class="form-control" value="{{ @Auth::user()->email }}" disabled>                       
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="row">
                                <div class="col-md-3">
                                       <div class="form-group">
                                            <label><b>Your Role</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                <input type="text" placeholder=" " name="destination" id="destination" class="form-control" value="{{ $users->position }}"  required>                        </div>
                                    </div>
                                </div>
                                 <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                       <div class="form-group">
                                    
                                    <button type="submit" name="update2" value="update" class="btn btn-primary btn-sm">Update</button>
                                    </div></div>
                                </div>
</form>
                                <hr>
                                <a name="3">   </a>                               
                                 <form method="post" action='{{ url("profile-update#3") }}'>                                    
                                   @csrf
                                                    @if(Session::has('success3') && (Session::get('success3')!=""))
                                        <div class="alert alert-success col-md-12" role="alert">   
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>        
                                    {{ Session::get('success3') }}

                                        </div>
                                    @endif
                                    @if(Session::has('error3') && (Session::get('error3')!=""))
                                        <div class="alert alert-danger  col-md-12" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                    {{ Session::get('error3') }}
                                        </div>
                                    @endif

                                <div class="row">
                                <div class="col-md-3">
                                       <div class="form-group">
                                            <label><b>Current Password</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                <input type="password" placeholder=" " name="current_password" id="current_password" class="form-control"  required>                       
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-md-3">
                                       <div class="form-group">
                                            <label><b>Password</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                <input type="password" placeholder=" " name="password" id="password" class="form-control" required>                       
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-md-3">
                                       <div class="form-group">
                                            <label><b>Re-Password</b></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                <input type="password" placeholder=" " name="repassword" id="repassword" class="form-control" required>                       
                                        </div>
                                    </div>
                                </div>
                                 <div class="row">
                                <div class="col-md-10">
                                </div>
                                <div class="col-md-2">
                                       <div class="form-group">
                                    
                                    <button type="submit" name="update3" value="update" class="btn btn-primary btn-sm">Update</button>
                                    </div></div>
                                </div>
                                
 <hr>                                  
 
 
                             
                     </form>

                        </div>
                    </div>

                </div>
              
<br><br><br><br>
@stop