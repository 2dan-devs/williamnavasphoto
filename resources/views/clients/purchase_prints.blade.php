@extends('clients.client-master')

@section('styles')
<link media="all" type="text/css" rel="stylesheet" href="{{ url('css/purchase-prints.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
<div id="myModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
  <img id="enlarge-photo" src="" />
</div>
<div id="results_box" class="row">
	
</div>
<div class="button-container">
	<a id="submit_order" class="button">Submit Order</a>
</div>
<div class="row pagination-centered">
	<ul id="pagination_controls" class="pagination">
	</ul>
</div>
@stop

@section('scripts')
@include('clients.request_prints_order_page')
<script src="{{ url('js/purchase-prints.js') }}"></script>
<script src="{{ url('js/web-storage.js')}} "></script>
@stop