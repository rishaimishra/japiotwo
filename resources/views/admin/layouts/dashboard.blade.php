<!DOCTYPE html>
<html lang="en">
<head>
  @include('admin.includes.head_link')
   
</head>

    <body data-sa-theme="1">
     
        <main class="main">
            <div class="page-loader">
                <div class="page-loader__spinner">
                    <svg viewBox="25 25 50 50">
                        <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg>
                </div>
            </div>

            <header class="header">
           @include('admin.includes.header')
                
              
            </header>

            <aside class="sidebar ">
               
                <div class="scrollbar">
                    <div class="user">
					@include('admin.includes.header_user_details')
                    </div>
				     @include('admin.includes.sidebar')
			  </div>
            
            
                
            </aside>
            <div class="themes">
                <div class="scrollbar">
                    <a href="#" class="themes__item active" data-sa-value="1"><img src="{{ asset('super_admin2.0/resources/img/bg/1.jpg') }}" alt=""></a>
                    <a href="#" class="themes__item" data-sa-value="2"><img src="{{ asset('super_admin2.0/resources/img/bg/2.jpg') }}" alt=""></a>
                    <a href="#" class="themes__item" data-sa-value="3"><img src="{{ asset('super_admin2.0/resources/img/bg/3.jpg') }}" alt=""></a>
                    <a href="#" class="themes__item" data-sa-value="4"><img src="{{ asset('super_admin2.0/resources/img/bg/4.jpg') }}" alt=""></a>
                    <a href="#" class="themes__item" data-sa-value="5"><img src="{{ asset('super_admin2.0/resources/img/bg/5.jpg') }}" alt=""></a>
                    <a href="#" class="themes__item" data-sa-value="6"><img src="{{ asset('super_admin2.0/resources/img/bg/6.jpg') }}" alt=""></a>
                    <a href="#" class="themes__item" data-sa-value="7"><img src="{{ asset('super_admin2.0/resources/img/bg/7.jpg') }}" alt=""></a>
                    <a href="#" class="themes__item" data-sa-value="8"><img src="{{ asset('super_admin2.0/resources/img/bg/8.jpg') }}" alt=""></a>
                    <a href="#" class="themes__item" data-sa-value="9"><img src="{{ asset('super_admin2.0/resources/img/bg/9.jpg') }}" alt=""></a>
                    <a href="#" class="themes__item" data-sa-value="10"><img src="{{ asset('super_admin2.0/resources/img/bg/10.jpg') }}" alt=""></a>
                </div>
            </div>

            <section class="content">
			@yield('content')
                
               

             
                 
                   

                <footer class="footer d-none d-sm-block">
				 @include('admin.includes.footer')
                </footer>
            </section>
        </main>

@include('admin.includes.footer_link')

    </body>

</html>