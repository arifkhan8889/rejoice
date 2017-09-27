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
            <span>Add User</span>
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
                    <span class="caption-subject font-red sbold uppercase">Add User</span>
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
                <form method="post" class="form-horizontal" id="user_add" action="{{url('user')}}">
                    {{ csrf_field() }}
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
                                <input name="firstname"  value="{{old('firstname')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Last Name
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="lastname"  value="{{old('lastname')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="email"  value="{{old('email')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Username
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="username"  value="{{old('username')}}" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Password
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="password"  type="password" id="password" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Confirm Password
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input name="confirm_password" type="password" id="confirm_password" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <span class="text-info">NOTE!</span>
                            <br>
                            <span style="color: #737373;">
                                Password must contain min 6 characters including
                                <ul>
                                    <li> atleast 1 number and 1 special character </li>
                                    <li> atleast 1 uppercase and 1 lowercase letter </li>
                                </ul>
                            </span>
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
            $('#user_add').validate({
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
                    },
                   username: {
                        required: true
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
                        required: "Please Enter email id",
                        email: "Please Enter valid email",
                        remote: "Please Email id already exists "
                    },
                    firstname: {required: "Please Enter First Name "},
                    username: {required: "Please Enter User Name "},
                    lastname: {required: "Please Enter Last Name "},
                    password: {
                        required: "Please Enter password"
                    },
                    confirm_password: {
                        required: "Please Enter confirm password",
                        equalTo: "The Confirm Password field does not match the Password field."
                    },
                }
            });
        });

    </script>
    @endsection