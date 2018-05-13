@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-md-6 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="row">
                    <div class="thumb-div">
                      <a href="#" class="thumbnail">
                          <img width="100%"
         src="{{ Storage::disk('public')->url( "img/logo.png") }}" alt="Logo">
                      </a>
                    </div>
                  </div>
                  <h3 class="panel-title text-center">Login</h3>
                </div>
                @if (session('logout'))
                 <div class="alert alert-info" role="alert">
                   {{ session('logout') }}
                 </div>
                @endif
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST"
                     action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div
                         class="form-group{{ $errors->has('loginUser') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="loginUser" type="text" class="form-control" name="loginUser" value="{{ old('loginUser') }}"  autofocus placeholder="User">

                                @if ($errors->has('loginUser'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('loginUser') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password"  placeholder="Password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-1">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-1">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
