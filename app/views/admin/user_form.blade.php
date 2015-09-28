@extends('backoffice')

@section('nav')
	<ul id="breadcrumb">
		<li>
			<a class="lastcrumb" href="{{{url('admin/users')}}}">Users</a>
		</li>
		<li>
			@if($method == 'post')
				New User
			@elseif($method == 'put')
				Edit User
			@else
				Delete User
			@endif
		</li>
	</ul>
@stop

@section('content')
<p class="icon-information">If user's email is incorrect you have to delete it and recreate it</p>
{{Form::model($user, array('method' => $method, 'url' => 'admin/user_process/'.$user->id, 'id' => 'new-voucher'))}}
@unless($method == 'delete')
	{{Form::label('Name')}}
	{{Form::text('user_name')}}

	@if($method != 'put')
		{{Form::label('Email')}}
		{{Form::text('email')}}
	@endif

	{{Form::label('Is Admin:')}}
	{{Form::hidden('is_admin', 0)}}
	{{Form::checkbox('is_admin', 1, null, array('class'=>'is_admin'))}}


	<div class="msgs-userwin">
		<p class="icon-alert">Do you really want to @if($method == 'put') edit this user @elseif($method == 'post') create a new user @endif?</p>
		<div id="user-decisions">		
			<ul>
				<li><button class="icon-circle-check">Confirm</button></li>
				<li><a href="{{url('admin/users')}}" class="icon-circle-cross">Cancel</a></li>
			</ul>
		
		</div>
	</div>
@else
	<div class="msgs-userwin">
		<p class="icon-alert">Do you want to delete "{{$user->user_name}}"?</p>
		<div id="user-decisions">		
			<ul>
				<li><button class="icon-circle-check">Confirm</button></li>
				<li><a href="{{url('admin/users')}}" class="icon-circle-cross">Cancel</a></li>
			</ul>
		
		</div>
	</div>
@endif

{{Form::close()}}

@stop