@extends('admin.admin-master')

@section('styles')
	<link media="all" type="text/css" rel="stylesheet" href="{{ url('css/portfolio-index.css') }}">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<a href="#" data-reveal-id="myModal">Create New Portfolio Album</a>

<!-- Popup window to create a client's new album -->
<div id="myModal" class="reveal-modal" data-reveal>
    <div class="row">
	  	<div class="medium-7 large-7 large-offset-3 column">
	  		<h2>Create New Portfolio Album</h2>
	  	</div>
    </div>
  <!-- creates portfolio album by within jquery event -->
  	<form method="POST" id="portfolio_album_form" action="javascript:createPortfolioAlbum()">
	    <div class="row">
			<div class="medium-4 large-4 large-offset-3 column">
				<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
			</div>
	    </div>

		<div class="row">
			<div class="medium-3 large-3 large-offset-3 columns">
				<label>Portfolio Name:
					<input type="text" id="name" name="name" class="error" />
					<small id="name-error" class="error valid">This field is required.  Portfolio name must be between 3-25 characters long</small>
				</label>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="medium-3 large-3 large-offset-3 columns">
				<input type="submit" class="button" value="Create" />
			</div>
		</div>
	</form>
    <a class="close-reveal-modal">&#215;</a>
</div>
<!-- end of client creating new album -->
<br>
<br>
<div class="row">
@foreach ($portfolios as $portfolio)

	<div class="medium-3 large-3 column panel end">
		<label>Name: {{$portfolio->name}}</label>
		<a href="{{ url('admin/dashboard/portfolio') }}/{{$portfolio->id}}" class="button expand">View Portfolio</a>
		<form method="POST" action="{{ url('admin/dashboard/portfolio') }}/{{$portfolio->id}}" onsubmit ="return confirm('This action is NOT reversible. Are you sure to delete this portfolio?');">
			<input name="_method" type="hidden" value="DELETE">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="submit" class="button expand" value="Delete Portfolio" />
		</form>
	</div>

@endforeach
</div>
@endsection

@section('scripts')
	<script src="{{ url('js/create_portfolio.js') }}"></script>
@endsection