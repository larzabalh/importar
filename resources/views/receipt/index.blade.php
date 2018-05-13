@extends('layouts.dashboard')

@section('add-css')

	<link rel="stylesheet" href="{{ asset('css/admin/receipt.css') }}">
	<style>
		.oculto{
			display: none;
		}
		.mostrar{
			display:inline;
		}
	</style>
@endsection

@section('title')
	Comprobantes
@endsection

@section('content')

<div class="bs-example" data-title="">
	<div class="btn-group" role="group">
		@php $x=0; @endphp
		@foreach ($types as $value)
			@php $x++; @endphp
			<a href="{{ route('receipt.index', ['id'=>$value->id]) }}"
 				 class="btn btn-primary {{ ($x==1)?'btn-active':''}}">
				 <input type="hidden" value="{{ $value->id}}"/>
				 <span id="type_id_{{ $value->id}}">{{ $value->name }}</span>
 			</a>
		@endforeach
	</div>
</div>

<input type="hidden" id="route-refresh-list"
	value="{{ route('receipt.getListByCompany', ['person_id' => '&person_id']) }}">
<input type="hidden" id="edit-route"
	value="{{ route('receipt.edit', ['id' => '&id']) }}">
<input type="hidden" id="delete-route"
	value="{{ route('receipt.delete', ['id' => '&id']) }}">
<input type="hidden" id="create-route"
	value="{{ route('receipt.create', ['type_id'=> '&type_id']) }}">



<div class="row">

	@if($receipt)
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

	@else
	  <p>No hay Registros</p>
	@endif

</div>

@endsection

@section('links')

@endsection


@section('add-js')
	<script src="{{ asset('js/admin/receipt/index.js') }}"></script>
@endsection
