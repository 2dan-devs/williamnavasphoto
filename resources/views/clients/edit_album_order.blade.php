@extends('clients.client-master')

@section('styles')
<link media="all" type="text/css" rel="stylesheet" href="{{ url('css/purchase-album.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
<div id="myModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
  <img id="enlarge-photo" src="" />
</div>
<div class="photo-counter">
	<ul>
		<li>Selected: <span id="select-counter">{{$amtSelected}}</span></li>
		<li>Max: <span id="max-photos">{{$maxPhotos}}</span></li>
	</ul>
</div>
<h1>Select Photos for Album</h3>
<div id="results_box" class="row">
	
</div>
<div class="button-container">
	<a class="button" href="{{url('user/dashboard/orders_history')}}">Cancel</a>
	<a id="submit_order" class="button">Save</a>
</div>
<div class="row pagination-centered">
	<ul id="pagination_controls"class="pagination">
	</ul>
</div>
@stop

@section('scripts')
@include('clients.request_edit_album_order_page')
<script src="{{ url('js/edit_album_order.js') }}"></script>
<script src="{{ url('js/web-storage.js') }}"></script>
@stop