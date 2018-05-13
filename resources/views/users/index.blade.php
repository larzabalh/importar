@extends('layouts.dashboard')

@section('title')
	Users
@endsection

@section('content')

  <div class="container-fluid">

		<div class="pull-left">
			<a href="{{ route('users.create') }}" class="btn btn-info">
				<span class="fa fa-plus fa-fw"></span>
				Nuevo User</a>
		</div>

		<div class="pull-right">
			<form class="" action="{{ route('users.index') }}" method="GET">

		    <div class="input-group ">
		        <input class="form-control" placeholder="Buscar" type="text"
						 name="param" value="{{ old('param') }}">
		        <span class="input-group-btn">
		            <button class="btn btn-primary" type="submit">
		                <i class="fa fa-search"></i>
		            </button>
		    </span>
		    </div>
		    <!-- /input-group -->

			</form>
		</div>
	</div>


<div class="row">
	@if($users) <?php $x=0; ?>
	<div class="col-lg-12">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Oper.</th>
					<th>Username</th>
					<th>Email</th>
				</tr>
			</thead>
			<tbody>
		@foreach($users as $user)<?php $x++; ?>
			<tr>
				<td scope="row" id="operations">
				 <a class="icon-user" data-tooltip-content="Editar User" href="
				 {{ route('users.edit', ['id' => $user->idField() ]) }}" >
					 <strong><span class="fa fa-user fa-2 spam-margins"></span></strong>

				 <a class="icon-module" data-tooltip-content="Editar Modulos" href="
				 {{ route('users.modules', ['id' => $user->idField() ]) }}" >
				 <strong><span class="fa fa-navicon fa-2 spam-margins"></span></strong>
				 </a>
				</td>
				<td>
				 <img src="{{ Storage::disk('public')->url( ($user->avatar)
					  ? $user->avatar : "avatars/default.png") }}"
				 class="thumbnail miniatura" >
					 {{ $user->getNameUser() }}
				</td>
				<td>{{ $user->getEmailForPasswordReset() }}</td>
			</tr>
		@endforeach
			</tbody>
		</table>
	</div>

	@else
	  <p>No hay Users Registrados</p>
	@endif

</div>

@endsection

@section('links')
	{{ $users->links() }}
@endsection

@section('add-js')
<link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">

<script src="{{ asset('js/jquery-validation/dist/jquery.validate.min.js') }}" ></script>
<script src="{{ asset('js/jquery-validation/dist/additional-methods.js') }}" ></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery-masked.min.js') }}"></script>


<link rel="stylesheet" href="{{ asset('js/tooltipster/css/tooltipster.bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/tooltipster/css/tooltipster-sideTip-light.min.css') }}">

<script src="{{ asset('js/tooltipster/js/tooltipster.bundle.min.js') }}"></script>

<script src="{{ asset('js/admin/users/new.js') }}" ></script>
@endsection
