@extends('front')

@section('title')
Unsubscribe
@stop

@section('content')
<h2 class="icon-ticket title">Promociones / ofertas disponibles</h2>
<div class="content">
	<h3 class="titles">Estás a punto de darte de baja...</h3>

	<p>Introduce tu email y a continuación pulsa en "Confirmar". Recibirás un correo de confirmación.</p>

	<div class="form-wrapper">
	{{ Form::open(array('url' => 'customer/unsubscribe', 'method'=>'post')) }}
	
		{{Form::text('email', null, array('placeholder'=>'Email'))}}

		{{Form::submit('Confirmar', array('class'=>'btn primary'))}}
	{{Form::close()}}
	</div>

<hr>
	<a href="{{url('customer/vouchers')}}">volver a mis cupones</a>
</div>
@stop