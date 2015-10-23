@extends('admin.admin-master')

@section('styles')
	
@stop

@section('content')
<form method="POST" action="{{ url('admin/dashboard/about') }}/{{ $about->id }}"  enctype="multipart/form-data">
	<input name="_method" type="hidden" value="PUT">
	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	<div class="row">
		<div class="medium-4 large-4 columns">
			<div class="panel">
				<label for="title">Title:
					<input name="title" type="text" value="{{ $about->title }}">
					@if ($errors->has('title')) <small class="error input-error-label">{{ $errors->first('title') }}</small> @endif
				</label>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="medium-12 large-12 columns">
			<div class="panel">
				<label for="textarea">Content:
					<textarea name="body" class="textarea-input" style="height: 300px">{{ $about->body }}</textarea>
					@if ($errors->has('body')) <small class="error input-error-label">{{ $errors->first('body') }}</small> @endif
				</label>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="medium-1 large-1 large-offset-11 columns">
			<input type="submit" class="button small right" value="Update"/>
		</div>
	</div>
</form>
@stop

@section('scripts')
	
@stop