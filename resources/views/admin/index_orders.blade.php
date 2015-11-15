@extends('admin.admin-master')

@section('styles')
	<link media="all" type="text/css" rel="stylesheet" href="{{ url('css/index-orders.css') }}">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
	<div class="row">
		<h2 class="table-name">Pending Orders</h2>
		<div class="pending-order-container panel">
			<table>
				<tr>
				    <th>Name</th>
				    <th>Order Type</th> 
				    <th>Create At</th>
				    <th>Status</th>
				    <th></th>
				</tr>
				
				@foreach($pendingOrders as $order)
				<tr>
					<td>{{$order->client->first_name.' '.$order->client->last_name}}</td>
					<td>{{$order->type}}</td>
					<td>{{$order->created_at}}</td>
					<td><select id="{{ $order->id }}">
						  <option value="In Progress" selected>In Progress</option>
						  <option value="Canceled">Canceled</option>
						  <option value="Completed">Completed</option>
						</select>
					</td>
					<td>
						<form method="POST" action="{{ url('admin/dashboard/orders/download') }}"  enctype="multipart/form-data">
							<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
							<input type="hidden" name="orderID" value="{{$order->id}}">
							<input type="submit" class="button" value="Download"></td>
						</form>
				</tr>
				@endforeach
				
			</table>
		</div>
	</div>
	<div class="row">
	<h2 class="table-name">Completed/Canceled Orders</h2>
		<div class="nonpending-order-container panel">			
			<table>
				<tr>
				    <th>Name</th>
				    <th>Order Type</th> 
				    <th>Create At</th>
				    <th>Status</th>
				    <th></th>
				</tr>
				
				@foreach($nonPendingOrders as $order)
				<tr>
					<td>{{$order->client->first_name.' '.$order->client->last_name}}</td>
					<td>{{$order->type}}</td>
					<td>{{$order->created_at}}</td>
					<td><select id="{{$order->id}}">
						  <option value="In Progress">In Progress</option>
						  <option value="Canceled" @if(strcmp($order->status,'Canceled') == 0) {{'selected'}} @endif>Canceled</option>
						  <option value="Completed" @if(strcmp($order->status,'Completed') == 0) {{'selected'}} @endif>Completed</option>
						</select>
					</td>
					<td>
						<form method="POST" action="{{ url('admin/dashboard/orders/download') }}"  enctype="multipart/form-data">
							<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
							<input type="hidden" name="orderID" value="{{$order->id}}">
							<input type="submit" class="button" value="Download"></td>
						</form>
					</td>
				</tr>
				@endforeach
				
			</table>
		</div>
	</div>
@stop

@section('scripts')
	<script src="{{ url('js/index-orders.js')}}"></script>
@stop