@extends('layouts.dashboard')

@section('add-css')

	<link rel="stylesheet" href="{{ asset('css/admin/masters/business.css') }}">

@endsection

@section('title')
	Empresas Registradas
@endsection

@section('content')

<input type="hidden" id="route-refresh-list"
	value="{{ route('business.getList') }}">
<input type="hidden" id="show-route"
	value="{{ route('business.show', ['id' => '&id']) }}">
<input type="hidden" id="delete-route"
	value="{{ route('business.delete', ['id' => '&id']) }}">
<input type="hidden" id="create-route"
	value="{{ route('business.create') }}">



<div class="row">

	<div class="col-lg-12">
		<table class="table table-striped table-hover" id="principal-data">
			<thead>
				<tr>
					<th>c1</th>
					<th>c2</th>
					<th>c3</th>
					<th>c4</th>
					<th>c5</th>
					<th>c6</th>
					<th>c7</th>
					<th>c8</th>
					<th>c9</th>
					<th>c10</th>
				</tr>
			</thead>
		</table>

	</div>

</div>

@endsection

@section('links')

@endsection


@section('add-js')
	<script src="{{ asset('js/admin/business/index.js') }}"></script>
@endsection
