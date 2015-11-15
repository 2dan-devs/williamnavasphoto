@extends('admin.admin-master')

@section('styles')
	<link media="all" type="text/css" rel="stylesheet" href="{{ url('css/single-portfolio.css') }}">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<!-- Popup window to add photos to album -->
<a href="#" data-reveal-id="myModal">Add Photos</a>
<div id="myModal" class="reveal-modal" data-reveal>
	<!-- lOADING iCON -->
	<div id="loading-cont"><i class="fa fa-4x fa-inverse fa-cog fa-spin"></i></div>
	<!-- End Loading Icon -->
  <div class="row">
  	<div class="medium-5 large-5 large-offset-3 column">
  		<h2>Add Photos</h2>
  	</div>
  </div>
  <form id="form_add_photos" enctype="multipart/form-data">
  <div class="row">
	<div class="medium-4 large-4 large-offset-3 column">
		<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		<input id="portfolio_album_id" name="portfolio_album_id" type="hidden" value="{{$portfolio_id}}" />
	</div>
</div>

<div class="row">
	<div class="medium-4 large-4 large-offset-3 columns">
		<label>Select Images:
			<input type="file" name="image[]" id="img-input" class="button tiny secondary error" accept="image/*" multiple/>
			<small id="file-error" class="error valid">A valid image input is required</small>
		</label>
	</div>
</div>

<br>
<div class="row">
	<div class="medium-3 large-3 large-offset-3 columns">
		<a id="submit" role="button" aria-label="submit form" href="#" class="button">Submit</a>
	</div>
</div>
</form>
  <a class="close-reveal-modal">&#215;</a>
</div>
<!-- end of Popup window to add photos to album -->

<!-- Display photos of album -->
<div class="row">
@foreach($photos as $photo)
	<div class="medium-3 large-3 column end photo-container">
		<img src="/{{$photo->photo_path}}" />
		
		<form method="POST" action="{{ url('submit/portfolio_photos') }}/{{$photo->id}}/delete" onsubmit ="return confirm('This action is NOT reversible. Are you sure to delete this photo?');">
			<input name="_method" type="hidden" value="DELETE">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="submit" class="button expand" value="Delete" />
		</form>	
	</div>
@endforeach
</div>
<div class="row">
	{!! $photos->render() !!}
</div>
@endsection

@section('scripts')
	<script src="{{ url('js/single-portfolio.js') }}"></script>
@endsection