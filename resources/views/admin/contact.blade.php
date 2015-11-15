@extends('admin.admin-master')

@section('styles')

@stop

@section('content')
	<form method="POST" action="{{ url('admin/dashboard/contact') }}/{{$contact->id}}"  enctype="multipart/form-data">
	<input name="_method" type="hidden" value="PUT">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<!-- ################# ROW: Title ####################  -->
	<div class="row large-offset-3">
		<div class="medium-4 large-4 columns">
			<label for="title">Title:
				<input name="title" type="text" value="{{$contact->title}}">
				@if ($errors->has('title')) <small class="error input-error-label">{{ $errors->first('title') }}</small> @endif
			</label>
		</div>
	</div>
	<!-- ################# ROW: Address ####################  -->
	<div class="panel medium-6 large-6 large-offset-3">
		<div class="row">
			<div class="medium-12 large-12 columns">
				<label>Address:
					<input type="text" name="address" class="error" value="{{$contact->address}}">
					@if ($errors->has('address')) <small class="error input-error-label">{{ $errors->first('address') }}</small> @endif
				</label>
			</div>
		</div>
		<div class="row">
			<div class="medium-6 large-6 columns">
				<label>City:
					<input type="text" name="city" class="error" value="{{$contact->city}}">
					@if ($errors->has('city')) <small class="error input-error-label">{{ $errors->first('city') }}</small> @endif
				</label>
			</div>
			<div class="medium-2 large-2 columns">
				<label>State:
					<input type="text" name="state" class="error" value="{{$contact->state}}">
					@if ($errors->has('state')) <small class="error input-error-label">{{ $errors->first('state') }}</small> @endif
				</label>
			</div>
			<div class="medium-4 large-4 columns">
				<label>Zip Code:
					<input type="text" name="zip" class="error" value="{{$contact->zip}}">
					@if ($errors->has('zip')) <small class="error input-error-label">{{ $errors->first('zip') }}</small> @endif
				</label>
			</div>
		</div>
	</div>
	<!-- ################# ROW: Email ####################  -->
	<div class="row large-offset-3">
		<div class="medium-6 large-6 columns ">
			<label for="email">Email:
				<input name="email" type="text" value="{{$contact->email}}">
				@if ($errors->has('email')) <small class="error input-error-label">{{ $errors->first('email') }}</small> @endif
			</label>
		</div>
	</div>
	<!-- ################# ROW: Phone ####################  -->
	<div class="row large-offset-3">
		<div class="medium-3 large-3 columns">
			<label for="phone">Phone:
				<input name="phone" type="text" value="{{$contact->phone}}">
				@if ($errors->has('phone')) <small class="error input-error-label">{{ $errors->first('phone') }}</small> @endif
			</label>
		</div>
	</div>
	<!-- ################# ROW: back button, update button ####################  -->
	<div class="row large-offset-9">
		<div class="medium-1 large-1 columns">
			<input type="submit" class="button small right" value="Update"/>
		</div>
	</div>
</form>
@stop

@section('scripts')
@stop