
@extends('layouts.dashboard')

@section('title')
<a id="back-item" href="{{ route('personalfile.index') }}"><i class="fa fa-chevron-circle-left fa-fw">
	@php
		//<span class="tooltiptext">Volver</span>
	@endphp
</i></a>
 Ficha de Persona
@endsection


//Agregar los hijos como sub-seccion Familiares directos (Padre, Madre, hijos, conyugue)

@section('content')

<div class="container-fluid">
    <div class="row">

			<!-- Modal -->
			<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
			 aria-labelledby="mySmallModalLabel" id="alertsModal" aria-hidden="true">
			  <div class="modal-dialog modal-sm">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h4 class="modal-title">Atención</h4>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true" class="fa fa-window-close"></span>
			        </button>
			      </div>
			      <div class="modal-body">Mensaje</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary"
							 	data-dismiss="modal">Close</button>
						</div>
			    </div>
			  </div>
			</div>

    <div class="col-md-12">
      <div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion"
						 href="#personalFile" aria-expanded="true" class=""
						  id="label-form-pf"> Datos Básicos
							<i class="fa fa-chevron-down fa-fw"></i></a>
					</h4>
				</div>
        <div class="panel-body collapse
				{{ ((session('statusPF') || (!session('statusFF')
					 && !session('statusC'))) ? 'in' :'') }}
				" aria-expanded="true" id="personalFile">

					@if (session('statusPF'))
					    <div class="alert alert-success alert-dismissable animate-alert-top fade in">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
									<i class="fa fa-close" aria-hidden="true" title="Cerrar"></i>
								</button>
					       {{ session('statusPF') }}
					    </div>
					@endif

					@if(isset($personalFile))
					   {!! Form::model($personalFile,
							 ['route' => ['personalfile.updatePF', $personalFile->idField()],
							  'method' => 'patch', 'class' => 'form-horizontal',
								'enctype' => 'multipart/form-data', 'role' => 'form',
								'id' => 'store-pf'
								]) !!}
						@include('personalfile._fieldsPF',
							 ['submitButtonText' => 'Modificar Datos Básicos'])
					@else
					  {!! Form::open(
							['route' => ['personalfile.storePF'],
						  'method' => 'post', 'class' => 'form-horizontal',
						  'enctype' => 'multipart/form-data', 'role' => 'form',
						  'id' => 'store-pf'
						  ]) !!}
						@include('personalfile._fieldsPF',
							 ['submitButtonText' => 'Guardar Datos Básicos'])
					@endif

        {{ Form::close() }}
        </div>

      </div>
    </div>


		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion"
						 href="#foreignFile" aria-expanded="true" class="" id="label-form-ff">
						 Datos Argentinos<i class="fa fa-chevron-down fa-fw"></i></a>
					</h4>
				</div>
				<div class="panel-body collapse
				{{ ((session('statusFF') ) ? 'in' :'') }}
				" aria-expanded="false" id="foreignFile">

					@if (session('statusFF'))
					    <div class="alert alert-success alert-dismissable animate-alert-top fade in">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
									<i class="fa fa-close" aria-hidden="true" title="Cerrar"></i>
								</button>
					       {{ session('statusFF') }}
					    </div>
					@endif

					@if(isset($foreignFile))
						 {!! Form::model($foreignFile,
							 ['route' => ['personalfile.updateFF', $foreignFile->idField()],
								'method' => 'patch', 'class' => 'form-horizontal',
								'enctype' => 'multipart/form-data', 'role' => 'form',
								'id' => 'store-ff'
								]) !!}
						@include('personalfile._fieldsFF',
							 ['submitButtonText' => 'Modificar Datos Argentinos'])
					@else
						{!! Form::open(
							['route' => ['personalfile.storeFF'],
							'method' => 'post', 'class' => 'form-horizontal',
							'enctype' => 'multipart/form-data', 'role' => 'form',
							'id' => 'store-ff'
							]) !!}
						@include('personalfile._fieldsFF',
							 ['submitButtonText' => 'Guardar Datos Argentinos'])
					@endif

					{{ Form::close() }}


				</div>
			</div>
		</div>


		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion"
						 href="#contactsFile" aria-expanded="true" class="">
						 Contactos<i class="fa fa-chevron-down fa-fw"></i></a>
					</h4>
				</div>
				<div class="panel-body collapse" aria-expanded="false" id="contactsFile">

					<div id="new-item">

					</div>

					{!! Form::button('Agregar Contacto',
					 ['class' => 'btn btn-success', 'type' => 'button', 'id' => 'add-button-contact'])
					!!}

				</div>
			</div>
		</div>


		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion"
						 href="#documentsFile" aria-expanded="true" class="">
						 Documentos Digitalizados<i class="fa fa-chevron-down fa-fw"></i></a>
					</h4>
				</div>
				<div class="panel-body collapse" aria-expanded="false" id="documentsFile">

					<div class="row">
						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
							Cedula
							<img src="{{ Storage::disk('public')->url("avatars/default.png") }}"
							class="thumbnail digitalizado" >
						</div>

						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
							Pasaporte
							<img src="{{ Storage::disk('public')->url("avatars/default.png") }}"
							class="thumbnail digitalizado" >
						</div>

						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
							Foto
							<img src="{{ Storage::disk('public')->url("avatars/default.png") }}"
							class="thumbnail digitalizado" >
						</div>

						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
							DNI
							<img src="{{ Storage::disk('public')->url("avatars/default.png") }}"
							class="thumbnail digitalizado" >
						</div>

						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
							Huella
							<img src="{{ Storage::disk('public')->url("avatars/default.png") }}"
							class="thumbnail digitalizado" >
						</div>

					</div>


				</div>
			</div>
		</div>



		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion"
						 href="#reports" aria-expanded="true" class="">
						 Reportes<i class="fa fa-chevron-down fa-fw"></i></a>
					</h4>
				</div>
				<div class="panel-body collapse" aria-expanded="false" id="reports">
					@if (isset($personalFile))
					<div class="row">
						<div class="col-xs-6 col-sm-3 col-md-3 col-lg-2">
							Registro Consular
							<a target="_blank" href="{{ route('personalfile.reports.reportPersonalFile',
								['id' => $personalFile->idField() ]) }}">
								<i class="fa fa-file-pdf-o fa-2 touch" aria-hidden="true"></i>
							</a>
						</div>
					</div>

					@endif


				</div>
			</div>
		</div>
  </div>
</div>
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

<script src="{{ asset('js/admin/personalfile/new.js') }}" ></script>
@endsection
