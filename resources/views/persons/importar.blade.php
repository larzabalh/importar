@extends('layouts.dashboard')

@section('add-css')

  <link rel="stylesheet" href="{{ asset('css/admin/masters/business.css') }}">

@endsection

@section('title')
  IMPORTAR
@endsection

@section('content')

<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token_datatable">
<div class="container box">
   <h1 align="center">IMPORTAR</h1><br />
   <input type="text" id="route-importar-persons" name="no-use" value="{{ route('importar.persons') }}">
   <div class="table-responsive"><br/>
      <div class="row">
        <div class="col-lg-12">
          <form name="" id="formulario" method="POST" class="formarchivo" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token" />
              {{ csrf_field() }}
              <div class="col-lg-6">
                  <label>IMPORTAR:</label><br>
                  <H1 id="OK"></H1>
                  <select class="form-control" id="importar">
                    <option selected></option>
                    <option value='persons'>persons</option>
                  </select>
              </div>
            <div class="form-group col-lg-2 col-md-3 col-sm-3 col-xs-12">
              <input type="file" id="archivo" name="archivo" required>
              <button type="submit" class="btn btn-primary">Cargar Datos</button>
            </div>
            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
              <h4 id="total"></h4>
            </div>
          </form>
        </div>
      </div>
            <div id="alert_message"></div>
  </div>
</div>

@endsection

@section('links')

@endsection


@section('add-js')
  <script src="{{ asset('js/importar.js') }}"></script>
@endsection