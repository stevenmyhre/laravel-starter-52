<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <link href='//fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{build_asset('site.css')}}">

</head>
<body>
<div class="wrapper">
    <header class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">

                <div class="navbar-header">
                    <button type="button" class="btn navbar-toggle" data-toggle="collapse"
                            data-target="#nav-collapser">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">LP Spotlight by Scarsdale Security</a>
                </div>
                <div class="navbar-collapse collapse" id="nav-collapser">
                    <ul class="nav navbar-nav">
                        @if(Auth::user())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="/">Home</a></li>
                                    <li><a href="/#/site-list">Sites</a></li>
                                    <li><a target="_blank" href="http://www.scarsdalesecurityinfo.com/maswebd301201/login.aspx">Code/Schedule Changes</a></li>
                                    {{--<li><a href="/Reports">Reports</a></li>--}}
                                    {{--<li><a href="/Schedules">Holiday Schedules</a></li>--}}
                                    {{--<li><a href="/Codechanges">Code Changes</a></li>--}}
                                    @if(Auth::user()->isAdmin())
                                        <li class="divider"></li>
                                        <li><a href="/#/user-list">Users</a></li>
                                    @endif()
                                </ul>
                            </li>
                        @endif
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                        @if(Auth::User())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> {{ Auth::User()->DisplayName }}<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#/change-password"><span class="glyphicon glyphicon-refresh"></span> Change Password</a></li>
                                    <li><a href="/user/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                                </ul>
                            </li>
                        @else
                            <a href="/user/login">Login</a>
                            @endif
                            </li>
                    </ul>
                </div><!-- /.nav-collapse -->
            </div><!-- /.container -->
        </div><!-- /.navbar-inner -->
    </header><!-- /.navbar -->

    <div class="content">
        @if( Session::has('global_message'))
            <div class="container">
                <div class="alert alert-info">
                    <a class="close" data-dismiss="alert" href="#">×</a>{{Session::get('global_message')}}
                </div>
            </div>
        @endif
        @yield('content')
    </div>
    <div class="push"></div>
</div>

<footer>
    <div class="container text-center">
        <div>Copyright 2015-2016</div>
        <div>Scarsdale Security Systems</div>
    </div>
</footer>
<script src="/vendor/jquery/dist/jquery.min.js"></script>
<script src="/vendor/bootstrap-sass/assets/javascripts/bootstrap.min.js"></script>

@yield('scripts_footer')
</body>
