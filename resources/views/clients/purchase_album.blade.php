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
		<li>Selected: <span id="select-counter">0</span></li>
		<li>Max: <span id="max-photos">{{$maxPhotos}}</span></li>
	</ul>
</div>
<h1>Select Photos for Album</h1>
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
@include('clients.request_album_order_page')
<script src="{{ url('js/purchase-album.js') }}"></script>
<script src="{{ url('js/web-storage.js') }}"></script>
@stop