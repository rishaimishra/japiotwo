@if(Session::has('success'))
    <div class="row">
        <div class="alert alert-success  card-body col-md-11" role="alert">   

            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>        
            {{ Session::get('success') }}
        </div>
    </div>
@elseif(Session::has('error'))
    <div class="row">
        <div class="alert alert-danger  card-body col-md-11" role="alert">   

            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>        
            {{ Session::get('error') }}
        </div>
    </div>
@endif