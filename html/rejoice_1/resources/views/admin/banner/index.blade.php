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
            <span> Banner </span>
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
                    <span class="caption-subject bold uppercase"> Banner List</span>
                </div>
            </div>
            @if(Session::has('message'))
              <div class="alert alert-success delete_msg">
                  {{ Session::get('message') }}
               </div>
            @endif
             <div class="alert alert-success delete_show_msg" style="display:none"> 
              </div>
            <div class="portlet-body">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a href="{{url("banner/create")}}"  class="btn sbold green"> Add New
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
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="banner_list">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input id="ckbCheckAll" type="checkbox"  class="group-checkable" data-set="#sample_1 .checkboxes" />
                                            <span></span>
                                        </label>
                                    </th>
                                    <th> Name </th>
                                    <th> Banner Url </th>
                                    <th> Banner Image </th>
                                    <th> Time(IN Sec) </th>
                                    <!--<th>  Genre </th>-->
                                    <!--<th> Content Provider </th>-->
                                    <!--<th>  Sub_CP </th>-->
                                    <!--<th> Label </th>-->
                                    <!--<th> Category </th>-->
                                    <!--<th> Sub-Category </th>-->
<!--                                <th> Artist Image </th>-->
                                    <!--<th> Album Art </th>-->
                                    <th > Action </th>
                                </tr>
                            </thead>
                            <tbody>   
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
    var url = "{{ URL::to('banner')}}";
    var table = $('#banner_list').DataTable ({
        "paging": true,
        "ordering": true,
        "info": true,
        "lengthMenu": [[2, 5, 15, 25, -1], [2, 5, 15, 25, "All"]],
        "pageLength": 15,
        "processing": true,
        "serverSide": true,
        "ajax": {"url": url },
        columnDefs: [
            { "orderable": false, "targets": [ 0 ] },
            { "orderable": true, "targets": [ 1 ] },
            { "orderable": true, "targets": [ 2 ] },
            { "orderable": true, "targets": [ 3 ] },
            { "orderable": true, "targets": [ 4 ] },
            { "orderable": false, "targets": [ 5 ] }
        ],
        columns: [
            { "data": "id" },
            { "data": "name" },
            { "data": "banner_url" },
            { "data": "banner_image" },
            { "data": "time" },
            { "data": "id" },
        ],
       "rowCallback": function (row, data,index) {   
        $('td:eq(0)', row).html(
                                '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">'+
                                     '<input type="checkbox" class="checkboxes set_checkbox_atr checkBoxClass"  value="" />'+
                                            '<span></span>'+
                                 '</label>'
        );
          $('td:eq(3)', row).html(
              '<img src="' + s3_banner_url + data.banner_image + '" alt="No Image Found" style="width:120px;height:120px;">'
        );
        //View/Edit/Delete Link
        $('td:last-of-type', row).html(
            '<a class="btn btn-icon-only green" title="Edit" href="'+url+'/'+data.id+'/edit"><i class="fa fa-pencil"></i></a>' +
            ' <a type="button" id="delete_audio'+data.id+'" title="Delete" data-id='+data.id+' class="btn btn-icon-only red audio_delete"><i class="fa fa-trash"></i></a>'
        );
    },
    });  
     $('body').on('click', '.audio_delete',function(e){
        var answer = confirm("Are you sure you want to delete ?");
        if(answer){
        $('.delete_msg').hide();
        $('#cover').show();
        var id = $(this).data('id');
        $.ajax({
           url:url+'/'+id,
           type:'DELETE',
           data:{"_token": "{{ csrf_token() }}"},
           success:function(response){
               if(response=='true'){
                 table
                        .draw();
                $('#cover').fadeOut(200);
                $('.delete_show_msg').show().html('Banner Deleted Successfully!!!');
               }            
           }
        });
    }
    });
    $('#audio_list').find('.sorting_asc').first().removeClass('sorting_asc');
</script>    
@endsection