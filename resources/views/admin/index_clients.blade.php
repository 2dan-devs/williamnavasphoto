@extends('admin.admin-master')

@section('content')
<div class="row">
	<form method="POST" action="{{ url('admin/dashboard/clients/search') }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="medium-3 large-3 columns">
				<input name="search_terms" type="text" placeholder="Enter Client Name">
		</div>
		<div class="medium-1 large-1 columns end">
			<input type="submit" class="button small right" value="Search">
		</div>
	</form>
</div>
<div class="row">
@foreach($clients as $client)

	<div class="medium-3 large-3 column panel end">
		<img src="/{{$client->profile_photo}}" />
		<label><b>Name:</b><br>{{$client->first_name.' '.$client->last_name}}</label>
		<label><b>Email:</b><br>{{$client->email}}</label>
		<label><b>Address:</b></label>
		<label>{{$client->address_1}}</label>
		<label>{{$client->address_2}}</label>
		<label>{{$client->city.', '.$client->state.' '.$client->zip}}</label>
		<label><b>Phone:</b><br>{{$client->phone_1}}</label>
		<a href="{{ url('admin/dashboard/clients') }}/{{$client->id}}/albums" class="button expand">View Client Albums</a>
		<a href="{{ url('admin/dashboard/clients') }}/{{$client->id}}/edit" class="button expand">Edit Client/User Profile</a>
		<form method="POST" action="{{ url('admin/dashboard/clients') }}/{{$client->id}}" onsubmit ="return confirm('This action is NOT reversible. Are you sure to delete this record?');">
			<input name="_method" type="hidden" value="DELETE">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="submit" class="button expand" value="Delete Client" />
		</form>	
	</div>
	
@endforeach
</div>
{!! $clients->render() !!}
@endsection

@section('scripts')
@endsection