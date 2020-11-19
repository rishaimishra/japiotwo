@extends('admin.layouts.dashboard_v3')
@section('content1')
<br>
<div class="wrapper wrapper-content">            
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content text-center p-md">
                    @if($paymentStatus=="paid")
                        <h2><span class="text-navy" style="color:GREEN">Payment Successful!</span>
                        Enjoy the premium membership on {{env("APP_NAME")}}.</h2>

                        <p>
                            Feel free to contact us at hello@japio.com if you need any assitance
                        </p>
                    @else 
                        <h2><span class="text-navy" style="color:GREEN">Processing your payment!</span>
                        We will let you know once we receive your payment.</h2>

                        <p>
                            Feel free to contact us at hello@japio.com if you need any assitance
                        </p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@stop