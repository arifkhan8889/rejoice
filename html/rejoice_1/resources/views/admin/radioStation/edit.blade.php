@extends('layouts.header')
@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{url('radio_station')}}">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span>Edit Radio Station</span>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN VALIDATION STATES-->
        <div class="portlet light portlet-fit portlet-form ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">Edit Radio Station</span>
                </div>
            </div>
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="portlet-body">
                <form method="post" class="form-horizontal" id="video_add" action="{{url('radio_station/'.$radio_station->id)}}" enctype="multipart/form-data" files=true>
                    {{ csrf_field() }}
                    {{ Form::hidden('_method', 'PUT') }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3"> Station Name
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="station_name"  value="{{$radio_station->station_name}}" type="text" class="form-control" />
                            </div>
                        </div>
                          <div class="form-group">
                            <label class="control-label col-md-3">Show On Landing Page
                            </label> 
                            <div class="col-md-4" style="height:30px;">
                                @if($radio_station['is_active'] == 1)
                                    <input id="switc" name="is_active" value="1" type="checkbox" data-off-color="warning" data-on-color="success" class="make-switch" checked="checked">
                                @else
                                    <input id="switc" name="is_active" value="1" type="checkbox" data-off-color="warning" data-on-color="success" class="make-switch">
                                @endif
                                <input id="hiddenswit" type="hidden" value="{{$radio_station['is_active']}}" name="status" id="status">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3"> Station Url
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="station_url"  value="{{$radio_station->station_url}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" name="cmdSubmit" value="submit" class="btn green">Submit</button>
                                    <a href="{{url('radio_station')}}" class="btn grey-salsa btn-outline">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form> 
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>
<script>

    $(document).ready(function ()
    {
        $('#video_add').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            rules: {
                station_name: {
                    required: true,
                },
                station_url:
                        {
                           required: true,
                        },
            },
            messages: {
                station_name: {
                    required: "Please Enter Station Name"},
                station_url: {
                    required: "Please Enter Station Url"},
            }
        });
        $('#switc').on('switchChange.bootstrapSwitch', function(event, state){
            var checkd = + state;
            $("#hiddenswit").val(checkd);
            event.stopPropagation();
        });
    });

</script>
@endsection