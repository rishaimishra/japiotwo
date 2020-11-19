@extends('admin.layouts.dashboard_v3')
@section('content1')
<br>
<div class="wrapper wrapper-content">            
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content text-center p-md">
                    <h2><span class="text-navy" style="color:GREEN">Your Payment is Cancelled!</span>
                    To enjoy the premium membership on {{env("APP_NAME")}}, subscribe for a new plan, click <a href="{{route('upgrade-plan')}}">here</a> to Upgrade Now.</h2>

                    <p>
                        Feel free to contact us at hello@japio.com if you need any assitance
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop