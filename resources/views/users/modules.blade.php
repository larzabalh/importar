@extends('layouts.dashboard')

@section('title')
<a href="{{ route('users.index') }}" id="back-item">
  <i class="fa fa-chevron-circle-left fa-fw"></i>
</a>
 User: {{ $user->getNameUser()  }}
@endsection

@section('content')

  <div class="container">
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Módulos del Sistema</h3>
            </div>
            <div class="panel-body">

              @if (session('statusModules'))
    					    <div class="alert alert-success alert-dismissable animate-alert-top fade in">
    								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
    									<i class="fa fa-close" aria-hidden="true" title="Cerrar"></i>
    								</button>
    					       {{ session('statusModules') }}
    					    </div>
    					@endif

              {!! Form::open(
  							['route' => ['users.modulesStore', $user->idField() ],
  						  'method' => 'put', 'class' => 'form-horizontal',
  						  'enctype' => 'multipart/form-data', 'role' => 'form',
  						  'id' => 'modules-form'
  						  ]) !!}

                @php
                 $first = true; $parent='';
                @endphp

                @foreach ($modules as $module)
                  @if($module->idParent == $module->idModule)
                    @if($first!==true)
                      </div>
                    @endif
                      <div class="parent panel panel-default">
                        <div class="panel-heading">{{ $module->nameModule }}</div>
                    @php
                      $first = false;
                    @endphp
                  @else
                    <div class="panel-child">
                      {{ Form::label($module->nameModule, $module->nameModule,
                         ['class' => 'control-label']) }}
                      {{ Form::select('idModule['.$module->idModule.']',
                         ['1' => 'Si', '0' => 'No'],
                         (isset($module->selected)) ?'1':'0',
                         ['class'=>'form-control'] ) }}
                    </div>
                  @endif
                @endforeach
                @if($first===false)
                  </div>
                @endif

                <div class="form-group text-center">
                   {{ Form::submit('Guardar', ['class' => 'btn btn-primary']) }}
                </div>

              {{ Form::close() }}
            </div>
          </div>
        </div>
      </div>
  </div>



@endsection

@section('add-css')
<link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">

<link rel="stylesheet" href="{{ asset('js/tooltipster/css/tooltipster.bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/tooltipster/css/tooltipster-sideTip-light.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/admin/users.css') }}">
@endsection

@section('add-js')

<script src="{{ asset('js/jquery-validation/dist/jquery.validate.min.js') }}" ></script>
<script src="{{ asset('js/jquery-validation/dist/additional-methods.js') }}" ></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery-masked.min.js') }}"></script>

<script src="{{ asset('js/tooltipster/js/tooltipster.bundle.min.js') }}"></script>

<script src="{{ asset('js/admin/users/modules.js') }}" ></script>
@endsection
