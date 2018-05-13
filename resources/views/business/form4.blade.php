<input type="hidden" name="no-use" id="period_liquidation_close"
 value="{{ isset($receipt) ? $receipt->periodLiquidationClose():''}}">
 
{!! Form::open(
  ['route' => ['receipt.store'],
  'method' => 'post', 'class' => 'form-horizontal',
  'enctype' => 'multipart/form-data', 'role' => 'form',
  'id' => 'store-receipt4'
  ]) !!}
  <div id="alertsFlag">

  </div>
<div class="panel panel-default">
  <div class="panel-heading">Información básica</div>
  <input type="hidden" name="type_id" value="{{ $type_id }}">
  @if(isset($receipt))
    <input type="hidden" id="receipt_id" name="receipt_id" value="{{$receipt->id}}">
  @endif
  <div class="panel-body">

    <div class="row" id="tax-invoice-tabs0-0">
      <div class="col-md-4">
        <div class="form-group" >
          <label for="period_query">
            Período <i title="Requerido" class="fa fa-asterisk fa-fw"></i>
          </label>
          <input class="form-control" id="period_query" name="period_code"
           autocomplete="off" value="{{ (isset($receipt)) ? $receipt->period->code :''}}">
          <ul></ul>
          <input type="hidden" id="period_id" name="period_id"
           value="{{ (isset($receipt)) ? $receipt->period->id :''}}">
          <input type="hidden" id="route-period-list" name="no-use"
           value="{{ route('periods.search', ['param' => '&param']) }}">
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group" >
          <label  for="">
            Zona
            <i title="Requerido" class="fa fa-asterisk fa-fw"></i>
          </label>
          <select class="form-control" id="zone_id" name="zone_id">
            <option value=""></option>
            @foreach ($zones as $key => $list)
               <option value="{{ $list->id }}"
                 {{ ( old('zone_id', (isset($receipt)?
                   $receipt->zone_id : '') )==$list->id
                    ? 'selected' :'' ) }}>{{ $list->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

       <div class="col-md-4">
         <div class="form-group">
           <label for="amount">
             Monto <i title="Requerido" class="fa fa-asterisk fa-fw"></i>
           </label>
           <input class="form-control form-small reset-mass" id="amount" name="amount"
           type="text" value="{{ isset($receipt) ?
              str_replace('.', ',',$receipt->amount):'' }}">
         </div>
       </div>

     </div>
   </div>
  </div>

    {{ Form::close() }}
