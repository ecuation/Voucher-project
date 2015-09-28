<!DOCTYPE html>
<html lang="es">
<head>
<title>Backoffice</title>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' type='text/css'>
<link rel="stylesheet" href="{{asset('css/normalize.css')}}" type="text/css"/>
<link rel="stylesheet" href="{{asset('css/styles.css')}}" type="text/css"/>

<!-- Datepicker -->
<link rel="stylesheet" href="{{asset('css/datepicker.css')}}" type="text/css"/>

<!-- Fonticons -->
<link href="https://fontastic.s3.amazonaws.com/U23xEgfNLtbJCFy3iCgunF/icons.css" rel="stylesheet">

<!-- Textarea Autosize -->
<script type="text/javascript"  src="{{asset('js/jquery.js')}}"></script>
<!-- <script type="text/javascript"  src="{{asset('js/jquery.ui.js')}}"></script> -->
 <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script type="text/javascript" 	src="{{asset('js/jquery.autosize.js')}}"></script>
<script type="text/javascript"  src="{{asset('js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript"  src="{{asset('js/init.js')}}"></script>
<script type="text/javascript"  src="{{asset('js/clock.js')}}"></script>
<script type="text/javascript"  src="{{asset('js/InputEditor.js')}}"></script>
<script type="text/javascript"  src="{{asset('js/CheckboxAjax.js')}}"></script>

<!-- Telephone no -->
<meta name = "format-detection" content = "telephone=no">
</head>
<body>
<div class="wrapper">

<header>
	@yield('header')

	@if(Auth::check())
		<div id="global-nav">
			@if(Auth::user()->is_admin)
				<div class="admin_details">
					<a class="icon-star" href="{{url('admin/panel')}}">Admin</a>
				</div>
			@endif
			<div class="user_details">
				<span class="icon-user">{{{Auth::user()->user_name}}} / </span>
				<a class="icon-log-out" href="{{url('logout')}}">Logout</a>
			</div>
		</div>

		<div class="shop_details">
			@if(Session::get('shop_name'))
				@if(Request::segment(1) != 'admin')
					<span class="shop-name">{{Session::get('shop_name')}}</span>
					<br>
				@endif
			@endif		
					<span>{{Config::get('global_vars.current_date')}}</span>
					<br>
					<span id="clock" class="icon-clock"></span>			
		</div>
	@endif
	<span id="screen-resolution"></span>
</header>

<!-- conditional filterin to show reloading icon -->
@if((Request::segment(1) != 'login') && (Request::segment(1) != 'forgot'))
	<div class="extras">
		<a href="{{URL::current()}}" class="icon-refresh"></a>
	</div>
@endif

@yield('nav')
@yield('current_page')
@yield('interest_info')	
<!-- notifications: error and success  -->

@if($errors->has())
	@foreach ($errors->all() as $error)
		<div class="msg-to-user">
			<span class="icon-circle-cross-line">{{$error}}</span>
		</div>
	@endforeach
@endif

@if(Session::has('error'))
	<div class="msg-to-user">
		<span class="icon-circle-cross-line">{{Session::get('error')}}</span>
	</div>
@endif

@if(Session::has('success'))
	<div class="msg-to-user">
		<span class="icon-circle-check-line">{{Session::get('success')}}</span>
	</div>
@endif

<!-- end notifications -->
		

@yield('results_per_page')
@yield('pagination')
@yield('content')



@if((Request::segment(1) != 'login') && (Request::segment(1) != 'forgot') && (Request::segment(2) != 'panel') && (Auth::user()->is_admin))
<div id="shorcuts">
	<ul>
		<li class="myvouchers">
			<a class="icon-ticket-line" href="{{url('admin/vouchers')}}"><span class="hide-m">My Vouchers</span></a>
		</li>
		<li class="newvoucher">
			<a class="icon-cut-line" href="{{url('admin/voucher/new')}}"><span class="hide-m">New Voucher</span></a>
		</li>
		<li class="shop">
			<a class="icon-favorite-marker-line" href="{{url('shops')}}"><span class="hide-m">Shops</span></a>
		</li>
		<li class="settings">
			<a class="icon-setting-gear-line" href="{{url('admin/settings')}}"><span class="hide-m">Settings</span></a>
		</li>
		<li class="front">
			<a class="icon-layers-line" target="_blank" href="{{url('customer/vouchers')}}"><span class="hide-m">Front</span></a>
		</li>
	</ul>
</div>
@elseif((Request::segment(1) != 'login') && (Request::segment(1) != 'forgot') && (Request::segment(1) != 'shops') && (!Auth::user()->is_admin))
<div id="shorcuts">
	<ul>
		<li class="myvouchers">
			<a class="icon-ticket-line" href="{{url('admin/vouchers')}}">My Vouchers</a>
		</li>
		<li class="shop">
			<a class="icon-favorite-marker-line" href="{{url('shops')}}">Shops</a>
		</li>
		<li class="front">
			<a class="icon-layers-line" target="_blank" href="{{url('customer/vouchers')}}">Front</a>
		</li>
	</ul>
</div>

@endif

</div>
<!-- end of wrapper -->

</body>
</html>