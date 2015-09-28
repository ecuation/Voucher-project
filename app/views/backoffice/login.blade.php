@extends('backoffice')

@section('content')
	@if(!Auth::check())
		<div class="login_form">
		 	<h2>Log in</h2>
			{{Form::open()}}             
		        <div>
		        	<span class="icon-address"></span>
		        	{{ Form::text('email', Input::old('email'),  array('placeholder'=>'Email')) }}
		        </div>
		        <div>
		        	<span class="icon-key"></span>
		        	{{ Form::password('password', array('placeholder'=>'Password')) }}
		        </div>
			    {{Form::submit('enter')}}
		 	 	<a class="forgot" href="{{url('forgot')}}">Forgot your password?</a>
			{{Form::close()}}

			@if(Session::has('login_error'))
				{{Session::get('login_error')}}
			@endif
		</div>
	@else
		<div class="login_form">
			<a class="icon-log-out" href="{{url('logout')}}">Logout</a>
		</div>
	@endif
@stop