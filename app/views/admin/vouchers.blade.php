@extends('backoffice')

@section('nav')
	<nav>
		<ul id="breadcrumb">
		    <li><a class="lastcrumb" href="{{{url('admin/panel')}}}">Main</a></li>
			<li>My Vouchers</li>
		</ul>
	</nav>
@stop


@section('current_page')
	<h2 class="section-name">My Vouchers</h2>
@stop

@section('interest_info')
	<!-- session date -->
	<div class="session-date">
		<span>Monthly info</span>
	</div>
	<!-- Actual info -->
	<div class="month_info">
		<ul>
			@foreach($activity as $value)
				<li>Apuntados: {{ $value->total }}</li>
				<li>Utilizados: {{ $value->total_used }}</li>
				<li>Pendientes:  {{ $value->total - $value->total_used }} </li>
				<li>Reutilizados: {{$value->total_reuses}}</li>
			@endforeach
		</ul>
	</div>
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
		{{$vouchers->links()}}
	</div>
	
@stop

@section('content')

	@foreach($vouchers as $voucher)
		<div class="vouchers-grid cf">
			<!-- vouchers-grid -->
			<div class="status-color"
				@if(($voucher->finishes_at) < (date('Y-m-d',time())) || (!$voucher->is_active))
			 		style="background:#E84C3D;"
			 	@elseif( ($voucher->starts_at) > (date('Y-m-d',time())) )	
			 		style="background:#fed163;"
			 	@else
			 		style="background:#2CCB70;"
			 	@endif
			 >
			</div>

			<div class="position-time">
				<span class="position">{{$voucher->id}}</span>
			</div>
            
            <div class="voucher-data">
                <span class="voucher-title">{{$voucher->title}}</span><br>
                    <div class="voucher-details cf">
                        <span>
                        	{{$voucher->brief_description}}
                        </span>
                        @if(Auth::user()->is_admin)
                            <div class="voucher-note">      
                            	<span class="icon-chat-bubble small-icon"></span>
                            	<textarea id="{{$voucher->id}}" class="note animated txt-alert" placeholder="...">{{$voucher->note}}</textarea>
                            </div>
                        @else
                            <div class="voucher-note">      
                            	<span class="icon-chat-bubble small-icon"></span>
                            	<span class="note txt-alert">@if(empty($voucher->note))...  @else {{$voucher->note}} @endif</span>
                            </div>
                        @endif
                    </div>
            </div>


			<div class="details">

				<span class="icon-calendar">Creado: {{StringFormat::formatTimestampt('d/m/Y (H:m)', $voucher->created_at)}}</span>
				<br>
                <span class="icon-code">Code: <span class="voucher-code">{{{$voucher->voucher_code}}}</span></span>
				
		        <hr>
	
				<span class="icon-timer">Comienza: {{StringFormat::formatTimestampt('d/m/Y', $voucher->starts_at)}}</span><br>
				<span class="icon-timer-full">Termina: {{StringFormat::formatTimestampt('d/m/Y', $voucher->finishes_at)}}</span>
                
                <hr>

				<span class="icon-database">Database: </span>
				@if($voucher->sended_through_db)  
					<span class="icon-check"> </span>
				@else
					<span>-</span>
				@endif
				<br>
				<span class="icon-outbox">Mailing box: </span>
				@if($voucher->sended_through_mailing_box)  
					<span class="icon-check"> </span> 
				@else
					<span>-</span>
				@endif

			</div>

		    <hr class="show-m">

		    <div class="details">
		    	<span class="icon-contacts">Apuntados: {{$voucher->suscribed}}</span> <br>
				<span class="icon-user-checked">Utilizados: {{$voucher->total_used}}</span> <br>
				<span class="icon-alarm-snooze">Pendientes: {{$voucher->suscribed - $voucher->total_used}}</span> <br>
		    	<span class="icon-user-star">Reutilizados: {{$voucher->reuses}}</span>
			</div>


			<div class="commands">
            @if(Auth::user()->is_admin)
	            <ul id="commands-list">
	            	<li> <a class="icon-preview command-btn" href="{{url('admin/firstPreview/'.$voucher->id)}}" target="_blank" title="Preview the Voucher"></a></li>
	                <li> <a class="icon-edit command-btn" href="{{url('admin/voucher/edit/'.$voucher->id)}}" title="Edit the Voucher"></a></li>
	                <li> <a class="icon-alarm-line command-btn"  href="{{url('admin/reminder/'.$voucher->id)}}" title="Send reminders to users who have not yet used their voucher"></a></li>
	                <li> <a class="icon-bin command-btn" href="{{url('admin/delete/'.$voucher->id)}}" title="Delete the Voucher"></a></li>
	            </ul>
            @else
	            <ul id="commands-list">
	            	<li> <a class="icon-preview command-btn" href="{{url('admin/firstPreview/'.$voucher->id)}}" target="_blank" title="Previsualizar voucher"></a></li>
	            </ul>

			@endif
			</div>
		</div>
        
	@endforeach

	<script>
		$(function(){
			$('.animated').autosize();

			$(".icon-alarm-line").on("click", function(e) {
			    var link = this;

			    e.preventDefault();

			    var question = confirm('Send a reminder to users who have not yet used this voucher?');

			    if(question)
			    	 window.location = link.href;
			});
		});
		//customer name editor
		var noteEditor = new InputEditor('.note',"{{url('admin/update_note')}}");
		noteEditor.init();
	</script>

@stop