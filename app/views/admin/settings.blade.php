@extends('backoffice')

@section('nav')
	<ul id="breadcrumb">
		<li>
			<a class="lastcrumb" href="{{{url('admin/panel')}}}">Main</a>
		</li>
		<li>Settings</li>
	</ul>
@stop

@section('content')

<ul class="sections">
	<li class="admin-users">
		<a class="icon-user-setting" href="{{url('admin/users')}}">Users Manager</a>
	</li>
	<li class="admin-shops">
		<a class="icon-add-marker" href="{{url('admin/shops')}}">Shops Manager</a>
	</li>
</ul>
@stop
