<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a class="site-logo" href="javascript:void(0)">
                Rejoice</a>
            <div class="menu-toggler sidebar-toggler"> </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE ACTIONS -->
        <!-- DOC: Remove "hide" class to enable the page header actions -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right" >
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <!-- <img alt="" class="img-circle" src="../assets/layouts/layout2/img/avatar3_small.jpg" />-->
                            <span class="username username-hide-on-mobile">{{ Auth::user()->firstname." ".Auth::user()->lastname }}</span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="{{url("my_profile")}}">
                                    <i class="icon-user"></i> My Profile </a>
                            </li>
                            <!--                            <li>
                                                            <a href="{{url('password/email')}}">
                                                                <i class="icon-lock"></i>
                                                                Change Password
                                                            </a>
                                                        </li>-->
                            <li >
                                <a href="{{ url('/logout') }}">
                                    <i class="icon-key"></i> Log Out </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- END SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item {{ (in_array(\Request::route()->getName(), ['user.index', 'user.create', 'user.edit'])) ? 'active open' : '' }}">
                <a href="{{url("user")}}" class="nav-link nav-toggle  ">
                    <i class="icon-user "></i>
                    <span class="title">User</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{url("user")}}" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">List</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url("user/create")}}" class="nav-link ">
                            <i class="icon-user-female"></i>
                            <span class="title">Add</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ (in_array(\Request::route()->getName(), ['video.index', 'video.create', 'video.edit'])) ? 'active open' : '' }}">
                <a href="{{url("video")}}" class="nav-link nav-toggle  ">
                    <i class="icon-user "></i>
                    <span class="title">Video</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{url("video")}}" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">List</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url("video/create")}}" class="nav-link ">
                            <i class="icon-user-female"></i>
                            <span class="title">Add</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ (in_array(\Request::route()->getName(), ['audio.index', 'audio.create', 'audio.edit'])) ? 'active open' : '' }}">
                <a href="{{url("audio")}}" class="nav-link nav-toggle  ">
                    <i class="icon-user "></i>
                    <span class="title">Audio</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{url("audio")}}" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">List</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url("audio/create")}}" class="nav-link ">
                            <i class="icon-user-female"></i>
                            <span class="title">Add</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ (in_array(\Request::route()->getName(), ['sermon.index', 'sermon.create', 'sermon.edit'])) ? 'active open' : '' }}">
                <a href="{{url("sermon")}}" class="nav-link nav-toggle  ">
                    <i class="icon-user "></i>
                    <span class="title"> Sermons </span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{url("sermon")}}" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">List</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url("sermon/create")}}" class="nav-link ">
                            <i class="icon-user-female"></i>
                            <span class="title">Add</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ (in_array(\Request::route()->getName(), ['album.index', 'album.create', 'admin.edit'])) ? 'active open' : '' }}">
                <a href="{{url("album")}}" class="nav-link nav-toggle  ">
                    <i class="icon-user "></i>
                    <span class="title">Album</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{url("album")}}" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">List</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url("album/create")}}" class="nav-link ">
                            <i class="icon-user-female"></i>
                            <span class="title">Add</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ (in_array(\Request::route()->getName(), ['banner.index', 'banner.create', 'banner.edit'])) ? 'active open' : '' }}">
                <a href="{{url("banner")}}" class="nav-link nav-toggle  ">
                    <i class="icon-user "></i>
                    <span class="title">Banner</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{url("banner")}}" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">List</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url("banner/create")}}" class="nav-link ">
                            <i class="icon-user-female"></i>
                            <span class="title">Add</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ (in_array(\Request::route()->getName(), ['subscription.index', 'subscription.create', 'subscription.edit'])) ? 'active open' : '' }}">
                <a href="{{url("subscription")}}" class="nav-link nav-toggle  ">
                    <i class="icon-user "></i>
                    <span class="title"> Subscription Type</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{url("subscription")}}" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">List</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url("subscription/create")}}" class="nav-link ">
                            <i class="icon-user-female"></i>
                            <span class="title">Add</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ (in_array(\Request::route()->getName(), ['transaction.index'])) ? 'active open' : '' }}">
                <a href="{{url("transaction")}}" class="nav-link nav-toggle  ">
                    <i class="icon-user "></i>
                    <span class="title"> User Subscription List</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{url("transaction")}}" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">List</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ (in_array(\Request::route()->getName(), ['all_downloads.index'])) ? 'active open' : '' }}">
                <a href="{{url("all_downloads")}}" class="nav-link nav-toggle  ">
                    <i class="icon-user "></i>
                    <span class="title"> All Downloads </span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{url("all_downloads")}}" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">List</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ (in_array(\Request::route()->getName(), ['radio_station.index', 'radio_station.create', 'radio_station.edit'])) ? 'active open' : '' }}">
                <a href="{{url("radio_station")}}" class="nav-link nav-toggle  ">
                    <i class="icon-user "></i>
                    <span class="title"> Radio Station</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{url("radio_station")}}" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">List</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url("radio_station/create")}}" class="nav-link ">
                            <i class="icon-user-female"></i>
                            <span class="title">Add</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ (in_array(\Request::route()->getName(), ['comments.index'])) ? 'active open' : '' }}">
                <a href="{{url("comments")}}" class="nav-link nav-toggle  ">
                    <i class="icon-user "></i>
                    <span class="title"> Comments </span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{url("comments")}}" class="nav-link ">
                            <i class="icon-user"></i>
                            <span class="title">List</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
<!--                 BEGIN PAGE HEADER-->
