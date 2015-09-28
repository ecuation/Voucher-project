@extends('backoffice')

@section('nav')
<nav>
	<ul id="breadcrumb">
		<li>Admin</li>
	</ul>
</nav>

@stop

@section('content')

<ul class="sections">
	<li class="myvouchers">
		<a class="icon-ticket" href="{{url('admin/vouchers')}}">My Vouchers</a>
	</li>
	<li class="newvoucher">
		<a class="icon-cut" href="{{url('admin/voucher/new')}}">New Voucher</a>
	</li>
	<li class="shop">
		<a class="icon-favorite-marker" href="{{url('shops')}}">Shops</a>
	</li>
	<li class="settings">
		<a class="icon-setting-gear" href="{{url('admin/settings')}}">Settings</a>
	</li>
	<li class="front">
		<a class="icon-layers" target="_blank" href="{{url('customer/vouchers')}}">Front</a>
	</li>
</ul>
@stop
