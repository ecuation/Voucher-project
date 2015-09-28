@extends('backoffice')

@section('nav')
	<ul id="breadcrumb">
		<li>
			<a class="lastcrumb" href="{{{url('shops')}}}">Shops</a>
		</li>
		<li>Shop</li>
	</ul>
@stop

@section('results_per_page')
	<div class="pagination-options cf">
		<ul>
			<li>Display <a href="{{url('orderBy')}}">
				@if(Session::get('orderBy') == 'asc') 
					<span class="icon-arrow-desc"></span> 
				@elseif(Session::get('orderBy') == 'desc') 
					<span class="icon-arrow-asc"></span>  
				@else 
					<span class="icon-arrow-asc"></span> 
				@endif </a></li>
			<li><a href="{{URL::current()}}?results=5">5</a></li>	
			<li><a href="{{URL::current()}}?results=10">10</a></li>
			<li><a href="{{URL::current()}}?results=15">15</a></li>
			<li><a href="{{URL::current()}}?results=100">100</a></li>
		</ul>
	</div>
@stop


@section('pagination')
	<div class="Zebra_Pagination cf">
		{{$suscriptions->links()}}
	</div>
@stop


@section('content')

<p class="icon-information"> Ultima búsqueda realizada:</p>
<ul>
 <li>CODIGO: <span class="txt-spotlight">{{ ($oldValues['code']) }}</span></li>
 <li>STATUS: <span class="txt-spotlight"> @if($oldValues['is_active'] == 1) <span class="icon-check"></span> @else <span>-</span> @endif </span></li>
 <li>CAMPAÑA: <span class="txt-spotlight">{{ ($oldValues['title']) }}</span></li>
 <li>CLIENTE: <span class="txt-spotlight">{{ ($oldValues['customer_name']) }}</span></li>
 <li>EMAIL: <span class="txt-spotlight">{{ ($oldValues['email']) }}</span></li>
 <li>EXCHANGED: <span class="txt-spotlight"> @if($oldValues['is_used'] == 1) <span class="icon-check"></span> @else <span>-</span> @endif </span></li>
 <li>REUSES: <span class="txt-spotlight">{{ ($oldValues['reuses']) }}</span></li>
</ul>

<table class="tm">
<thead>
<tr>
	<th>
		CODIGO
	</th>
	<th>
		STATUS
	</th>
	<th>
		NOTA
	</th>
	<th>
		CAMPAÑA
	</th>
	<th>
		CLIENTE
	</th>
	<th>
		EMAIL
	</th>
	<th>
		CANJEADO
	</th>
	<th>
		REUSES
	</th>
	<th>
		Buscar
	</th>
</tr>
</thead>
<tbody>
<tr class="search-row">
	{{Form::model($shop, array('url' => 'shop/'.$shop->id, 'id' => 'searcher'))}}
		<td>{{Form::text('code')}}</td>
		<td>
			{{Form::hidden('is_active', 0)}}
			
			@if($oldValues['is_active'] == 1)
				{{Form::checkbox('is_active', 1, null, array('class'=>'is_admin', 'checked' => 'checked'))}}
			@else
				{{Form::checkbox('is_active', 1, null, array('class'=>'is_admin'))}}
			@endif
		</td>
		<td>field non filterable</td>
		<td>{{Form::text('title')}}</td>
		<td>{{Form::text('customer_name')}}</td>
		<td>{{Form::text('email')}}</td>
		<td>
			{{Form::hidden('is_used', 0)}}
			
			@if($oldValues['is_used'] == 1)
				{{Form::checkbox('is_used', 1, null, array('class'=>'is_admin', 'checked' => 'checked'))}}
			@else
				{{Form::checkbox('is_used', 1, null, array('class'=>'is_admin'))}}
			@endif
		</td>
		<td>
			{{Form::text('reuses')}}
		</td>

		<td class="searcher">
			<span class="icon-search"></span>
			{{Form::submit('', array('name'=>'search'))}}
		</td>
	{{Form::close()}}
</tr>
@foreach($suscriptions as $suscription)
	 <tr>
	 	@if(($suscription->finishes_at) < (date('Y-m-d',time())) || (!$suscription->is_active))
	 		<?php $color="#E84C3D"; ?>
	 	@elseif( ($suscription->starts_at) > (date('Y-m-d',time())) )	
	 		<?php $color="#fed163"; ?>
	 	@else
	 		<?php $color="#2CCB70"; ?>
	 	@endif
			<td style="color:{{$color}};">
				{{$suscription->voucher_code}}
				<small>{{StringFormat::formatTimestampt('d/m/Y', $suscription->starts_at)}}
				{{StringFormat::formatTimestampt('d/m/Y', $suscription->finishes_at)}}</small>
			</td>
			<td>
	 	@if(($suscription->finishes_at) < (date('Y-m-d',time())) || (!$suscription->is_active))
	 		Inactivo
	 	@elseif( ($suscription->starts_at) > (date('Y-m-d',time())) )	
	 		Pendiente
	 	@else
	 		Activado
	 	@endif
				
			</td>
			<td class="txt-left">
				{{str_limit($suscription->note, $limit = 120, $end = '...')}}
			</td>
			<td class="txt-left">
				{{$suscription->title}}
			</td>
			<td>			
				{{Form::input('text', 'customer_name', $suscription->customer_name, array('class' => 'name', 'id'=>$suscription->customer_id))}}
			</td>
			<td>
				{{$suscription->email}}
			</td>
			<td>
				@if($suscription->is_used)
					<input type="checkbox" value="0" checked="checked" id="{{$suscription->id}}" class="uses">
				@else
					<input type="checkbox" value="1" id="{{$suscription->id}}" class="uses">
				@endif
			</td>
			<td>
				<input type="number" value="{{$suscription->reuses}}" class="reuses" id="{{$suscription->id}}" min="0">
			</td>
			<td>
				&nbsp;
			</td>
	</tr>

@endforeach
 </tbody>
</table>
<script>
	//customer name editor
	var nameEditor = new InputEditor('.name',"{{url('customer/edit_name')}}");
	nameEditor.init();

	//reuses qty editor
	var qtyEditor = new InputEditor('.reuses',"{{url('suscription/edit_reuses')}}");
	qtyEditor.init();

	//uses
	var uses = new CheckboxAjax('.uses', "{{url('suscription/edit_uses')}}");
	uses.start();
</script>
@stop