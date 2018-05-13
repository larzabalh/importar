@extends('layouts.dashboard')

@section('title')
<a href="{{ route('users.index') }}"><i class="fa fa-chevron-circle-left fa-fw">
  	<span class="tooltiptext">Volver</span>
</i></a>
 Editar User
@endsection

@section('content')

  <div class="container">
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              <div class="panel panel-default">
                  <div class="panel-body">
                      <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{ route('users.update', ['id' => $user->idField() ]) }}">
                          {{ csrf_field() }}

                          <div class="form-group{{ $errors->has('loginUser') ? ' has-error' : '' }}">
                              <label for="loginUser" class="col-md-4 control-label">User</label>

                              <div class="col-md-6">
                                  <input id="loginUser" type="text" class="form-control" name="loginUser" value="{{ $user->getNameUser() }}" required>

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
                                  <input id="emailUser" type="text" class="form-control" name="emailUser" value="{{ $user->getEmailForPasswordReset() }}" required>

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
                                  <input id="claveUser" type="password" class="form-control" name="claveUser" required>

                                  @if ($errors->has('claveUser'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('claveUser') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group">
                              <label for="claveUser-confirm" class="col-md-4 control-label">Confirm Password</label>

                              <div class="col-md-6">
                                  <input id="claveUser-confirm" type="password" class="form-control" name="claveUser_confirmation" required>
                              </div>
                          </div>

													<div class="form-group">
														<label for="avatar" class="col-md-4 control-label">Avatar</label>

                            <div class="col-md-6">
                              <div class="row">
                                <div class="col-md-12">
                                  <img src="{{ Storage::disk('public')->url( ($user->avatar) ? $user->avatar : "avatars/default.png") }}"
                                   class="thumbnail miniatura" >
                                </div>

    														<div class="col-md-12">
                                  Selecciona para cambiar:
    										        	<input name="avatar" id="avatar" type="file" class="" value="">
    														</div>
                              </div>
                            </div>

                          <div class="form-group">
                              <div class="col-md-6 col-md-offset-4">
                                  <button type="submit" class="btn btn-primary">
                                      Guardar
                                  </button>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>

  

@endsection
