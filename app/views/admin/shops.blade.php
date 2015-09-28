@extends('backoffice')

@section('nav')
	<ul id="breadcrumb">
		<li>
			<a class="lastcrumb" href="{{{url('admin/settings')}}}">Settings</a>
		</li>
		<li>Shops</li>
	</ul>
@stop

@section('results_per_page')
	<div class="pagination-options cf">
		<ul>
			<li>Display</li>
			<li><a href="{{URL::current()}}?results=5">5</a></li>	
			<li><a href="{{URL::current()}}?results=10">10</a></li>
			<li><a href="{{URL::current()}}?results=15">15</a></li>
			<li><a href="{{URL::current()}}?results=100">100</a></li>
		</ul>
	</div>
@stop

@section('pagination')
	<div class="Zebra_Pagination cf">
		{{$shops->links()}}
	</div>
@stop

@section('content')
<a class="icon-add-new-marker" href="{{url('admin/shop/create')}}">CREATE</a>
<hr>
<table class="tshops">
<thead>
<tr>
	<th>
		SHOP
	</th>
	<th>
		EDIT
	</th>
	<th>
		DELETE
	</th>
</tr>
</thead>
<tbody>

	@foreach ($shops as $shop)
		<tr>
			<td>
				{{$shop->shop_name}}
			</td>
			<td>
				<a class="icon-edit" href="{{url('admin/shop/edit/'.$shop->id)}}">Edit</a>
			</td>
			<td>
				<a class="icon-bin" href="{{url('admin/shop/delete/'.$shop->id)}}">Delete</a>
			</td>
		</tr>
	@endforeach
 </tbody>
</table>

@stop
