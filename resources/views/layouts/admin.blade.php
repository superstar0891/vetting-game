
<!DOCTYPE html>
<html lang="en">


<!-- index22:59-->
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico')}}">
    <title>Administarator</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap4.min.css')}}">
    <!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
    
    <script src="{{ asset('assets/js/jquery-3.2.1.min.js')}}"></script>
	<script src="{{ asset('assets/js/popper.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.js')}}"></script>
    <script src="{{ asset('assets/js/Chart.bundle.js')}}"></script>
    <script src="{{ asset('assets/js/chart.js')}}"></script>
    <script src="{{ asset('assets/js/app.js')}}"></script>
</head>

<body>
    <div class="main-wrapper">
        <div class="header">
			<div class="header-left">
				<a href="/" class="logo">
					<img src="{{ asset('assets/img/logo.png')}}" width="35" height="35" alt=""> <span>Spread</span>
				</a>
			</div>
			<a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
            <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
            <ul class="nav user-menu float-right">
                
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <span class="user-img">
							<img class="rounded-circle" src="{{ asset('assets/img/user.jpg')}}" width="24" alt="Admin">
							<span class="status online"></span>
						</span>
						<span>{{ Auth::user()->first_name }}  {{ Auth::user()->last_name }}</span>
                    </a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="/admin/profile">My Profile</a>
						<a class="dropdown-item" href="/admin/change">Change Password</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
					</div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu float-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="/admin/profile">My Profile</a>
                    <a class="dropdown-item" href="/admin/change">Change Password</a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </div>
            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">Main</li>
                        <li class="{{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
                            <a href="/admin/dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        </li>
						<li class="{{ (request()->is('admin/users')) ? 'active' : '' }}">
                            <a href="/admin/users"><i class="fa fa-user-md"></i> <span> Users </span></a>
                        </li>
                        <li class="{{ (request()->is('admin/payments')) ? 'active' : '' }}">
                            <a href="/admin/payments"><i class="fa fa-money"></i> <span> Payments </span> </a>
						</li>

                        <li class="submenu">
							<a href="#" class="{{ (request()->is('admin/bettings/*')) ? 'subdrop' : '' }}"><i class="fa fa-cube"></i> <span> Bettings </span> <span class="menu-arrow"></span></a>
							<ul style="display:{{ (request()->is('admin/bettings/*')) ? 'block' : 'none' }};">
                                @foreach($sports as $sport)
								<li><a  href="/admin/bettings/{{$sport->id}}"> {{$sport->name}} </a></li>
                                @endforeach
                            </ul>
						</li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>
    <div class="sidebar-overlay" data-reff=""></div>
    
    

</body>


<!-- index22:59-->
</html>