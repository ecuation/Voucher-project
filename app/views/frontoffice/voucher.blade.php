@extends('front')

@section('title')
	{{$voucher->title}}
@stop


@section('facebook_meta')
	<meta property="og:title" content="{{$voucher->title}}"/>
	<meta property="og:type" content="article"/>
	<meta property="og:url" content="{{url('customer/voucher/'.$voucher->id)}}"/>

	@if(!empty($voucher->img))
		<meta property="og:image" content="{{asset('voucher_img/'.$voucher->img)}}"/>
	@else
		<meta property="og:image" content="{{asset('voucher_img/default_voucher.jpg')}}"/>
	@endif	
	<meta property="og:site_name" content="Refill24"/>
	<meta property="og:description"
	      content="{{$voucher->brief_description}}"/>
@stop


@section('content')



<h2 class="icon-ticket title">Promociones / ofertas disponibles</h2>

<div class="content">
	<div class="col1">
		<div class="top">
			 @if(($voucher->finishes_at) < (date('y-m-d',time()))) <div class="alert">Esta oferta finalizó el: {{StringFormat::formatTimestampt('d/m/Y', $voucher->finishes_at)}}
		</div>
		 @elseif(!$voucher->is_active)
		<div class="alert">
			Esta oferta ya no está activa
		</div>
		 @endif 


		<h2 class="voucher-title">{{$voucher->title}}</h2>
		 <figure>
		@if(!empty($voucher->img)) 
		<img src="{{asset('voucher_img/'.$voucher->img)}}" alt="voucher image" rel="image_src"> @else <img src="{{asset('images/default_voucher.jpg')}}" alt="voucher image" rel="image_src">
		@endif 

		</figure>
		
	</div>
	<div class="bottom">
		<p>
			{{$voucher->description}}
		</p>
	</div>
	
	
</div>


<div class="col3">
	<hr>
	 @if($voucher->is_active && ($voucher->finishes_at >= date('Y-m-d',time()))) <span class="icon-timer">Comienza: {{StringFormat::formatTimestampt('d/m/Y', $voucher->starts_at)}}</span><br>
	<span class="icon-timer-full">Finaliza: {{StringFormat::formatTimestampt('d/m/Y', $voucher->finishes_at)}}</span>
	<hr>
	<a class="icon-megaphone" href="{{url('customer/recommend')}}">Recomendar a un amigo</a>
	<hr>
	<a type="button" class="btn custom" data-toggle="modal" data-target="#myModal">apuntarme</a>
	@endif
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Indícanos donde quieres recibir tus cupones...</h4>
			</div>
			<div class="modal-body">
				 {{ Form::open(array('url' => 'customer/suscription', 'method'=>'post')) }} <span class="icon-address"></span>
				{{Form::text('email',null, array('placeholder'=>'Email'))}} {{Form::hidden('voucher', $voucher->id)}}
			</div>
			<div class="modal-footer">
				 {{Form::submit('Confirmar', array('class'=>'btn primary'))}} {{Form::close()}}
			</div>
		</div>
	</div>
</div>



	<hr>
		<a href="{{url('customer/vouchers')}}">Ver otras ofertas</a>	

</div>



@stop


@section('extra-content')	
	<div id="features">
			<div class="">
				<h3 class="icon-piggy">Recarga y ahorra</h3>
				<p>
					 Refill24 te ayuda a abaratar tus impresiones sin sacrificar CALIDAD! Utilizamos material de alto rendimiento y especifico para tu impresora. Comienza a recargar tus cartuchos... comienza a Ahorrar! Precios competitivos e impresiones de calidad aseguradas!
				</p>
			</div>
			<div class="">
				<h3 class="icon-card">Tarjeta de puntos</h3>
				<p>
					 En Refill24 premiamos tu fidelidad entregandote una tarjeta de puntos, en la cual por cada cartucho de tinta que recargas recibes un punto. Completada esta tarjeta, la recarga de tu cartucho mas caro te saldra absolutamente GRATIS!.
				</p>
			</div>
			<div class="hide-m">
				<h3 class="icon-umbrella">Garantia Refill24</h3>
				<p>
					 Te damos garantia en nuestras recargas!. Si tu cartucho no imprime bien luego de una recarga lo traes y lo solucionamos. Si no funciona, te bonificamos el dinero de tu recarga sobre un cartucho nuevo o te damos una tarjeta para la recarga gratis de tu futuro cartucho. <a href="">Condiciones</a>	
				</p>
			</div>
	</div>
@stop



