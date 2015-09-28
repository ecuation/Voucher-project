@extends('backoffice')

@section('nav')
	<ul id="breadcrumb">
		<li>
			<a class="lastcrumb" href="{{{url('admin/panel')}}}">Main</a>
		</li>
		<li>New Voucher</li>
	</ul>
@stop

@section('content')
	<div class="hints">
		<p class="icon-information">Important:</p>
		<ul>
			<li>Recommended sizes for images (Width-Height): Min 350x263px and Max 750x526px</li>
			<li>If a voucher with data stored is deleted, statistics wont be precise</li>
		</ul>
	</div>

	<div class="voucher-form">

	{{Form::model($voucher, array('method' => $method, 'url' => 'admin/voucher_process/'.$voucher->id, 'files' => true, 'id'=>'new-voucher'))}}
        @unless($method == 'delete')
			{{Form::label('Title:')}}
			{{Form::text('title')}}
		
			{{Form::label('Short description:')}}
			{{Form::textarea('brief_description', null, array('class'=>'animated2', 'cols'=>0, 'rows'=>0))}}

			{{Form::label('Description (It will be shown in the detailed view in Front office):')}}
			{{Form::textarea('description', null, array('class'=>'animated2','cols'=>0, 'rows'=>0))}}

			{{Form::label('Note:')}}
			{{Form::textarea('note', null, array('class'=>'animated2','cols'=>0, 'rows'=>0))}}

		<hr>
		<div class="input-daterange input-group" id="datepicker">
			<!-- <span>Duration:</span> -->
			{{Form::text('starts_at', null, array('class'=>'input-sm form-control', 'placeholder'=>'starts'))}}

			<span class="input-group-addon">to</span>
			{{Form::text('finishes_at', null, array('class'=>'input-sm form-control', 'placeholder'=>'finishes'))}}
		</div>
		<hr>
			{{Form::label('Add image:')}}
			<!-- <span>Recommended sizes (Width-Height): Min 350x263px and Max 750x526px</span> -->
		<br>
			{{Form::file('img')}}

<hr>
			{{Form::label('Send emails?')}}
			<input type="checkbox" name="sended_through_db" value="1" class="sended_db">
<hr>
			{{Form::label('Active:')}}
			{{Form::checkbox('is_active', 1, null, array('class'=>'is_active'))}}
<hr>

			{{Form::label('Mailing box:')}}
            {{Form::textarea('mailing_box', null, array('class'=>'animated2','cols'=>0, 'rows'=>0))}}
		
		<hr><br><br>
		<div id="user-decisions">
			<ul>
				<li><button class="icon-circle-check">Confirm</button></li>
				<li><a href="{{url('admin/vouchers')}}" class="icon-circle-cross">Cancel</a></li>
				<li><a href="{{URL::current()}}" class="icon-repeat">Reset</a></li>
			</ul>
		</div>
		<br><br><br>

	<script>
		$(function(){
			$('.animated2').autosize();
		});
	</script>

<script>
	$('.input-daterange').datepicker({
	    format: "yyyy-mm-dd",
	    calendarWeeks: true,
	    todayHighlight: true
	});

	$(document).ready(function(){
		$('form').on( "submit", function(){
			if($('.is_active').is(':checked') == false){
				var confirmation = confirm('El Voucher estara desactivado, desea continuar?');
			}else{
				return true;
			}

			if(confirmation){
				return true;
			}else{
				return false;
			}
				
		})
	});
</script>

@else
	<div class="msgs-userwin">
		<p class="icon-alert">Do you really want to delete this voucher?</p>
		<div id="user-decisions">		
			<ul>
				<li><button class="icon-circle-check">Confirm</button></li>
				<li><a href="{{url('admin/vouchers')}}" class="icon-circle-cross">Cancel</a></li>
			</ul>
		
		</div>
	</div>
@endif

	{{Form::close()}}

	</div>
@stop