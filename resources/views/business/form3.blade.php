<input type="hidden" name="no-use" id="period_liquidation_close"
 value="{{ isset($receipt) ? $receipt->periodLiquidationClose():''}}">
 
{!! Form::open(
  ['route' => ['receipt.store'],
  'method' => 'post', 'class' => 'form-horizontal',
  'enctype' => 'multipart/form-data', 'role' => 'form',
  'id' => 'store-receipt3'
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
          <label for="receipt_date">
            Fecha <i title="Requerido" class="fa fa-asterisk fa-fw"></i>
          </label>
          <input class="form-control form-date reset-mass" id="receipt_date"
           name="receipt_date" type="text" maxlength="10"
            value="{{ (isset($receipt)) ? $receipt->receipt_date :''}}">
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group" >
          <label for="client_query">
            Cliente
            <i title="Requerido" class="fa fa-asterisk fa-fw"></i>
          </label>
          <input class="form-control" id="client_query" name="client_name"
          autocomplete="off"
          value="{{ (isset($receipt)) ? $receipt->person_relationated->field_name1 :''}}">
          <ul></ul>
          <input type="hidden" id="person_id_relationed" name="person_id_relationed"
          value="{{ (isset($receipt)) ? $receipt->person_relationated->id :''}}">
          <input type="hidden" id="route-person-list" name="no-use"
           value="{{ route('persons.search', ['param' => '&param']) }}">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group" >
          <label for="code_ticket">
            Punto de venta <i title="Requerido" class="fa fa-asterisk fa-fw"></i>
          </label>
          <input class="form-control form-small" id="code_ticket" name="code_ticket"
           maxlength="4" type="text"
           value="{{ (isset($receipt)) ? $receipt->code_ticket :''}}">
         </div>
       </div>
       <div class="col-md-4">
         <div class="form-group">
           <label for="number">
             Número <i title="Requerido" class="fa fa-asterisk fa-fw"></i>
           </label>
           <input class="form-control form-small reset-mass" id="number" name="number"
           maxlength="8" type="text"
           value="{{ (isset($receipt)) ? $receipt->number :''}}">
         </div>
       </div>
       <div class="col-md-4">
         <div class="form-group">
           <label for="type_receipt_id">
             Tipo de comprobante
             <i title="Requerido" class="fa fa-asterisk fa-fw"></i>
           </label>
           <select class="form-control" id="type_receipt_id" name="type_receipt_id">
             <option value=""></option>
             @foreach ($receiptTypes as $key => $list)
                <option value="{{ $list->id }}"
                  {{ ( old('type_receipt_id', (isset($receipt)?
                      $receipt->type_receipt_id:'') )==$list->id ? 'selected':'') }}
                  >{{ $list->name }}</option>
             @endforeach
           </select>
         </div>
       </div>



       <div class="col-md-4">
         <div class="form-group">
           <label for="retention_type_id">
             Tipo
             <i title="Requerido" class="fa fa-asterisk fa-fw"></i>
           </label>
           <select class="form-control" id="retention_type_id" name="retention_type_id">
             <option value=""></option>
             @foreach ($retentionTypes as $key => $list)
                <option value="{{ $list->id }}"
                  {{ ( old('retention_type_id', (isset($receipt)?
                      $receipt->retention_type_id:'') )==$list->id ? 'selected':'') }}
                  >{{ $list->name }}</option>
             @endforeach
           </select>
         </div>
       </div>

       <div class="col-md-4">
         <div class="form-group">
           <label for="reference">
             Referencia <i title="Requerido" class="fa fa-asterisk fa-fw"></i>
           </label>
           <input class="form-control form-small reset-mass" id="reference" name="reference"
           maxlength="8" type="text"
           value="{{ (isset($receipt)) ? $receipt->reference :''}}">
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
