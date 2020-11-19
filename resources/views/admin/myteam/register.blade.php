<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

       <title>JAPIO</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>

    <img src="{{ asset('img/japio.png') }}"  width="100" height="100">

            </div>
            <h3>Register to JAPIO</h3>
            <p>Create account to see it in action.</p>
            
                            <form method="post" action="">
                              @csrf
                                    @if(Session::has('success'))
                                        <div class="alert alert-success col-md-12" role="alert">   
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>        
                                    {{ Session::get('success') }}
<a href="{{ url('') }}">CLICK</a> To Login
                                        </div>
                                    @endif
                                    @if(Session::has('error'))
                                        <div class="alert alert-danger  col-md-12" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                    {{ Session::get('error') }}
                                        </div>
                                    @endif
                
                <div class="form-group">
                    <input type="email" placeholder="Email" name="email_id" id="email_id" value="{{ @$email_id }}" class="form-control" disabled>
                </div>
                <div class="form-group">
                     <input type="text" name="name" id="name" placeholder="Full Name" class="form-control" required>
                    
                </div>
                <div class="form-group">
                
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password"required>
                
                </div>
                   
<div class="form-group">

 <input type="password" placeholder="Re Password" name="repassword" id="repassword" class="form-control" required >                  
 </div>
        
<div class="form-group">

 <input type="text" placeholder="Your Role in your Company" name="destination" id="destination" class="form-control" required >                  
 </div>
 
                <button type="submit" name="send" class="btn btn-primary block full-width m-b">Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-primary block full-width m-b" href="{{ route('login') }}">Login</a>
            </form>
            
        </div>
    </div>

    
 <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
 <script src="{{ asset('js/popper.min.js') }}"></script>
 <script src="{{ asset('js/bootstrap.js') }}"></script>
 
</body>

</html>





















