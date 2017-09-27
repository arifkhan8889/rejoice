@extends('layouts.header')
@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{url('video')}}">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span>Edit Video</span>
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
                    <span class="caption-subject font-red sbold uppercase">Edit Video</span>
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
                <form method="post" class="form-horizontal" id="video_add" action="{{url('video/'.$video_info->id)}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ Form::hidden('_method', 'PUT') }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Title
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="title"  value="{{$video_info->title}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Video Url
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="url"  value="{{$video_info->url}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Artist 
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="artist"  value="{{$video_info->artist}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Album Title 
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                            <select name="album_title" class="form-control">
                                    <option value="">-Select Category-</option>
                                    @foreach($album_info as $album)
                                    <option value="{{$album->id}}" {{ $video_info->album_id == $album->id ? 'selected="selected"' : '' }} >{{$album->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-md-3">Genre 
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="genre"  value="{{$video_info->genre}}" type="text" class="form-control" />
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-md-3">Language 
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="language"  value="{{$video_info->language}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Content Provider 
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="content_provider"  value="{{$video_info->content_provider}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Sub CP 
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="sub_cp"  value="{{$video_info->sub_cp}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Label 
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="label"  value="{{$video_info->label}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Category 
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="category"  value="{{$video_info->category}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Sub-Category 
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="sub_category"  value="{{$video_info->sub_category}}" type="text" class="form-control" />
                            </div>
                        </div>
                       <div class="form-group">
                            <label class="control-label col-md-3">Artist Image
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="artist_image" id="uploadFile2" placeholder="Choose File" class="form-control" type="file">
                                @if($video_info->artist_image!=null)
                                <img vspace="20" src="{{URL::to(env('S3_ARTIST_PATH').$video_info->artist_image)}}" alt="No Image Found" style="width:120px;height:120px;">
                                @endif
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" name="cmdSubmit" value="submit" class="btn green">Submit</button>
                                    <a href="{{url('video')}}" class="btn grey-salsa btn-outline">Cancel</a>
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
                    title: {
                        required: true,
                    },
                    url:{
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
//                    album_art:
//                            {
//                                extension: "png|jpg|jpeg|gif"
//                            },
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
                        required: "Please Enter artist" },
                    title: {required: "Please Enter Title "},
//                    album_title: {required: "Please Enter album title "},
//                    language: { required: "Enter language"  },
                    genre: { required: "Please Enter genre" },
                     url: { required: "Please Enter url" },
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