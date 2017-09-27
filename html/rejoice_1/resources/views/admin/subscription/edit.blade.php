@extends('layouts.header')
@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{url('subscription')}}">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span>Edit Subscription Types</span>
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
                    <span class="caption-subject font-red sbold uppercase">Edit Subscription Types</span>
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
                <form method="post" class="form-horizontal" id="video_add" action="{{url('subscription/'.$subscription_info->id)}}" enctype="multipart/form-data" files=true>
                    {{ csrf_field() }}
                    {{ Form::hidden('_method', 'PUT') }}
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3"> Type
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="type"  value="{{$subscription_info->type}}" type="text" class="form-control" />
                            </div>
                        </div>
                          <div class="form-group">
                            <label class="control-label col-md-3"> Cost
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="cost"  value="{{$subscription_info->cost}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3"> No Of Songs
                                <!--<span class="required"> * </span>-->
                            </label>
                            <div class="col-md-4">
                                <input name="no_of_songs"  value="{{$subscription_info->no_of_songs}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" name="cmdSubmit" value="submit" class="btn green">Submit</button>
                                    <a href="{{url('subscription')}}" class="btn grey-salsa btn-outline">Cancel</a>
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
                    type: {
                        required: true,
                    },
                    cost:{
                        required: true,
                    },
                },
                messages: {
                    type: {
                        required: "Please Enter artist" },
                    cost: {required: "Please Enter Title "},
                    album_title: {required: "Please Enter album title "},
                }
            });
        });

    </script>
    @endsection