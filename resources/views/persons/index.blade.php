@extends('layouts.dashboard')

@section('add-css')

	<link rel="stylesheet" href="{{ asset('css/admin/masters/business.css') }}">

@endsection

@section('title')
	Clientes ó Proveedores
@endsection

@section('content')

<input type="hidden" id="route-refresh-list"
	value="{{ route('persons.getOnlyPersons') }}">
<input type="hidden" id="show-route"
	value="{{ route('persons.show', ['id' => '&id']) }}">
<input type="hidden" id="delete-route"
	value="{{ route('persons.delete', ['id' => '&id']) }}">
<input type="hidden" id="create-route"
	value="{{ route('persons.create') }}">



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
	<script src="{{ asset('js/admin/persons/index.js') }}"></script>
@endsection
