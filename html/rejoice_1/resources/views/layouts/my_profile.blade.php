@extends('layouts.header')
@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{url('user')}}">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span>My Profile</span>
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
                    <span class="caption-subject font-red sbold uppercase">Edit My Profile</span>
                </div>
            </div>
            <div class="portlet-body">
                <form method="post" class="form-horizontal" id="profile_edit" action="{{url('user/'.Auth::user()->id)}}">
                  {{ csrf_field() }}
                  {{ Form::hidden('_method', 'PUT') }}
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> You have some form errors. Please check below. </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> Your form validation is successful! </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">First Name
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="firstname"  value="{{Auth::user()->firstname}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Last Name
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="lastname"  value="{{Auth::user()->lastname}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="email"  value="{{Auth::user()->email}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" name="cmdSubmit" value="submit" class="btn green">Submit</button>
                                    <a href="{{url('user')}}" class="btn grey-salsa btn-outline">Cancel</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </form> 

            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
<script>

        $(document).ready(function ()
        {
            $('#profile_edit').validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {
                    firstname: {
                        required: true,
                    },
                    lastname: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true
//                        remote: {
//                            url: "{{ url("admin/admin_users/check_admin_email")}}",
//                            type: "post"
//                        }
                    },
                    password: {
                        required: true
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    email: {
                        required: "Enter email id",
                        email: "Enter valid email",
                        remote: "Email id already exists "
                    },
                    firstname: {required: "Enter First Name "},
                    lastname: {required: "Enter Last Name "},
                    password: {
                        required: "Enter password"
                    },
                    confirm_password: {
                        required: "Enter confirm password",
                        equalTo: "The Confirm Password field does not match the Password field."
                    },
                }
            });
        });

    </script>
    @endsection