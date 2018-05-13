<style>
  .flexb{
    display: flex;
    justify-content: space-between;
  }
</style>

<div id="alertsFlag"></div>

<div id="warningsFlag"></div>

<input type="hidden" disabled readonly style="width:100%" value="{{ $base }}"
 id="base_values" name="no-use">

<input type="hidden" name="no-use" id="open-settle-route"
 value="{{ route('settle.open') }}">

 <input type="hidden" id="find-settle-route"
   value="{{ route('settle.find', ['id'=> '&id']) }}">

<div id="div-lock-settle" class="bs-callout bs-callout-info center">
  <h4>¿Confirmar cerrar el Período?</h4>
  <button type="button" class="btn btn-labeled btn-danger"
    id="btn-lock-settle">
    <span class="btn-label"><i class="fa fa-lock"></i></span>
  Cerrar</button>
  <button type="button" class="btn btn-labeled btn-warning"
    id="btn-cancel-lock">
    <span class="btn-label"><i class="fa fa-close"></i></span>
  Cancelar</button>
</div>

{!! Form::open(
  ['route' => ['settle.store'],
  'method' => 'post', 'class' => 'form-horizontal',
  'enctype' => 'multipart/form-data', 'role' => 'form',
  'id' => 'store-settle'
  ]) !!}

<input type="hidden" id="previous_period_id"
 value="{{ ($previousPeriod)!==null ?
    $previousPeriod->period->id : ''}}">
<input type="hidden" id="previous_period_liquidation_id"
 value="{{ ($previousPeriod)!==null ?
    $previousPeriod->id : '' }} ">
<input type="hidden" id="previous_period_liquidation_status"
 value="{{ ($previousPeriod)!==null ?
    $previousPeriod->status : '' }}">



<input type="hidden" name="period_id" id="period_id"
 value="{{ $settle->period_id }}">
<input type="hidden" name="period_liquidation_id" id="period_liquidation_id"
 value="{{ $settle->id }}">

<input type="hidden" name="status" id="status" value="{{ ($settle)?$settle->status :1 }}">

<input type="hidden" name="apply_to" value="iibb">
<div class="modal-body" id="modal-report-body" style="overflow-y: auto;">
   <div id="reportBody" class="report">
      <p>Del {{ $settle->period->date_from }} al {{ $settle->period->date_to }}</p>
      <table class="table table-striped table-bordered table-hover"
        id="settle-detail" style="min-width: 950px;">
        <thead>
         <tr class="st4">
            <td class="">Jurisdicción</td>
            <td class="ac nw">Coef.</td>
            <td class="ac nw">Alíc. %</td>
            <td class="ac nw">Base imp.</td>
            <td class="ac nw">Impuesto</td>
            <td class="ac nw">Saldo a favor ant.</td>
            <td class="ac nw">SIRCREB</td>
            <td class="ac nw">Retenciones</td>
            <td class="ac nw">Percepciones</td>
            <td class="ac nw">A pagar</td>
            <td class="ac nw">A favor</td>
         </tr>
       </thead>

       <tbody>
        @php $x=0; @endphp
         @foreach ($personZones as $key => $value)
           @php $x++;
           /* esto lo hago si es recalculado o por primera vez */
           $sifere_coef = $value->sifere_coef;
           $iibb_aliquot = $value->iibb_aliquot;
           $amount = $sircreb = $retention = $perception = 0.00;
           $previous = $value->previous_period_balance ??'0.00';
           if($value->period_liquidation_detail_id){
             $amount = $value->base_amount;
             $sircreb = $value->sircreb_amount;
             $retention = $value->retention_amount;
             $perception = $value->perception_amount;
             $negative = $value->negative_amount;
             $positive = $value->positive_amount;
             $tax = $value->tax_amount;
           }else if(isset($base[$key])) {
             $amount = isset($baseEquals) ? $baseEquals->base_amount :
             (isset($base[$key]) ? $base[$key]->base_amount : '0.00');
             $sircreb = $base[$key]->sircreb_amount;
             $retention = $base[$key]->retention_amount;
             $perception = $base[$key]->perception_amount;
             $tax = ($amount*$sifere_coef*($iibb_aliquot/100));
             $result = $tax - $previous - $sircreb - $retention -$perception;
             $negative = $result>0 ? $result :'0.00';
             $positive = $result<0 ? $result*(-1) :'0.00';
           }else{
             $sifere_coef = $value->sifere_coef;
             $iibb_aliquot = $value->iibb_aliquot;
             $tax = ($amount*$sifere_coef*($iibb_aliquot/100));
             $result = $tax - $previous - $sircreb - $retention -$perception;
             $negative = $result>0 ? $result :'0.00';
             $positive = $result<0 ? $result*(-1) :'0.00';
           }




           @endphp
           <tr>
             <td>{{ $value->zone->name }}
               <input type="hidden" name="period_liquidation_id[]"
                value="{{ $value->period_liquidation_detail_id }}">
              <input type="hidden" id="zone_id_{{ $key }}" value="{{$x}}" name="no-use" />
             </td>
             <td><input class="form-control form-small reset-mass" id="coef_{{$x}}"
              name="coef[{{$key}}]" type="text"
              value="{{ str_replace('.', ',',$sifere_coef) }}"></td>
             <td><input class="form-control form-small reset-mass" id="aliquot_{{$x}}"
              name="aliquot[{{$key}}]" type="text"
              value="{{ str_replace('.', ',',$iibb_aliquot) }}"></td>
             <td><input class="form-control form-small  mass-able" id="base_amount_{{$x}}"
              name="base_amount[{{$key}}]" type="text"
              value="{{ str_replace('.', ',',$amount) }} "></td>
             <td><input class="form-control form-small mass-able" id="tax_amount_{{$x}}"
              name="tax_amount[{{$key}}]" type="text"
              value="{{ isset($tax)?str_replace('.', ',',$tax):'0,00' }}"></td>
             <td><input class="form-control form-small mass-able" id="previous_period_balance_{{$x}}"
              name="previous_period_balance[{{$key}}]" type="text"
              value="{{ str_replace('.', ',',$previous) }}"></td>
             <td><input class="form-control form-small reset-mass" id="sircreb_amount_{{$x}}"
              name="sircreb_amount[{{$key}}]" type="text"
              value="{{ str_replace('.', ',',$sircreb) }}"></td>
             <td><input class="form-control form-small reset-mass" id="retention_amount_{{$x}}"
              name="retention_amount[{{$key}}]" type="text"
              value="{{ str_replace('.', ',',$retention) }}"></td>
             <td><input class="form-control form-small reset-mass" id="perception_amount_{{$x}}"
              name="perception_amount[{{$key}}]" type="text"
              value="{{ str_replace('.', ',',$perception) }}"></td>
             <td><input class="form-control form-small  mass-able" id="negative_amount_{{$x}}"
              name="negative_amount[{{$key}}]" type="text"
              value="{{ str_replace('.', ',',$negative) }}"></td>
             <td><input class="form-control form-small  mass-able" id="positive_amount_{{$x}}"
              name="positive_amount[{{$key}}]" type="text"
              value="{{ str_replace('.', ',',$positive) }}"></td>
           </tr>
         @endforeach

       </tbody>
      </table>
   </div>
</div>

{{ Form::close() }}
