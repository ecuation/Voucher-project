@extends('front')

@section('title')
	Vouchers
@stop

@section('facebook_meta')
	<meta property="og:title" content="Promociones Refill24"/>
	<meta property="og:type" content="website"/>
	<meta property="og:url" content="{{url('customer/vouchers')}}"/>
	<meta property="og:image" content="{{asset('images/refill24-logo.svg')}}"/>
	<meta property="og:site_name" content="Refill24"/>
	<meta property="og:description" content="Cupones de descuento Refill24."/>
	@stop
@section('content')
    <h2 class="icon-ticket title">Promociones / ofertas disponibles</h2>
  
<aside class="aside aside-info">
  <h3 class="titles icon-magic-wand">Como funciona</h3>
  <p>Para apuntarte marca las casillas <span class="icon-cursor-select-area"></span> de las ofertas que te interesen y luego presiona <a data-target="#myModal" data-toggle="modal" class="btn custom" type="button">Apuntarme</a></p> 
</aside>
<article class="coupons-wrapper">
{{ Form::open(array('url' => 'customer/suscription', 'method'=>'post')) }}

		<ul id="Grid">
			@foreach($vouchers as $this_voucher)
				@if($this_voucher->is_active == 1)
				<li class="item">
					<div class="top">
						<div class="check-in-out">
							{{Form::checkbox('voucher[]', $this_voucher->id, null, ['class' => 'voucher-checkbox'])}}
							<label for="voucher"><!-- Apuntarme --></label>
						</div>


						<h2><a href="{{url('customer/voucher/'.$this_voucher->id)}}" class="voucher-title">{{$this_voucher->title}}</a></h2>
					</div>
					<div class="bottom">

						<span class="icon-timer">Comienza: {{StringFormat::formatTimestampt('d/m/Y', $this_voucher->starts_at)}}</span><br>
						<span class="icon-timer-full">Finaliza: {{StringFormat::formatTimestampt('d/m/Y', $this_voucher->finishes_at)}}</span>
						<hr>
						<a class="icon-megaphone" href="{{url('customer/recommend')}}">Recomendar a un amigo</a>
						<hr>
						<a class="btn primary" href="{{url('customer/voucher/'.$this_voucher->id)}}">+ informacion</a>
					</div>
				</li>
		  	@endif
			@endforeach	
			<li class="placeholder"></li>
		</ul>	

		  <hr>
		  	<!--<a href="{{url('customer/vouchers')}}">volver a mis cupones</a>-->
		  <a data-target="#myModal" data-toggle="modal" class="btn custom" type="button">Apuntarme</a>

		</article>
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title" id="myModalLabel">Donde quieres recibir tus cupones?</h3>
					</div>
					<div class="modal-body">
						{{Form::text('email',null, array('placeholder'=>'Email'))}}
					</div>
					<div class="modal-footer">
						{{Form::submit('Confirmar', array('class'=>'btn primary'))}}
					</div>
				</div>
			</div>
		</div>

{{ Form::close() }}
@stop


@section('extra-content')
	<div id="participants">
		<ul>
	        <li><h3 class="icon-favorite-marker">Tiendas adheridas</h3>
	            <ul>
	                <li>Archiduque Carlos, 125</li>
	                <li>Peris y Valero, 93</li>
	                <li>Bailen, 44</li>
	                <li>Cardenal Benlloch, 7</li>
	            </ul>  
	        </li>  
	    </ul>
	</div>
	  


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