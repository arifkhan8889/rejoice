@extends('layouts.header')
@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{url('audio')}}">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span>Add Album</span>
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
                    <span class="caption-subject font-red sbold uppercase">Add Album</span>
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
                <form method="post" class="form-horizontal" id="video_add" action="{{url('album')}}" enctype="multipart/form-data" files=true>
                    {{ csrf_field() }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Album Title 
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="album_title"  value="{{old('album_title')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Upload Audio 
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="audio_upload[]" id="uploadFile0" placeholder="Choose File" class="form-control" type="file" multiple>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Artist 
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="artist"  value="{{old('artist')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Genre 
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="genre"  value="{{old('genre')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Show On Landing Page
                            </label> 
                              <div class="col-md-4" style="height:30px;">
                                <input  name="show_on_landing" value="1" type="checkbox" data-off-color="warning" data-on-color="success" class="make-switch">
                              </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Video Url
                            </label>
                            <div class="col-md-4">
                                <input name="video_upload"  value="{{old('video_upload')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Language 
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="language"  value="{{old('language')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Content Provider 
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="content_provider"  value="{{old('content_provider')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Sub CP 
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="sub_cp"  value="{{old('sub_cp')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Label 
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="label"  value="{{old('label')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Category 
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="category"  value="{{old('category')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Sub-Category 
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="sub_category"  value="{{old('sub_category')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Artist Image
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="artist_image" id="uploadFile2" placeholder="Choose File" class="form-control" type="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Album Art  
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="album_art" id="uploadFile2" placeholder="Choose File" class="form-control" type="file">
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" name="cmdSubmit" value="submit" class="btn green">Submit</button>
                                    <a href="{{url('album')}}" class="btn grey-salsa btn-outline">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
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
                url: {
                    required: true,
                },
                artist: {
                    required: true,
                },
                album_title: {
                    required: true
                },
//                    language: {
//                        required: true
//                    },
                genre: {
                    required: true
                },
                artist_image:
                        {
                            extension: "png|jpg|jpeg|gif"
                        },
                album_art:
                        {
                            extension: "png|jpg|jpeg|gif"
                        },
                audio_upload:
                        {
                            required: true,
                            extension: "mp3|wav|m4a|3gp"
                        },
//                    content_provider: {
//                        required: true
//                    },
//                    sub_cp: {
//                        required: true
//                    },
//                    label: {
//                        required: true
//                    },
//                     category: {
//                        required: true
//                    },
//                     sub_category: {
//                        required: true
//                    },
            },
            messages: {
                artist: {
                    required: "Please Enter artist"},
                album_title: {required: "Please Enter album title "},
//                    language: { required: "Enter language"  },
                genre: {required: "Please Enter genre"},
                audio_upload: {
                    required: "Please Select Audio",
                    extension: "Please enter a value with a valid extension"
                },
//                    content_provider: { required: "Enter content provider" },
//                    sub_cp: { required: "Enter sub cp" },
//                    label: { required: "Enter label" },
//                    category: { required: "Enter category" }, 
//                    sub_category: { required: "Enter sub category" },
            }
        });
    });

</script>
@endsection