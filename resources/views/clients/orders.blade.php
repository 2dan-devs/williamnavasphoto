@extends('clients.client-master')

@section('styles')
<link media="all" type="text/css" rel="stylesheet" href="{{ url('css/client-orders.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
<h1>Your Orders</h1>

	@foreach($allOrders as $order)
	<div class="row order-row">
		<div class="medium-4 large-4 columns">
			<h4>{{$order->type}} - {{$order->status}}</h4>
			<img src="/{{$order->album->album_cover_photo}}" />
			<ul>
				<li>Order Date: {{date("M d, Y",strtotime($order->created_at))}}</li>
			</ul>
		</div>
		<div class="large-offset-6 medium-2 large-2 columns">
			<!--  If order is in progress and less then 3 days old then create cancel and view/edit buttons-->
			@if($order->status === 'In Progress' && floor((time() - strtotime($order->created_at))/(60*60*24)) <= 3)
				<br><br><br>
				<a class="button" onclick="return confirm('Are you sure you want to Cancel this oder')" href="{{ url('user/dashboard/orders_history') }}/{{$order->id}}/cancel">Cancel Order</a>
				<br><br>
				<a class="button" href="{{ url('user/dashboard/orders_history') }}/{{$order->id}}/edit">View/Edit Order</a>
				<br>
			@endif
		</div>
	</div>
	@endforeach


@stop

@section('scripts')
@stop