@extends('backoffice')

@section('nav')
<nav>
	<ul id="breadcrumb">
		<li>Shops</li>
	</ul>
</nav>
@stop

@section('content')
	<ul class="sections">
		@foreach($shops as $shop)
			<li class="shop-list">
				<a class="icon-arrow-right" href="{{url('shop/'.$shop->id)}}">{{$shop->shop_name}}</a>
			</li>
		@endforeach
	</ul>
@stop