<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>Rejoice</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{asset("/css/custom.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("/plugins/font-awesome/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("/plugins/simple-line-icons/simple-line-icons.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("/plugins/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("/plugins/bootstrap-switch/css/bootstrap-switch.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{asset("/plugins/select2/css/select2.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("/plugins/select2/css/select2-bootstrap.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{asset("/css/components.min.css")}}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{asset("/css/plugins.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{asset("pages/css/login.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->

        <link rel="shortcut icon" href="favicon.ico" /> 

        <!-- BEGIN THEME LAYOUT STYLES -->
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
        <link href="{{asset("/layouts/layout2/css/layout.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("/layouts/layout2/css/themes/blue.min.css")}}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{asset("/layouts/layout2/css/custom.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <script src="{{asset("/plugins/jquery.min.js")}}" type="text/javascript"></script>
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{asset("/scripts/datatable.js")}}" type="text/javascript"></script>
        <script src="{{asset("/plugins/datatables/datatables.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <style>
            .error{color:#C00 !important;}
            .help-block-error{color:#C00 !important;}
            .success{color:#009c0b;}
             #cover {
                    background: #2b3643 url("img/ajax-loader.gif") no-repeat scroll center center;
                    bottom: 0;
                    left: 0;
                    margin: auto;
                    opacity: 0.8;
                    position: fixed;
                    right: 0;
                    top: 0;
                    width: 100%;
                    z-index: 999999;
                    }
        </style>
        <script>
            var s3_banner_url = 'https://s3.amazonaws.com/rejoiceapp/banner_images/';
            var s3_album_url = 'https://s3.amazonaws.com/rejoiceapp/album_images/';
        </script>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
      <div id="cover" style="display: none;"></div>
        <div class="page-container">
            @include('layouts.sidebar')
            <div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    @yield('content')
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </body>
    </html>
    <!-- END HEAD -->