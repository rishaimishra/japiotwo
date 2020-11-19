@if(isset($api_data) && $api_data!='')
    <a target="_blank" href="{{ route('download-json',[$dataset_id])}}" title="Download JSON Data"><i class="fa fa-download" aria-hidden="true"></i></a>
    &nbsp;&nbsp;
    <a target="_blank" href="{{ route('download-csv-data',[$dataset_id]) }}" title="Download CSV Data" ><i class="fa fa-file" aria-hidden="true"></i></a>
@endif