@extends('clients.client-master')

@section('styles')
<link media="all" type="text/css" rel="stylesheet" href="{{ url('css/purchase-prints.css') }}">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
<div id="myModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
  <img id="enlarge-photo" src="" />
</div>
<div id="results_box" class="row">
	
</div>
<div class="button-container">
	<a class="button" href="{{ url('user/dashboard/orders_history') }}">Cancel</a>
	<a id="submit_order" class="button">Save</a>
</div>
<div class="row pagination-centered">
	<ul id="pagination_controls"class="pagination">
	</ul>
</div>
@stop

@section('scripts')
@include('clients.request_edit_prints_order_page')
<script src="{{ url('js/edit_prints_order.js') }}"></script>
<script src="{{ url('js/web-storage.js') }}"></script>
@stop