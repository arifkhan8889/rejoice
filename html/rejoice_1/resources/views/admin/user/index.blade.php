@extends('layouts.header')
@section('content')
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span> User </span>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> Users List</span>
                </div>
            </div>
            @if(Session::has('message'))
              <div class="alert alert-success">
                  {{ Session::get('message') }}
               </div>
            @endif
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a href="{{url("user/create")}}"  class="btn sbold green"> Add New
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
<!--                            <div class="btn-group">
                                <a href="javascript:void(0);" id="delete_user"  class="btn sbold green"> Delete
                                    <i class="fa fa-user-times"></i>
                                </a>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                    <div class="table-section">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="user_list">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input id="ckbCheckAll" type="checkbox"  class="group-checkable" data-set="#sample_1 .checkboxes" />
                                            <span></span>
                                        </label>
                                    </th>
                                    <th> First Name </th>
                                    <th> Last Name </th>
                                    <th> Email </th>
                                    <th> Username </th>   
                                    <th > Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr class="odd gradeX">
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes set_checkbox_atr checkBoxClass"  value="" />
                                            <span></span>
                                        </label>
                                    </td>
                                    <td>{{ $user->firstname }}</td>
                                    <td>
                                        {{ $user->lastname }}
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                     <td>
                                        {{ $user->username }}
                                    </td>
                                    <td>
                                        {{ Form::open(array('url' => 'user/' . $user->id,'onsubmit' => "return confirm('Are you sure you want to delete?')",'class' => 'pull-left')) }}
                                        {{ Form::hidden('_method', 'DELETE') }}
                                        <button type="submit" title="Delete" class="btn btn-icon-only red"><i class="fa fa-trash"></i></button>
                                        {{ Form::close() }}
                                         <a href="{{url("user/".$user->id."/edit")}}" title="Edit" class="btn btn-icon-only green">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

<script>

$(document).ready(function () {
    $('#ckbCheckAll').click(function () {
        $('.checkBoxClass').prop('checked', $(this).is(':checked'));
    });
    $(".checkBoxClass").click(function () {
        if ($(".checkBoxClass").length == $(".checkbox:checked").length) {
            $("#ckbCheckAll").prop("checked", true);
        } else {
            $("#ckbCheckAll").prop("checked", false);
        }
    });
});

$("#delete_user").click(function (event) {
    $('#checked_id').val('');
    var checkIds = [];
    var oTable = $('#user_list').dataTable();
    var rowcollection = oTable.$(".set_checkbox_atr:checked", {"page": "all"});
    rowcollection.each(function (index, elem) {
        // var checkbox_value = $(elem).val();
        checkIds.push($(elem).val());
        //  alert(checkbox_value);
        //Do something with 'checkbox_value'
    });
    $('#checked_id').val(checkIds);
    if (checkIds != "") {
        $('#checked_id').val(checkIds);

        var r = confirm('Are you sure, you want delete user');
        if (r) {
            $('#delete_selected_ct').submit();
        }
    } else {
        alert('Please select user');

    }
});
$(function () {
    // $("#example1").DataTable();
    $('#user_list').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "columnDefs": [
            {"orderable": false, "targets": [0]},
            {"orderable": false, "targets": [5]},
        ],
    });
    $('#user_list').find('.sorting_asc').first().removeClass('sorting_asc');
});
</script>                                          
@endsection