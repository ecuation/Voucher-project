@extends('front')

@section('error')
	@if(($voucher->finishes_at) < (date('Y-m-d',time())))
		<p class="alert alert-danger">Esta oferta finalizó el: {{StringFormat::formatTimestampt('d/m/Y', $voucher->finishes_at)}}</p>
	@elseif(!$voucher->is_active)
		<p class="alert alert-danger">Esta oferta ya no está activa</p>
	@endif
@stop

@section('content')
	<h2>{{$voucher->title}}</h2>
	@if(!empty($voucher->img))
		<img src="{{asset('voucher_img/'.$voucher->img)}}" alt="voucher image">
	@else
		<img src="{{asset('images/default_voucher.jpg')}}" alt="voucher image">
	@endif
	<p><strong>Descripción:</strong> {{$voucher->description}}</p>

	@if($voucher->is_active)
		<p>Empieza: {{StringFormat::formatTimestampt('d/m/Y', $voucher->starts_at)}}</p>
		<p>Termina: {{StringFormat::formatTimestampt('d/m/Y', $voucher->finishes_at)}}</p>
	@endif
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="myModalLabel">Indícanos donde quieres recibir tus cupones...</h4>
	      </div>
	      <div class="modal-body">
	      	{{ Form::open(array('url' => 'customer/suscription', 'method'=>'post')) }}
	        {{Form::text('email',null, array('placeholder'=>'Email'))}}
	        {{Form::hidden('voucher[]', $voucher->id)}}
	      </div>
	      <div class="modal-footer">
	        {{Form::submit('enviar', array('class'=>'btn btn-primary'))}}
	        {{Form::close()}}
	      </div>
	    </div>
	  </div>
	</div>
	<a href="{{url('customer/vouchers')}}">Ver otras ofertas</a>
	@if( ($voucher->finishes_at >= date('Y-m-d',time())) && $voucher->is_active)
		<div class="get-them">
			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Lo quiero!</button>
		</div>
	@endif
@stop




