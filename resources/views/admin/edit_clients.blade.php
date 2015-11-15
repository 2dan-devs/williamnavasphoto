@extends('admin.admin-master')

@section('styles')
	<link media="all" type="text/css" rel="stylesheet" href="{{ url('css/admin-clients.css') }}">
@endsection

@section('content')
<form id="user_client_form" method="POST" action="{{ url('admin/dashboard/clients') }}/{{$client->id}}"  enctype="multipart/form-data">
<input name="_method" type="hidden" value="PUT">
<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
<div class="row">
	<div class="medium-4 large-4 large-offset-3 column">
		<img id="preview-holder" src="#" alt="preview">
	</div>
</div>

<div class="row">
	<div class="medium-4 large-4 large-offset-3 columns">
		<label>Select Profile Photo (optional):
			<input type="file" name="profile_photo" id="img-input" class="button tiny secondary" accept="image/*" value="{{ Input::old('profile_photo') }}">
		</label>
	</div>
</div>

<div class="row">
	<div class="medium-3 large-3 large-offset-3 columns">
		<label>First Name:
			<input type="text" name="first_name" class="error" value="{{Input::old('first_name', $client->first_name) }}">
			@if ($errors->has('first_name')) <small class="error input-error-label">{{ $errors->first('first_name') }}</small> @endif
		</label>
	</div>
	<div class="medium-3 large-3 columns end">
		<label>Last Name:
			<input type="text" name="last_name" class="error" value="{{Input::old('last_name',$client->last_name )}}">
			@if ($errors->has('last_name')) <small class="error input-error-label">{{ $errors->first('last_name') }}</small> @endif
		</label>
	</div>
</div>
<br>
<div class="panel medium-6 large-6 large-offset-3">
	<div class="row">
		<div class="medium-12 large-12 columns">
			<label>Adress Line 1:
				<input type="text" name="address_1" class="error" value="{{Input::old('address_1',$client->address_1 )}}">
				@if ($errors->has('address_1')) <small class="error input-error-label">{{ $errors->first('address_1') }}</small> @endif
			</label>
		</div>
	</div>
	<div class="row">
		<div class="medium-12 large-12 columns">
			<label>Adress Line 2:
				<input type="text" name="address_2" class="error" value="{{Input::old('address_2',$client->address_2)}}">
				@if ($errors->has('address_2')) <small class="error input-error-label">{{ $errors->first('address_2') }}</small> @endif
			</label>
		</div>
	</div>
	<div class="row">
		<div class="medium-6 large-6 columns">
			<label>City:
				<input type="text" name="city" class="error" value="{{Input::old('city',$client->city)}}">
				@if ($errors->has('city')) <small class="error input-error-label">{{ $errors->first('city') }}</small> @endif
			</label>
		</div>
		<div class="medium-2 large-2 columns">
			<label>State:
				<input type="text" name="state" class="error" value="{{Input::old('state',$client->state)}}">
				@if ($errors->has('state')) <small class="error input-error-label">{{ $errors->first('state') }}</small> @endif
			</label>
		</div>
		<div class="medium-4 large-4 columns">
			<label>Zip Code:
				<input type="text" name="zip" class="error" value="{{Input::old('zip',$client->zip)}}">
				@if ($errors->has('zip')) <small class="error input-error-label">{{ $errors->first('zip') }}</small> @endif
			</label>
		</div>
	</div>
</div>
<div class="row">
	<div class="medium-3 large-3 large-offset-3 columns">
		<label>Phone 1:
			<input type="text" name="phone_1" class="error" value="{{Input::old('phone_1',$client->phone_1)}}">
			@if ($errors->has('phone_1')) <small class="error input-error-label">{{ $errors->first('phone_1') }}</small> @endif
		</label>
	</div>
	<div class="medium-3 large-3 columns end">
		<label>Phone 2 (optional):
			<input type="text" name="phone_2" class="error" value="{{Input::old('phone_2',$client->phone_2)}}">
			@if ($errors->has('phone_2')) <small class="error input-error-label">{{ $errors->first('phone_2') }}</small> @endif
		</label>
	</div>
</div>

<div class="row">
	<div class="medium-6 large-6 large-offset-3 columns">
		<label>Email:
			<input type="text" name="email" class="error" value="{{Input::old('email',$client->email)}}">
			@if ($errors->has('email')) <small class="error input-error-label">{{ $errors->first('email') }}</small> @endif
		</label>
	</div>
</div>

<div class="row">
	<div class="medium-3 large-3 large-offset-3 columns">
		<label>Password:
			<input type="text" name="password" class="error" value="{{ Input::old('password') }}">
			@if ($errors->has('password')) <small class="error input-error-label">{{ $errors->first('password') }}</small> @endif
		</label>
	</div>
</div>
<div class="row">
	<div class="medium-2 large-2 large-offset-3 columns">
		<label>User Status:
			<select name="is_active" form="user_client_form">
			  <option value="1" @if(Input::old('is_active',$user->is_active))selected="selected";@endif>Active</option>
			  <option value="0" @if(!Input::old('is_active',$user->is_active))selected="selected";@endif>Inactive</option>
			</select>
		</label>
	</div>
</div>	
<br>
<div class="row">
	<div class="medium-6 large-6 large-offset-3 columns">
		<input type="submit" class="button small right" value="Update"/>
	</div>
</div>
</form>
@endsection

@section('scripts')
	<script src="{{ url('js/create-clients.js') }}"></script>
@endsection