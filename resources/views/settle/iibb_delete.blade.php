<style>
#settle-detail{
  table-layout: auto;
}
.center{
  text-align: center;
}
.fa-warning{
  margin-right: 20px;
}
</style>

<div id="alertsFlag"></div>

<div id="warningsFlag"></div>

{!! Form::open(
  ['route' => ['settle.confirmDelete'],
  'method' => 'delete', 'class' => 'form-horizontal',
  'enctype' => 'multipart/form-data', 'role' => 'form',
  'id' => 'delete-settle'
  ]) !!}

<input type="hidden" id="period_liquidation_id" name="period_liquidation_id"
 value="{{ $periodLiquidation->id }}">

<div class="alert alert-danger" role="alert">
  <span class="fa fa-warning"></span>Este Cambio No se puede deshacer
</div>

{{ Form::close() }}
