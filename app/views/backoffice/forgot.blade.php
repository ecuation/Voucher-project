@extends('backoffice')

@section('content')
	<div class="login_form">
	 	<h2>Enter your email</h2>
		{{Form::open()}}             
	        <div>
	        	<span class="icon-address"></span>
	        	{{ Form::text('email', Input::old('email'),  array('placeholder'=>'Email')) }}
	        </div>
		    {{Form::submit('enter')}}
	 	 	<a class="forgot" href="{{url('login')}}">Login</a>
		{{Form::close()}}
	</div>
@stop