@extends('admin.layouts.dashboard_v3')
@section('content1')







<br><br>


  <div class="content__inner">
    @if(Session::has('success'))
        <div class="row">
            <div class="alert alert-success col-md-12" role="alert">   
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>        
                {{ Session::get('success') }}

            </div>
        </div>
    @endif
    @if(Session::has('error'))
        <div class="row">
            <div class="alert alert-danger  col-md-12" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
                Following error found, check if your below credentials are correct
                <br><b>{{ Session::get('error') }}</b>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Please enter below details for :: {{ ucfirst($name) }} </h4>
            <hr>
            @if(isset($reconfig) && $reconfig===true)
                <form method="post" action="{{ route('reconfig-connection',[$user_connector_id]) }}">
            @else
                <form method="post" action="{{ url("/user-connection/$id") }}">
            @endif
                @csrf
                    @foreach ($input_data as $key=>$input_data_row)
                    
                        @if(isset($input_data_row['name']) && $input_data_row['name']!='')
                            <?php 
                            if(isset($input_credentials_uc[$input_data_row['name']])){
                                $savedValue = $input_credentials_uc[$input_data_row['name']];
                            }else{
                                $savedValue = "";
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ $input_data_row['label'] }}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        @if($input_data_row['type']=='text')
                                            <input type="text" placeholder="{{ isset($input_data_row['placeholder'])?$input_data_row['placeholder']:'' }}" name="{{ $input_data_row['name'] }}" id="{{ $input_data_row['name'] }}" class="form-control" required value="{{$savedValue}}">
                                        @elseif($input_data_row['type']=='password')
                                            <input type="password" name="{{ $input_data_row['name'] }}" id="{{ $input_data_row['name'] }}" class="form-control" required value="{{$savedValue}}">
                                        @elseif($input_data_row['type']=='number')
                                            <input type="number" name="{{ $input_data_row['name'] }}" id="{{ $input_data_row['name'] }}" class="form-control" required value="{{$savedValue}}">
                                        @endif
                                        @if($input_data_row['hint'])
                                            <div class="col-sm-1 tooltip" style="padding-left: 6px;">
                                                <i class="fa fa-question-circle"></i>	
                                                <span class="tooltiptext">{!! $input_data_row['hint'] !!}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach 
                
                
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="submit" name="Save" class="btn btn-primary btn-sm">Save</button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>


@stop