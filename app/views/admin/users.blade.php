@extends('backoffice')

@section('nav')
	<ul id="breadcrumb">
		<li>
			<a class="lastcrumb" href="{{{url('admin/settings')}}}">Settings</a>
		</li>
		<li>Users</li>
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
		{{$users->links()}}
	</div>
@stop

@section('content')
		<a class="icon-user-add" href="{{url('admin/user/create')}}">CREATE</a>
		<hr>

<table class="tusers">
<thead>
<tr>
	<th>
		NAME
	</th>
	<th>
		EMAIL
	</th>
	<th>
		PASSWORD
	</th>
	<th>
		IS ADMIN
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

	@foreach ($users as $user)
		<tr>
			<td>
				{{$user->user_name}}
			</td>
				
			<td>
				{{$user->email}}
			</td>
			<td>
				{{$user->friendly_password}}
			</td>
			<td>
				@if($user->is_admin)  
					<span class="icon-check"> </span>
				@else
					<span>-</span>
				@endif
			</td>
			<td>
				<a class="icon-edit" href="{{url('admin/user/edit/'.$user->id)}}">Edit</a>
			</td>

			<td><a class="icon-bin" href="{{url('admin/user/delete/'.$user->id)}}">Delete</a></td>
		</tr>
	@endforeach
	

 </tbody>
</table>

@stop
