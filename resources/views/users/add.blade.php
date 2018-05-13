@extends('layouts.dashboard')

@section('title')
<a href="{{ route('users.index') }}"><i class="fa fa-chevron-circle-left fa-fw">
	<span class="tooltiptext">Volver</span>
</i></a>
 Nuevo User
@endsection

@section('content')
	<div class="container">
	    <div class="row">
	        <div class="col-md-8 col-md-offset-2">
	            <div class="panel panel-default">
	                <div class="panel-body">
	                    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{ route('users.store') }}" id="add-form">
												<fieldset >
	                        {{ csrf_field() }}

	                        <div class="form-group{{ $errors->has('loginUser') ? ' has-error' : '' }}">
	                            <label for="loginUser" class="col-md-4 control-label">User</label>

	                            <div class="col-md-6">
	                                <input id="loginUser" type="text" class="form-control" name="loginUser" value="{{ old('loginUser')?? 'juang' }}" >

	                                @if ($errors->has('loginUser'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('loginUser') }}</strong>
	                                    </span>
	                                @endif
	                            </div>
	                        </div>
	                        <div class="form-group{{ $errors->has('emailUser') ? ' has-error' : '' }}">
	                            <label for="loginUsuemailUserario" class="col-md-4 control-label">E-mail</label>

	                            <div class="col-md-6">
	                                <input id="emailUser" type="text" class="form-control" name="emailUser" value="{{ old('emailUser')?? 'juan@juan.com' }}" >

	                                @if ($errors->has('emailUser'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('emailUser') }}</strong>
	                                    </span>
	                                @endif
	                            </div>
	                        </div>

	                        <div class="form-group{{ $errors->has('claveUser') ? ' has-error' : '' }}">
	                            <label for="claveUser" class="col-md-4 control-label">Password</label>

	                            <div class="col-md-6">
																<div class="relative-pos">
	                                <input id="claveUser" type="password" class="form-control" name="claveUser"
																	value="123456">

																	<span class="fa fa-eye fa-fw icon-right-abs-2" id="verPassword">
																		<span class="tooltiptext">Presionar para Ver</span>
																	</span>

																	<span class="fa fa-cogs fa-fw icon-right-abs" id="generarPassword">
																		<span class="tooltiptext">Generar Password</span>
																	</span>


	                                @if ($errors->has('claveUser'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('claveUser') }}</strong>
	                                    </span>
	                                @endif
		                            </div>
															</div>
		                        </div>

	                        <div class="form-group">
	                            <label for="claveUser-confirm" class="col-md-4 control-label">Confirm Password</label>

	                            <div class="col-md-6">
	                                <input id="claveUser-confirm" type="password" class="form-control" name="claveUser_confirmation" value="123456">
	                            </div>
	                        </div>

													<div class="form-group">
														<label for="avatar" class="col-md-4 control-label">Avatar</label>
														<div class="col-md-6">
										        	<input name="avatar" id="avatar" type="file" class="" value="">
														</div>
													</div>

	                        <div class="form-group">
	                            <div class="col-md-6 col-md-offset-4">
	                                <button type="submit" class="btn btn-primary" id="send-button">
	                                    Guardar
	                                </button>
	                            </div>
	                        </div>
												</fieldset>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
@endsection

@section('add-js')

<script src="{{ asset('js/jquery-validation/dist/jquery.validate.min.js') }}" ></script>
<script src="{{ asset('js/jquery-validation/dist/additional-methods.js') }}" ></script>
<script src="{{ asset('js/admin/users/new.js') }}" ></script>
@endsection
