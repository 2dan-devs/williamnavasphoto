@extends('clients.client-master')

@section('styles')
	<link media="all" type="text/css" rel="stylesheet" href="{{ url('css/client-dashboard.css') }}">
@endsection

@section('content')
<!-- Title from View -->
<h1 class="welcome-message">Welcome: {{ $client->first_name.' '.$client->last_name }}</h1>
<h3><b>Your Account Albums</b></h3>
<div id="row-container" class="row full-width">
	@foreach ($albums as $album)
		<div class="large-4 medium-4 columns album-container end">
			<h3 class="album-title">{{ $album->album_name }}</h3>
			<img src="/{{ $album->album_cover_photo }}" />
			<ul class="stack button-group">
			  <li><a href="{{ url('user/dashboard/purchase_album/'.$album->id) }}" class="button">Order Album</a></li>
			  <li><a href="{{ url('user/dashboard/purchase_prints/'.$album->id) }}" class="button">Order Prints</a></li>
			</ul>
		</div>
	@endforeach
</div>
<div class="row">
	<div class="small-3 small-centered columns">
	  	{!! $albums->render() !!}
	</div>
</div>
@endsection

@section('scripts')
@endsection
