@extends('front')

@section('title')
Confirmation
@stop

@section('content')

<h2 class="icon-ticket title">Promociones / ofertas disponibles</h2>

	<div class="content">
	<h3 class="titles">Recomienda nuestras ofertas a un amigo</h3>

	<div class="form-wrapper">
	{{ Form::open(array('url' => 'customer/recommend', 'method'=>'post')) }}
		
		{{Form::text('name', null, array('placeholder'=>'Tu nombre'))}}
		
		{{Form::text('email', null, array('placeholder'=>'Email de tu amigo'))}}
		
		{{Form::submit('Recomendar', array('class'=>'btn primary'))}}
	{{Form::close()}}
	</div>
	
	<hr>
	<a href="{{url('customer/vouchers')}}">volver a mis cupones</a>
	</div>
@stop