@extends('clients.client-master')

@section('styles')
<link media="all" type="text/css" rel="stylesheet" href="{{ url('css/purchase-prints.css') }}">
@stop

@section('content')
<input id="csrf-token" type="hidden" value="{{csrf_token()}}" />
<input id="itemsPerPage" type="hidden" value="{{$itemsPerPage}}">
<input id="lastPage" type="hidden" value="{{$last}}">
<input id="albumID" type="hidden" value="{{$albumID}}">
<input id="orderID" type="hidden" value="{{$orderID}}">
<div id="myModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
  <img id="enlarge-photo" src="" />
</div>
<div id="results_box" class="row">

</div>
<div class="button-container">
  @if($orderID!=='')
    <a class="button" href="{{url('user/dashboard/orders_history')}}">Cancel</a>
    <a id="submit_order" class="button">Save</a>
  @else
    <a id="submit_order" class="button">Submit</a>
  @endif
</div>
<div class="row pagination-centered">
	<ul id="pagination_controls" class="pagination">
	</ul>
</div>
@stop

@section('scripts')
<script src="{{ url('js/pubsub.js') }}"></script>
<script src="{{ url('js/web-storage.js') }}"></script>
<script src="{{ url('js/gallery.js') }}"></script>
<script src="{{ url('js/prints-gallery.js') }}"></script>
<script src="{{ url('js/prints-order.js') }}"></script>
<script src="{{ url('js/gallery-paginator.js') }}"></script>
@stop
