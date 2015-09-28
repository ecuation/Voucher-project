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

{{ Form::open(array('url' => 'customer/suscription', 'method'=>'post')) }}

	<h2 class="icon-ticket title">Promociones / ofertas disponibles</h2>

	<!-- <div class="hints">
		<aside>
			<p class="icon-information hint-title">FUNCIONAMIENTO</p>				
			<ul class="hint-data">
				<li>Selecciona las promociones que te interesen y presiona el boton "Apuntarme" para apuntarte!</li>
				<li>Para detalles y condiciones de cada promocion presiona el boton "+ informacion".</li>
				
			</ul>	
		</aside>
	</div> -->

	<div class="voucher-wrapper">
		<ul>
				@foreach($vouchers as $this_voucher)
					@if($this_voucher->is_active == 1)
				<li class="item">
					<div class="top">
						<div class="check-in-out">
							{{Form::checkbox('voucher[]', $this_voucher->id, null, ['class' => 'voucher-checkbox'])}}
							<label for="voucher">Apuntarme</label>
						</div>

							<!--<figure>
									<a href="{{url('customer/voucher/'.$this_voucher->id)}}">
										@if(empty($this_voucher->img))
											<img src="{{asset('images/default_voucher.jpg')}}" alt="voucher_image">
										@else
											<img src="{{asset('voucher_img/'.$this_voucher->img)}}" alt="voucher_image">
										@endif
									</a>
							</figure> -->

						<h2><a href="{{url('customer/voucher/'.$this_voucher->id)}}" class="voucher-title">{{$this_voucher->title}}</a></h2>
					</div>
					<div class="bottom">
						<hr>
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

				<hr>
				Para apuntarte selecciona las ofertas que te interesen y presiona 
				<a type="button" class="btn custom" data-toggle="modal" data-target="#myModal">Finalizar</a>
		</ul>
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
						<h3 class="modal-title" id="myModalLabel">Donde quieres recibir tus cupones?</h3>
					</div>
					<div class="modal-body">
					<span class="icon-address"></span>
					{{Form::text('email',null, array('placeholder'=>'Email'))}}
					</div>
						<div class="modal-footer">
							{{Form::submit('Confirmar', array('class'=>'btn primary'))}}

						</div>
					</div>
				</div>
			</div>
		</div>
{{ Form::close() }}
@stop


@section('extra-content')
	<div id="spotlights">
		<section>
		<h2>Have a business?. Flexible pricing. <a href="">Subscribe today</a>.</h2>
		</section>
	</div>


	<div id="features" class="blocks">
		<div class="">
			<h3 class="icon-piggy title">RECARGA Y AHORRA</h3>
			<p>
				 Siempre fieles a nuestros clientes, Refill24 te ayuda a abaratar tus impresiones sin sacrificar CALIDAD! Utilizamos material de alto rendimiento y especifico para tu impresora. Comienza a recargar tus cartuchos...comienza a Ahorrar! Precios competitivos e impresiones de calidad aseguradas!
			</p>
		</div>
		<div class="">
			<h3 class="icon-card title">TARJETA DE PUNTOS</h3>
			<p>
				 En Refill24 premiamos la fidelidad de nuestros clientes entregandoles una tarjeta de puntos, en la cual por cada cartucho de tinta que traigas a recargar obtendras un punto. Completada esta tarjeta, la recarga de tu cartucho mas caro te saldra absolutamente GRATIS!.
			</p>
		</div>
		<div class="hide-m">
			<h3 class="icon-umbrella title">GARANTIA REFILL24</h3>
			<p>
				 Te damos garantia en nuestras recargas!. Si tu cartucho no imprime bien luego de una recarga lo traes y lo solucionamos. Si no funciona, te bonificamos el dinero de tu recarga sobre un cartucho nuevo o te damos una tarjeta para la recarga gratis de tu futuro cartucho. <a href="">Condiciones</a>	
			</p>
		</div>
	</div>
@stop