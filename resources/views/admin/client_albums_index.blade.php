@extends('admin.admin-master')

@section('styles')
	<link media="all" type="text/css" rel="stylesheet" href="{{ url('css/client-albums-index.css') }}">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<a href="#" data-reveal-id="myModal">Create New Album</a>

<!-- Popup window to create a client's new album -->
<div id="myModal" class="reveal-modal" data-reveal>
  	<div class="row">
	  	<div class="medium-5 large-5 large-offset-3 column">
	  		<h2>Create new Album</h2>
	  	</div>
  	</div>
	<form id="form_client_album" onsubmit="submitAlbum()">
	  	<div class="row">
			<div class="medium-4 large-4 large-offset-3 column">
				<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
				<input id="client_id" name="client_id" type="hidden" value="{{$id}}" />
				<img id="preview-holder" src="#" alt="preview" />
			</div>
		</div>

		<div class="row">
			<div class="medium-4 large-4 large-offset-3 columns">
				<label>Album Cover Photo:
					<input type="file" name="album_cover_photo" id="img-input" class="button tiny secondary error" accept="image/*" />
					<small id="file-error" class="error valid">A valid image input is required</small>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="medium-3 large-3 large-offset-3 columns">
				<label>Album Name:
					<input type="text" id="album_name" name="album_name" class="error" />
					<small id="name-error" class="error valid">This field is required.  Album name must be between 3-25 characters long</small>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="medium-3 large-3 large-offset-3 columns">
				<label>Max Client Photo Selection:
					<input id="photo_selection_max" type="text" name="photo_selection_max" class="error" />
					<small id="max-error" class="error valid">This field is required</small>
				</label>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="medium-3 large-3 large-offset-3 columns">
				<input type="submit" id="submit" class="button" value="Create" />
			</div>
		</div>
	</form>
	<a class="close-reveal-modal">&#215;</a>
</div>
<!-- end of client creating new album -->
<br>
<br>
<div id="albums-container" class="row">
@foreach ($albums as $album)

	<div class="medium-3 large-3 column panel end">
		<img src="/{{$album->album_cover_photo}}" />
		<label>Name: {{$album->album_name}}</label>
		<label>Selection Max: {{$album->photo_selection_max}}</label>
		<a href="{{ url('admin/dashboard/clients') }}/{{$id}}/albums/{{$album->id}}" class="button expand">View Album</a>
		<form method="POST" action="{{ url('admin/dashboard/clients') }}/{{$id}}/albums/{{$album->id}}" onsubmit ="return confirm('This action is NOT reversible. Are you sure to delete this record?');">
			<input name="_method" type="hidden" value="DELETE">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="submit" class="button expand" value="Delete Album" />
		</form>	
	</div>

@endforeach
</div>
@endsection

@section('scripts')
	<script src="{{ url('js/create_client_album.js') }}"></script>
@endsection