@extends('backoffice')

@section('nav')
	<ul id="breadcrumb">
		<li>
			<a class="lastcrumb" href="{{{url('admin/shops')}}}">Shops</a>
		</li>
		<li>
			@if($method == 'post')
				New Shop
			@elseif($method == 'put')
				Edit Shop
			@else
				Delete Shop
			@endif
		</li>
	</ul>
@stop
@section('content')

{{Form::model($shop, array('method' => $method, 'url' => 'admin/shop_process/'.$shop->id, 'id' => 'new-voucher'))}}
@unless($method == 'delete')
	{{Form::label('Shop name')}}
	{{Form::text('shop_name')}}


	<div class="msgs-userwin">
		<p class="icon-alert">Do you really want to @if($method == 'put') edit this shop @elseif($method == 'post') create a new shop @endif?</p>
		<div id="user-decisions">		
			<ul>
				<li><button class="icon-circle-check">Confirm</button></li>
				<li><a href="{{url('admin/shops')}}" class="icon-circle-cross">Cancel</a></li>
			</ul>
		
		</div>
	</div>
@else
	<div class="msgs-userwin">
		<p class="icon-alert">Do you want to delete "{{$shop->shop_name}}"?</p>
		<div id="user-decisions">		
			<ul>
				<li><button class="icon-circle-check">Confirm</button></li>
				<li><a href="{{url('admin/shops')}}" class="icon-circle-cross">Cancel</a></li>
			</ul>
		
		</div>
	</div>
@endif

{{Form::close()}}

@stop