<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>JAPIO | Login</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        @if ($flash = session('teamMessage'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Warning!</strong> {{ $flash }}
                </div>
            @endif 
        <div>
            <div>

            <img src="{{ asset('img/japio.png') }}"  width="100" height="100">

            </div>
            
            
            <p>Login in. To see it in action.</p>
            <form class="m-t" role="form" id="logout-form" method="POST"action="{{ route('login') }}">
                               {{ csrf_field() }}
                <div class="form-group">
                                           <input id="email" type="text" class="form-control text-center" name="email" placeholder="Email Address"  autocomplete="off" required>
                          @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong  style="color: red;">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                </div>
                <div class="form-group">
                                        @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong  style="color: red;">{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                     
                        <input id="password" type="password" class="form-control text-center" name="password" placeholder="Password"  autocomplete="off" required>
                </div>
                <input type="submit" value="Login" class="btn btn-primary block full-width m-b" >
                
            
            
            
            </form>
           

           

        
            <?php  ?>
        <div><a href="{{ route('privacy-policies') }}">Privacy Policies</a> | <a href="{{ route('data-policies') }}">Data Policies</a> | <a href="{{ route('terms-and-conditions') }}">Terms and Conditions</a> | <a href="{{route('membership-agreement')}}">Membership Agreement</a></div>
        </div>
    </div>
 
      
    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>

</body>

</html>
