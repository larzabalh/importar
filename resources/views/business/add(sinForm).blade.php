
@extends('layouts.dashboard')

@section('title')
<a href="{{ route('personalfile.index') }}"><i class="fa fa-chevron-circle-left fa-fw">
	<span class="tooltiptext">Volver</span>
</i></a>
 Nueva Ficha de Persona
@endsection

@section('content')
	<div class="container-fluid">
    <div class="row">

      <div class="col-md-12">
        <div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#personalFile" aria-expanded="true" class="">Datos Básicos</a>
						</h4>
					</div>
          <div class="panel-body collapse in" aria-expanded="true" id="personalFile">

						<form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{ route('personalfile.storePF') }}" id="store-pf">
							<fieldset >
                {{ csrf_field() }}

                <div class="col-xs-12 col-md-4 col-lg-6 form-group{{ $errors->has('idCountry') ? ' has-error' : '' }} input-groups">
                    <label for="idCountry" class="control-label">Nacionalidad *</label>

                    <div class="">
                        <select id="idCountry" class="form-control" name="idCountry">
													<option value="">-- Nacionalidad --</option>
													@foreach ($countrys as $list)
														<option value="{{ $list->idField() }}"
															 {{ ( (old('idCountry')==$list->idField() ) ? 'selected' :
																 (($list->idField()==95)? 'selected':'') ) }} >
																 {{ $list->getName() }}</option>
													@endforeach
												</select>

                        @if ($errors->has('idCountry'))
                            <span class="help-block">
                                <strong>{{ $errors->first('idCountry') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

								<div class="col-xs-12 col-sm-12 col-md-8 col-lg-6 form-group bg-success {{ $errors->has('personalID') ? ' has-error' : '' }} input-groups">
									<label for="personalID" class="control-label">Cédula *</label>
									<div class="row">

										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
														<input id="personalID" type="text" class="form-control" name="personalID" value="{{ old('personalID') }}" placeholder="Cedula">

														@if ($errors->has('personalID'))
																<span class="help-block">
																		<strong>{{ $errors->first('personalID') }}</strong>
																</span>
														@endif
										</div>


										<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 {{ $errors->has('emisionPersonalID') ? ' has-error' : '' }}">
														<input id="emisionPersonalID" type="" class="form-control" name="emisionPersonalID" value="{{ old('emisionPersonalID') }}" placeholder="Emision">

														@if ($errors->has('emisionPersonalID'))
																<span class="help-block">
																		<strong>{{ $errors->first('emisionPersonalID') }}</strong>
																</span>
														@endif
										</div>


										<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 {{ $errors->has('expirationPersonalID') ? ' has-error' : '' }}">
														<input id="expirationPersonalID" type="" class="form-control" name="expirationPersonalID" value="{{ old('expirationPersonalID') }}" placeholder="Expiración">

														@if ($errors->has('expirationPersonalID'))
																<span class="help-block">
																		<strong>{{ $errors->first('expirationPersonalID') }}</strong>
																</span>
														@endif
										</div>

									</div>
								</div>

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 form-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
                    <label for="firstName" class=" control-label">Nombres *</label>

                    <div class="">
                        <input id="firstName" type="text" class="form-control" name="firstName" value="{{ old('firstName') }}" placeholder="Nombres">

                        @if ($errors->has('firstName'))
                            <span class="help-block">
                                <strong>{{ $errors->first('firstName') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 form-group{{ $errors->has('lastName') ? ' has-error' : '' }}">
										<label for="lastName" class=" control-label">Apellidos *</label>

										<div class="">
												<input id="lastName" type="text" class="form-control" name="lastName" value="{{ old('lastName') }}" placeholder="Apellidos">

												@if ($errors->has('lastName'))
														<span class="help-block">
																<strong>{{ $errors->first('lastName') }}</strong>
														</span>
												@endif
										</div>
								</div>

								<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 form-group bg-success {{ $errors->has('birthDate') || $errors->has('birthPlace') ? ' has-error' : '' }}  input-groups">
                    <label for="birthDate" class="control-label">Fecha y lugar de Nacimiento *</label>
									<div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <input id="birthDate" type="" class="form-control" name="birthDate" value="{{ old('birthDate') }}" placeholder="Fecha de Nacimiento">

                        @if ($errors->has('birthDate'))
                            <span class="help-block">
                                <strong>{{ $errors->first('birthDate') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-8 {{ $errors->has('birthPlace') ? ' has-error' : '' }}">
											<input id="birthPlace" type="text" class="form-control" name="birthPlace" value="{{ old('birthPlace') }}" placeholder="Lugar de Nacimiento" >

											@if ($errors->has('birthPlace'))
													<span class="help-block">
															<strong>{{ $errors->first('birthPlace') }}</strong>
													</span>
											@endif
										</div>
									</div>
                </div>

								<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 form-group  {{ $errors->has('civilState') ? ' has-error' : '' }}">
                    <label for="claveUser-confirm"
										 class=" control-label">Estado Civil *</label>

                    <div class="">
                        <select id="civilState" class="form-control"
												 name="civilState" value="">
													<option value="">-- Estado Civil --</option>
													@foreach ($civilStates as $key => $value)
														<option value="{{ $key }}"
														 {{ (old('civilState')==$key)? 'selected':'' }}
														  >{{ $value }}</option>
													@endforeach
												</select>
												@if ($errors->has('birthPlace'))
														<span class="help-block">
																<strong>
																	{{ $errors->first('birthPlace') }}
																</strong>
														</span>
												@endif
                    </div>
                </div>

								<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 form-group bg-success {{ $errors->has('passportNumber') ? ' has-error' : '' }} input-groups">
									<label for="passportNumber" class=" control-label">Pasaporte </label>
									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
														<input id="passportNumber" type="text" class="form-control" name="passportNumber" value="{{ old('passportNumber') }}" placeholder="Pasaporte">

														@if ($errors->has('passportNumber'))
																<span class="help-block">
																		<strong>{{ $errors->first('passportNumber') }}</strong>
																</span>
														@endif
										</div>


										<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 {{ $errors->has('emisionPassport') ? ' has-error' : '' }}">
														<input id="emisionPassport" type="" class="form-control" name="emisionPassport" value="{{ old('emisionPassport') }}" placeholder="Emisión">

														@if ($errors->has('emisionPassport'))
																<span class="help-block">
																		<strong>{{ $errors->first('emisionPassport') }}</strong>
																</span>
														@endif
										</div>


										<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 {{ $errors->has('expirationPassport') ? ' has-error' : '' }}">
														<input id="expirationPassport" type="" class="form-control" name="expirationPassport" value="{{ old('expirationPassport') }}" placeholder="Expiración">

														@if ($errors->has('expirationPassport'))
																<span class="help-block">
																		<strong>{{ $errors->first('expirationPassport') }}</strong>
																</span>
														@endif
										</div>

									</div>
								</div>

								<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 form-group{{ $errors->has('bloodType') ? ' has-error' : '' }}">
										<label for="bloodType" class=" control-label">Tipo de Sangre</label>

										<div class="">
												<input id="bloodType" type="text" class="form-control" name="bloodType" value="{{ old('bloodType') }}" placeholder="Tipo de Sangre">

												@if ($errors->has('bloodType'))
														<span class="help-block">
																<strong>{{ $errors->first('bloodType') }}</strong>
														</span>
												@endif
										</div>
								</div>

								<div class="col-xs-12 col-md-12 col-lg-12 form-group bg-success{{ $errors->has('idState') ? ' has-error ' : '' }} input-groups">
                  <label for="idState" class="control-label">Datos en Venezuela*</label>
									<div class="row">

                  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                      <select id="idState" class="form-control" name="idState">
													<option value="">-- Estado --</option>
												@foreach ($states as $list)
													<option value="{{ $list->idField() }}"
														{{ ((old('idState')==$list->idField())?'selected':'') }}
														>{{ $list->getName() }}</option>
												@endforeach
											</select>

                      @if ($errors->has('idState'))
                          <span class="help-block">
                              <strong>{{ $errors->first('idState') }}</strong>
                          </span>
                      @endif
                  </div>
									<img src="{{ Storage::disk('public')->url('/img/loading1.gif') }}" id="idCountry_img" class="img-loading">

									<div class="col-xs-12 col-sm-6 col-md-9 col-lg-9 {{ $errors->has('addressOrigin') ? ' has-error' : '' }}">
											<input id="addressOrigin" type="text" class="form-control" name="addressOrigin" value="{{ old('addressOrigin') }}" placeholder="Dirección">

											@if ($errors->has('addressOrigin'))
													<span class="help-block">
															<strong>{{ $errors->first('addressOrigin') }}</strong>
													</span>
											@endif
									</div>

									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 {{ $errors->has('localPhoneNumber') ? ' has-error' : '' }}">
											<input id="localPhoneNumber" type="phone" class="form-control" name="localPhoneNumber" value="{{ old('localPhoneNumber') }}" placeholder="Telefono Local">

											@if ($errors->has('localPhoneNumber'))
													<span class="help-block">
															<strong>{{ $errors->first('localPhoneNumber') }}</strong>
													</span>
											@endif
									</div>

									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 {{ $errors->has('mobilePhoneNumber') ? ' has-error' : '' }}">
											<input id="mobilePhoneNumber" type="phone" class="form-control" name="mobilePhoneNumber" value="{{ old('mobilePhoneNumber') }}" placeholder="Telefono Movil">

											@if ($errors->has('mobilePhoneNumber'))
													<span class="help-block">
															<strong>{{ $errors->first('mobilePhoneNumber') }}</strong>
													</span>
											@endif
									</div>
								</div>
							</div>

								<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 form-group{{ $errors->has('principalEmail') ? ' has-error' : '' }}">
									<label for="principalEmail" class=" control-label">Email Principal *</label>

									<div class="">
										<input id="principalEmail" type="email" class="form-control" name="principalEmail" value="{{ old('principalEmail') }}" placeholder="mail@dominio.com">

										@if ($errors->has('principalEmail'))
												<span class="help-block">
														<strong>{{ $errors->first('principalEmail') }}</strong>
												</span>
										@endif
									</div>
								</div>

								<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 form-group{{ $errors->has('secondaryEmail') ? ' has-error' : '' }}">
										<label for="secondaryEmail" class=" control-label">Email Secundario</label>

										<div class="">
												<input id="secondaryEmail" type="email" class="form-control" name="secondaryEmail" value="{{ old('secondaryEmail') }}" placeholder="mail@dominio.com">

												@if ($errors->has('secondaryEmail'))
														<span class="help-block">
																<strong>{{ $errors->first('secondaryEmail') }}</strong>
														</span>
												@endif
										</div>
								</div>

								<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 form-group{{ $errors->has('instruccionDegree') ? ' has-error' : '' }}">
										<label for="instruccionDegree" class=" control-label">Grado de Instrucción</label>

										<div class="">
												<input id="instruccionDegree" type="text" class="form-control" name="instruccionDegree" value="{{ old('instruccionDegree') }}" placeholder="Grado de Instrucción">

												@if ($errors->has('instruccionDegree'))
														<span class="help-block">
																<strong>{{ $errors->first('instruccionDegree') }}</strong>
														</span>
												@endif
										</div>
								</div>

								<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 form-group{{ $errors->has('jobOcupattion') ? ' has-error' : '' }}">
										<label for="jobOcupattion" class=" control-label">Oficio / Profesión</label>

										<div class="">
												<input id="jobOcupattion" type="text" class="form-control" name="jobOcupattion" value="{{ old('jobOcupattion') }}" placeholder="Oficio/Ocupación">

												@if ($errors->has('jobOcupattion'))
														<span class="help-block">
																<strong>{{ $errors->first('jobOcupattion') }}</strong>
														</span>
												@endif
										</div>
								</div>

								<div class="col-xs-12 col-sm-12 col-md-7 col-lg-6 form-group bg-success input-groups">
									<label for="birthNumberFile" class=" control-label">Acta Nacimiento </label>
									<div class="row">

										<div class="col-xs-12 col-sm-9 col-md-8 col-lg-9 {{ $errors->has('birthNumberFile') ? ' has-error' : '' }}">
											<input id="birthNumberFile" type="text" class="form-control" name="birthNumberFile" value="{{ old('birthNumberFile') }}" placeholder="Número - Folio">

											@if ($errors->has('birthNumberFile'))
													<span class="help-block">
															<strong>{{ $errors->first('birthNumberFile') }}</strong>
													</span>
											@endif
										</div>

										<div class="col-xs-12 col-sm-3 col-md-4 col-lg-3 {{ $errors->has('birthFileDate') ? ' has-error' : '' }}">
												<input id="birthFileDate" type="" class="form-control" name="birthFileDate" value="{{ old('birthFileDate') }}" placeholder="Fecha Emisión">

												@if ($errors->has('birthFileDate'))
														<span class="help-block">
																<strong>{{ $errors->first('birthFileDate') }}</strong>
														</span>
												@endif
										</div>

									</div>
								</div>

                <div class="col-xs-12 form-group">
                    <button type="submit" class="btn btn-primary" id="send-button-pf">
                        Guardar
                    </button>
                </div>
							</fieldset>
          </form>
          </div>

      </div>
    </div>


		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#foreingFile" aria-expanded="true" class="">Datos Argentinos</a>
					</h4>
				</div>
				<div class="panel-body collapse in" aria-expanded="true" id="foreingFile">




				</div>
			</div>
		</div>


		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#contactsFile" aria-expanded="true" class="">Contactos</a>
					</h4>
				</div>
				<div class="panel-body collapse in" aria-expanded="true" id="contactsFile">
						Boton Agregar Uno a uno y guardarlos
				</div>
			</div>
		</div>


		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#documentsFile" aria-expanded="true" class="">Documentos Digitalizados</a>
					</h4>
				</div>
				<div class="panel-body collapse in" aria-expanded="true" id="documentsFile">

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

  </div>
</div>
@endsection

@section('add-js')
<link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">

<script src="{{ asset('js/jquery-validation/dist/jquery.validate.min.js') }}" ></script>
<script src="{{ asset('js/jquery-validation/dist/additional-methods.js') }}" ></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery-masked.min.js') }}"></script>


<script src="{{ asset('js/admin/personalfile/new.js') }}" ></script>
@endsection
