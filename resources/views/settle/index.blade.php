@extends('layouts.dashboard')

@section('add-css')

	<link rel="stylesheet" href="{{ asset('css/admin/settle/settle.css') }}">
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
	Liquidación de Impuestos
@endsection

@section('content')
	<input type="hidden" id="index-settle-route"
  	value="{{ route('settle.index') }}">

  <input type="hidden" id="route-refresh-list"
  	value="{{ route('settle.getListByCompany', ['person_id' => '&person_id']) }}">
  <input type="hidden" id="show-route"
  	value="{{ route('settle.show', ['id' => '&id']) }}">

  <input type="hidden" id="store-route"
  	value="{{ route('settle.store', ['id'=> '&id']) }}">

  <input type="hidden" id="showDelete-route"
  	value="{{ route('settle.showDelete', ['id'=> '&id']) }}">

	<input type="hidden" id="close-route"
	  	value="{{ route('settle.close', ['id'=> '&id']) }}">

   <ul class="nav nav-tabs">
      <li class="active"><a href="#tax-run-tabs0" data-toggle="tab"
				 aria-expanded="true" id="tax-run-tabs0-lnk">Liquidaciones abiertas</a></li>
      <li class=""><a href="#tax-run-tabs1" data-toggle="tab"
				 aria-expanded="false" id="tax-run-tabs1-lnk">Liquidaciones cerradas</a></li>
   </ul>


   <div class="tab-content">

      <div class="tab-pane fade active in" id="tax-run-tabs0">

				<div class="bs-callout bs-callout-info" id="callout-navs-tabs-plugin">
					<div id ="alertsFlag"></div>
         <div class="row">
            <div class="col-lg-12">
							{!! Form::open(
							  ['route' => ['settle.generate'],
							  'method' => 'post', 'class' => 'form-horizontal',
							  'enctype' => 'multipart/form-data', 'role' => 'form',
							  'id' => 'tax-run'
							  ]) !!}
               <div class="row" id="tax-run-tabs0-0">
                  <div class="col-md-4 col-lg-2">
                     <div class="form-group" >
                       <div class="form-group" >
                         <label for="period_query">
                           Período <i title="Requerido" class="fa fa-asterisk fa-fw"></i>
                         </label>
                         <input class="form-control" id="period_query" name="period_code"
                          autocomplete="off" value="">
                         <ul></ul>
                         <input type="hidden" id="period_id" name="period_id"
                          value="">
                         <input type="hidden" id="route-period-list" name="no-use"
                          value="{{ route('periods.search', ['param' => '&param']) }}">
                       </div>
                     </div>
                  </div>
                  <div class="col-md-4 col-lg-2">
                     <div class="form-group" id="tax-run-tabs-fld1-g">
                        <label id="tax-run-tabs-fld1-lbl" for="tax-run-tabs-fld1">
													Tipo <i title="Requerido" class="fa fa-asterisk fa-fw"></i></label>
                        <select class="form-control" id="apply_to"
												 name="apply_to">
                           <option value=""></option>
                           @foreach ($types as $value)
                           	<option value="{{$value}}">{{ strtoupper($value) }}</option>
                           @endforeach
                        </select>
                        <span class="field-data" id="tax-run-tabs-fld1-data"></span>
                     </div>
                  </div>

                  <div class="col-md-4 col-lg-3">
                    <p class="buttons">
                      <button type="button" class="btn btn-success " id="run-tax">
                        <i class="fa fa-play fa-fw"></i> Abrir Liquidación
                      </button>
                    </p>
                  </div>
               </div>

             {{ Form::close() }}
            </div>

					</div>
         </div>

         <div class="row">
            <div class="col-lg-12">
               <div class="panel panel-default">
                  <div class="panel-heading">Liquidación de impuestos</div>
                  <div class="panel-body">
										<div id="alertsPeriods"></div>
                     <div class="row widgetCnt" id="tax-run-tabs0-1">
                        <div class="dataTables_wrapper form-inline dt-bootstrap no-footer"
												 id="tax-taxruns" style="display: block;">

                           <div class="row">
                              <div class="col-sm-12">


   <table class="table table-striped table-bordered table-hover" id="principal-data">
      <thead>
         <tr>
            <th >Periodo</th>
            <th >Tipo</th>
            <th >Total</th>
            <th >Ult Mod</th>
            <th ></th>
            <th ></th>
            <th ></th>
            <th ></th>
            <th ></th>
            <th ></th>
         </tr>
      </thead>
      <tbody id="tax-taxruns-body">

      </tbody>
   </table>
                              </div>
                           </div>

                           <div class="row">
                              <div class="col-sm-6">
                                 <div class="pull-right">
                                    <div class="btn-group">
                                       <button type="button"
 class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"
  aria-expanded="false">Acciones <span class="caret"></span></button>
                                       <ul class="dropdown-menu pull-right">
                                          <li><a href="JavaScript:;">Descargar como PDF</a></li>
                                          <li><a href="JavaScript:;">Descargar como Excel</a></li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-6 footbtns">
						<button type="button" class="btn btn-link" id="tax-taxruns-reload">
							<i class="fa fa-refresh fa-fw"></i> </button></div>
                           </div>

                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row"></div>
      </div>
      <div class="tab-pane fade" id="tax-run-tabs1">

				<div class="row">
					 <div class="col-lg-12">
							<div class="panel panel-default">
								 <div class="panel-heading">Liquidación de impuestos</div>
								 <div class="panel-body">
										<div class="row widgetCnt" id="tax-run-tabs0-1">
											 <div class="dataTables_wrapper form-inline dt-bootstrap no-footer"
												id="tax-taxruns" style="display: block;">

													<div class="row">
														 <div class="col-sm-12">


	<table class="table table-striped table-bordered table-hover" id="closed-data">
		<thead>
			 <tr>
					<th >Periodo</th>
					<th >Tipo</th>
					<th >Total</th>
					<th >Ult Mod</th>
					<th ></th>
					<th ></th>
					<th ></th>
					<th ></th>
					<th ></th>
					<th ></th>
			 </tr>
		</thead>
		<tbody id="tax-taxruns-body">

		</tbody>
	</table>
														 </div>
													</div>

													<div class="row">
														 <div class="col-sm-6">
																<div class="pull-right">
																	 <div class="btn-group">
																			<button type="button"
class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown"
 aria-expanded="false">Acciones <span class="caret"></span></button>
																			<ul class="dropdown-menu pull-right">
																				 <li><a href="JavaScript:;">Descargar como PDF</a></li>
																				 <li><a href="JavaScript:;">Descargar como Excel</a></li>
																			</ul>
																	 </div>
																</div>
														 </div>
														 <div class="col-sm-6 footbtns">
					 <button type="button" class="btn btn-link" id="tax-taxruns-reload">
						 <i class="fa fa-refresh fa-fw"></i> </button></div>
													</div>

											 </div>
										</div>
								 </div>
							</div>
					 </div>


         <div class="row"></div>
      </div>
   </div>
@endsection

@section('links')

@endsection


@section('add-js')
	<script src="{{ asset('js/admin/settle/index.js') }}"></script>
@endsection
