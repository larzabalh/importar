<input type="hidden" name="no-use" id="period_liquidation_close"
 value="{{ isset($receipt) ? $receipt->periodLiquidationClose():''}}">

{!! Form::open(
  ['route' => ['receipt.store'],
  'method' => 'post', 'class' => 'form-horizontal',
  'enctype' => 'multipart/form-data', 'role' => 'form',
  'id' => 'store-receipt'
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
          <label for="expiration_date">
            Fecha de vencimiento
          </label>
          <input class="form-control form-date reset-mass" id="expiration_date"
           name="expiration_date" type="text" maxlength="10"
           value="{{ (isset($receipt)) ? $receipt->expiration_date :''}}">
          <p class="help-block">Si se deja vacío se utiliza la fecha de la factura.</p>
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
                <option value="{{ $list->id }}" data-nt="{{$list->sell_no_taxabled}}"
                  {{ ( old('type_receipt_id', (isset($receipt)?
                    $receipt->type_receipt_id:'') )==$list->id ? 'selected':'') }}
                  >{{ $list->name }}</option>
             @endforeach
           </select>
         </div>
       </div>
       <div class="col-md-4">
         <div class="form-group" >
           <label  for="">
             Anulada<i title="Requerido" class="fa fa-asterisk fa-fw"></i>
           </label>
             <p>
               <label class="radio-inline">
                 <input  type="radio" name="status_id" class="form reset-mass"
                  value="1" id="status_id_n" {{ ( old('status_id', (isset($receipt)?
                    $receipt->status_id: 1) )==1 ? 'checked' :'' ) }}>No
               </label>
               <label class="radio-inline">
                 <input  type="radio" name="status_id" class="form reset-mass"
                  value="2" id="status_id_y" {{ ( old('status_id', (isset($receipt)?
                    $receipt->status_id:'') )==2 ? 'checked' :'' ) }}>Si
               </label>
             </p>
           </div>
         </div>
         <div class="col-md-4">
           <div class="form-group" >
             <label  for="">
               Zona
               <i title="Requerido" class="fa fa-asterisk fa-fw"></i>
             </label>
             <p class="help-block">Si se deja vacío se toma la zona de la compañía.</p>
             <select class="form-control" id="zone_id" name="zone_id">
               <option value=""></option>
               @foreach ($zones as $key => $list)
                  <option value="{{ $list->id }}"
                    {{ ( old('zone_id', (isset($receipt)?
                      $receipt->zone_id : $person->zone_id) )==$list->id
                       ? 'selected' :'' ) }}>{{ $list->name }}</option>
               @endforeach
             </select>
           </div>
         </div>
         <div class="col-md-4">
           <div class="form-group" >
             <label for="activity_id">
               Actividad (impuestos)
               <i title="Requerido" class="fa fa-asterisk fa-fw"></i>
             </label>
             <select class="form-control" id="activity_id" name="activity_id">
               <option value=""></option>
               @foreach ($activities as $key => $list)
                  <option value="{{ $list->id }}"
                   {{ ( old('activity_id', (isset($receipt)?
                   $receipt->activity_id:$person->activity_id) )==$list->id
                    ? 'selected' :'' ) }}
                    >{{ $list->name }}</option>
               @endforeach
             </select>
           </div>
         </div>
       </div>
     </div>
    </div>

  <!-- Panel for system taxes -->
    <div class="panel panel-default">
      <div class="panel-heading">IVA - INGRESOS BRUTOS</div>

      <div class="panel-body">

        <div id="alertsFlagIIBB">

        </div>
        @php $x=0; @endphp
        @foreach ($systemTaxes as $key => $list)
          @php $x++; @endphp
          <input type="hidden" name="iva[{{$list->id}}]" value="{{$list->iva}}">
          <input type="hidden" disabled name="no-use" id="percent_iva_{{$x}}"
            value="{{$list->percent_iva}}">
        <div class="row">

          <div class="col-lg-4">
            <div class="form-group">
              <label for="amount_{{$x}}">Monto {{$list->name}}</label>
              <input class="form-control form-small amount-group reset-mass" id="amount_{{$x}}"
               name="amount[{{$list->id}}]" type="text"
               data-nt="{{$list->taxable_iva}}"
               value="{{ isset($receiptTaxes[$list->id]['amount'])?
                  str_replace('.', ',',$receiptTaxes[$list->id]['amount'])
                 :'' }}">
            </div>
          </div>

        @if(($list->taxable_iva)==1)
          <div class="col-lg-4">
            <div class="form-group">
              <label for="iva_amount_{{$x}}">IVA del {{$list->percent_iva}}%</label>
              <input class="form-control form-small reset-mass" id="iva_amount_{{$x}}"
               name="iva_amount[{{$list->id}}]" type="text" readonly
              value="{{ ($receiptTaxes[$list->id]['tax_amount'])??'' }}" >
            </div>
          </div>
        @endif

          <div class="col-lg-4">
            <div class="form-group">
              <label for="">Grava II.BB. ({{ (($list->taxable_iva)==1)
                ? 'IVA '.($list->percent_iva).'%': $list->name }})</label>
              <p>
                <label class="radio-inline">
                  <input id="taxable_iibb_n_{{$x}}" type="radio"
                   name="taxable_iibb[{{$list->id}}]" class="form reset-mass"
                   value="1"
                   {{ ( old('taxable_iibb['.$list->id.']'
                    , (isset($receiptTaxes[$list->id])?
                     $receiptTaxes[$list->id]['taxable_iibb']:'')) )==1
                      ? 'checked' :''  }} >No
                </label>
                <label class="radio-inline">
                  <input id="taxable_iibb_y_{{$x}}" type="radio"
                   name="taxable_iibb[{{$list->id}}]" class="form reset-mass"
                   value="2" {{ ( old('taxable_iibb['.$list->id.']'
                    , isset($receiptTaxes[$list->id])?
                     $receiptTaxes[$list->id]['taxable_iibb']:'2') )==2
                      ? 'checked' :''  }} >Si
                </label>
              </p>
            </div>
          </div>
        </div>

      @endforeach

     </div>
   </div>
  </div>


    <!-- Panel for other taxes -->
  <div class="panel panel-default">
    <div class="panel-heading">Otros Impuestos</div>

    <div class="panel-body">
      <div class="row">
        <ul class="nav nav-tabs" id="myTab" role="tablist">

          @php $tabC=''; $x=0; @endphp
          @foreach ($tabsOtherTaxes as $key => $list)
            @php $x++; @endphp
            @if($tabC!=$list->section)
              @php $tabC=$list->section @endphp
              <li class="nav-item {{ ($x==1)?'active':'' }}">
                <a class="nav-link " id="{{$list->section}}-tab" data-toggle="tab"
                 href="#{{$list->section}}" role="tab" aria-controls="{{$list->section}}"
                  aria-selected="{{ ($x==1)?'true':'false' }}"
                  >{{$list->section_name}}</a>
              </li>
            @else

            @endif
          @endforeach

            </ul>

        <div class="tab-content" id="tab-content-ot">
          @php $tabC=''; $x=0; @endphp
          @foreach ($otherTaxes as $key => $list)
            @php $x++; @endphp
            @if($tabC!=$list->section)
              @php $tabC=$list->section @endphp
              @if($x!=1) </div> @endif
          <div class="tab-pane fade {{ ($x==1)?' active in':'' }}" id="{{$list->section}}"
             role="tabpanel" aria-labelledby="{{$list->section}}-tab">
            @endif

            <input type="hidden" name="apply_to[{{$list->id}}]" value="{{$list->iva}}">
            <input type="hidden" disabled name="no-use" id="percent_iva_{{$x}}"
              value="{{$list->percent_iva}}">

            <div class="col-lg-4">
              <div class="form-group">
                <label for="amount_other_{{$x}}">{{$list->name}}</label>
                <input class="form-control form-small reset-mass" id="amount_other_{{$x}}"
                 name="amount_other[{{$list->id}}]" type="text"
                 value="{{ isset($receiptTaxes[$list->id]['amount'])?
                    str_replace('.', ',',$receiptTaxes[$list->id]['amount'])
                   :'' }}">
              </div>
            </div>
          @endforeach
        </div>

          </div>

       </div>
     </div>

    {{ Form::close() }}
