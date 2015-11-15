@extends('admin.admin-master')

@section('styles')
	<link media="all" type="text/css" rel="stylesheet" href="{{ url('css/admin-dashboard.css') }}">
@endsection

@section('content')
<div class="row">
		<div class="large-4 medium-4 columns">
			<div class="panel dash-panel">
				<a class="dash-button button large text-center" href="{{ url('admin/dashboard/clients') }}">View Clients</a>
			</div>
		</div>
		<div class="large-4 medium-4 columns">
			<div class="panel dash-panel">
				<a class="dash-button button large" href="{{ url('admin/dashboard/clients/create') }}">Add New Client</a>
			</div>
		</div>
		<div class="large-4 medium-4 columns">
			<div class="panel dash-panel">
				<a class="dash-button button large" href="{{ url('admin/dashboard/portfolio') }}">Portfolio Albums</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="large-4 medium-4 columns">
			<div class="panel dash-panel">
				<a class="dash-button button large" href="{{ url('admin/dashboard/orders') }}">View Orders</a>
			</div>
		</div>
		<div class="large-4 medium-4 columns">
			<div class="panel dash-panel">
				<a class="dash-button button large" href="{{ url('admin/dashboard/about') }}">Edit About Me</a>
			</div>
		</div>
		<div class="large-4 medium-4 columns">
			<div class="panel dash-panel">
				<a class="dash-button button large" href="{{ url('admin/dashboard/contact') }}">Edit Contact Me</a>
			</div>
		</div> 
	</div>
@endsection


@section('scripts')
@endsection
