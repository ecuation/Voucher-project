@extends('front')

@section('content')
<div class="hints">
		<p class="icon-information">Selecciona las promociones que te interesen y presiona el boton "Los quiero!" para apuntarte!</p>
		<!-- <ul>
			<li class="check-out">Promociones no seleccionadas</li>
			<li class="check-in">Promociones seleccionadas</li>
		</ul> -->
</div>
<div class="voucher-wrapper">
	<ul>
{{ Form::open(array('url' => 'customer/suscription', 'method'=>'post')) }}
	@foreach($vouchers as $this_voucher)
		@if($this_voucher->is_active == 1)
			<li class="item">
				<div class="top">

				<div class="check-in-out">
					<!-- <input type="checkbox" value="None" id="voucher" name="check" /> -->
					{{Form::checkbox('voucher[]', $this_voucher->id, null, ['class' => 'voucher-checkbox'])}}
					<label for="voucher">Apuntarme</label>
				</div>
				<figure>
						<a href="{{url('customer/voucher/'.$this_voucher->id)}}">
							@if(empty($this_voucher->img))
								<img src="{{asset('images/default_voucher.jpg')}}" alt="voucher_image">
							@else
								<img src="{{asset('voucher_img/'.$this_voucher->img)}}" alt="voucher_image">
							@endif
							
						</a>
					</figure>

					<h2><a href="{{url('customer/voucher/'.$this_voucher->id)}}" class="voucher-title">{{$this_voucher->title}}</a></h2>
				</div>
				<div class="bottom">
					<p>{{$this_voucher->brief_description}}</p>
					<hr>
					<span class="icon-timer">Comienza: {{StringFormat::formatTimestampt('d/m/Y', $this_voucher->starts_at)}}</span><br>
					<span class="icon-timer-full">Finaliza: {{StringFormat::formatTimestampt('d/m/Y', $this_voucher->finishes_at)}}</span>
					<hr>
					<a class="icon-megaphone" href="{{url('customer/recommend')}}">Recomendar a un amigo</a>
					<hr>
					<a class="btn btn-primary" href="{{url('customer/voucher/'.$this_voucher->id)}}">Learn more</a>
				</div>		
			</li>
	  	@endif
	@endforeach		
	</ul>
</div>




	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="myModalLabel">Indícanos donde quieres recibir tus cupones...</h4>
	      </div>
	      <div class="modal-body">
	        {{Form::text('email',null, array('placeholder'=>'Email'))}}
	      </div>
	      <div class="modal-footer">
	        {{Form::submit('enviar', array('class'=>'btn btn-primary'))}}
	      </div>
	    </div>
	  </div>
	</div>

	<div class="get-them">
		<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Los quiero!</button>
		
	</div>
{{ Form::close() }}

	{{ $vouchers->links() }}
	
@stop

