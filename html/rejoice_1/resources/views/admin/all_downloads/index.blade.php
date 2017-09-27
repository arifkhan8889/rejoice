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
            <span> All Download </span>
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
                    <span class="caption-subject bold uppercase"> All Download List</span>
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
                <div id="sample_1_wrapper" class="dataTables_wrapper no-footer">
                    <div class="table-section">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="all_downloads_list">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input id="ckbCheckAll" type="checkbox"  class="group-checkable" data-set="#sample_1 .checkboxes" />
                                            <span></span>
                                        </label>
                                    </th>
                                    <th> Audio </th>
                                    <th> Artist </th>
                                    <th> Album </th>
                                    <th> No Of Downloads  </th>
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
    var url = "{{ URL::to('all_downloads')}}";
    var table = $('#all_downloads_list').DataTable ({
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
            { "orderable": true, "targets": [ 4 ] }
        ],
        columns: [
            { "data": "audio_id" },
            { "data": "audio_download.title" },
            { "data": "audio_download.artist" },
            { "data": "audio_download.album_title"},
            { "data": "total"},
        ],
       "rowCallback": function (row, data,index) {   
        $('td:eq(0)', row).html(
                                '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">'+
                                     '<input type="checkbox" class="checkboxes set_checkbox_atr checkBoxClass"  value="" />'+
                                            '<span></span>'+
                                 '</label>'
        );
    },
    });  
</script>    
@endsection