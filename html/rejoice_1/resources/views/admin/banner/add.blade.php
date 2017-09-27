@extends('layouts.header')
@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{url('banner')}}">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span>Add Banner</span>
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
                    <span class="caption-subject font-red sbold uppercase">Add Banner</span>
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
                <form method="post" class="form-horizontal" id="video_add" action="{{url('banner')}}" enctype="multipart/form-data" files=true>
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Name
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="name"  value="{{old('name')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Banner Image
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="banner_image" id="uploadFile0" placeholder="Choose File" class="form-control" type="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Banner Url 
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="banner_url"  value="{{old('banner_url')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Time(IN Sec)
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="time"  value="{{old('time')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" name="cmdSubmit" value="submit" class="btn green">Submit</button>
                                    <a href="{{url('banner')}}" class="btn grey-salsa btn-outline">Cancel</a>
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
                name: {
                    required: true,
                },
//                time: {
//                    required: true,
//                },
//                banner_url: {
//                    required: true,
//                },
                banner_image:
                        {
                            extension: "png|jpg|jpeg|gif"
                        },
            },
            messages: {
                name: {
                    required: "Please Enter Name"},
                banner_image: {
                    required: "Please Select Image",
                    extension: "Please enter a value with a valid extension"
                },
            }
        });
    });

</script>
@endsection