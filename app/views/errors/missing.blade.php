@extends('front')

@section('content')

<h2 class="icon-link-broken title">Ooops.. error 404</h2>

<div class="content">

<p>Sorry, the page you were looking for doesn’t exist.</p>

<p>Go back to <a href="http://www.refill24.com">refill24.com</a> or <a href="{{url('contact')}}">contact us about</a> a problem.</p>

</div>


@stop