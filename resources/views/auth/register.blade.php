@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('loginUser') ? ' has-error' : '' }}">
                            <label for="loginUser" class="col-md-4 control-label">User</label>

                            <div class="col-md-6">
                                <input id="loginUser" type="text" class="form-control" name="loginUser" value="{{ old('loginUser') }}" required>

                                @if ($errors->has('loginUser'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('loginUser') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('emailUser') ? ' has-error' : '' }}">
                            <label for="emailUser" class="col-md-4 control-label">E-mail</label>

                            <div class="col-md-6">
                                <input id="emailUser" type="text" class="form-control" name="emailUser" value="{{ old('emailUser') }}" required>

                                @if ($errors->has('emailUser'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('emailUser') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="claveUser" required>

                                @if ($errors->has('claveUser'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('claveUser') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="claveUser_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
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
