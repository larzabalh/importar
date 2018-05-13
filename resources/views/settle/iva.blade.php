<link rel="stylesheet" href="{{ asset('css/admin/settle/iva.css') }}">

<div id="alertsFlag"></div>

<div id="warningsFlag"></div>

<input type="hidden" disabled readonly style="width:100%" value="{{ $details }}"
 id="base_values" name="no-use">

<input type="hidden" id="recalculated_values" name="no-use"
  value="{{ json_encode($liquidationIVARetPerComp) }}">
<input type="hidden" id="prev_liquidation_values" name="no-use"
  value="{{ $prevPeriodLiquidationIVA??'' }}">

<!-- routes -->
<input type="hidden" id="recalculate-settle-route"
  value="{{ route('settle.recalculate', [ 'type'=>'iva',
    'period_liquidation_id'=> '&period_liquidation_id', 'person_id'=>'&person_id']) }}">

<input type="hidden" id="open-settle-route"
 value="{{ route('settle.open') }}">

 <input type="hidden" id="find-settle-route"
   value="{{ route('settle.find', ['id'=> '&id']) }}">
<!-- end routes -->


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
 value="{{ 'previous_period'}}">

<input type="hidden" name="period_id" id="period_id"
 value="{{ $settle->period_id }}">
<input type="hidden" name="period_liquidation_id" id="period_liquidation_id"
 value="{{ $settle->id }}">
<input type="hidden" name="period_liquidation_iva_id" id="period_liquidation_iva_id"
 value="{{ ($periodLiquidationIVA) ? $periodLiquidationIVA->id : '' }}">

<input type="hidden" name="status" id="status" value="{{ ($settle)?$settle->status :1 }}">

<input type="hidden" name="apply_to" value="iva">
<div class="modal-body" id="modal-report-body" style="overflow-y: auto;">
   <div id="reportBody" class="report">
      <p>Del {{ $settle->period->date_from }} al {{ $settle->period->date_to }}</p>
      <div class="row">
        <div class="col-sm-12 col-md-6">
          <div class="" id="settle-detail">
          <div class="panel-group">


             @php $type='';$ordr=''; $debit=0; $credit=0; $x=0; @endphp
             @foreach ($details as $list)
               <?php
                $tax_amount=0; $x++;
                $percent_iva =  $perLiqIVADet ?
  ($perLiqIVADet[$list->ordr.'-'.$list->activity_id.'-'.$list->type.'-'.$list->id]['iva_amount'])
                  : $list->percent_iva;
                $taxabled_amount = $perLiqIVADet ?
  ($perLiqIVADet[$list->ordr.'-'.$list->activity_id.'-'.$list->type.'-'.$list->id]['taxabled_amount'])
                  :  $list->taxabled_amount;
               $tax_amount = round((($percent_iva/100)*$taxabled_amount), 2);
               if($list->type==1){ $debit += $tax_amount; }
               else if($list->type==2){ $credit += $tax_amount; }
               ?>
            @if($list->type != $type)
              <?php $inside=0; $type = $list->type;
              if($inside==0){ echo '</tbody></table></div></div>'; }
               if($x!=1){ echo '</div></div>'; }  /*close prev div */ ?>
            <div class="panel panel-default section-data">
              <div class="panel-heading">
    						<h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion"
                   href="#T{{$list->type}}" aria-expanded="true"
                    class="title-section">
                    {{ App\Models\PeriodLiquidation::getTypeIVA($list->type) }}</a>
    						</h4>
    					</div>
              <div class="panel-body collapse in"
               aria-expanded="" id="T{{$list->type}}">

            @endif

            @if($list->ordr!=$ordr)
              <?php $inside++; $ordr = $list->ordr;
               if($inside!=1){ echo '</tbody></table></div></div>'; }  /*close prev div */ ?>

               <div class="panel panel-default">
                 <div class="panel-heading">
       						<h4 class="panel-title">
                     <a data-toggle="collapse" data-parent="#accordion"
                      href="#G{{$list->ordr}}" aria-expanded="true" id="flexb">
                       <span>{{ App\Models\PeriodLiquidation::getGroupIVA($list->ordr) }}</span>
                       <span class="amount"></span>
                    </a>

       						</h4>
       					 </div>
                 <div class="panel-body collapse {{ ($inside==1)? 'in': ''}}"
                  aria-expanded="{{ ($inside==1)? 'true': ''}}" id="G{{$list->ordr}}">

              @php
                $titles=App\Models\PeriodLiquidation::getTitlesIVA($list->ordr);
              @endphp
               <table class="table table-bordered table-triped">
                 <thead>
                     <th class="ac nw">{{$titles[0]}}</th>
                     <th class="ac nw">{{$titles[1]}}</th>
                     <th class="ac nw">{{$titles[2]}}</th>
                  </tr>
                </thead>
                <tbody>

            @else

            @endif

                <tr>
                 <td class="">
                   {{ $list->name }}
                   <input type="hidden" name="tax_id[{{$x}}]" value="{{$list->id}}">
                   <input type="hidden" name="type[{{$x}}]" value="{{$list->type}}">
                   <input type="hidden" name="activity_id[{{$x}}]" value="{{$list->activity_id}}">
                   <input type="hidden" name="iva_amount[{{$x}}]" value="{{$percent_iva}}">
                   <input type="hidden" name="ordr[{{$x}}]" value="{{$list->ordr}}">
                   <input type="hidden" value="{{$x}}"
                    id="item_{{$list->ordr.'_'.$list->activity_id.'_'.$list->type.'_'.$list->id}}">
                 </td>
                 <td class="ac nw">
                   <input type="text" class="form-control" name="no-use"
                   value="{{ (($list->ordr!=2) ? $taxabled_amount:($taxabled_amount+$tax_amount))}}"
                   id="item_col1_{{$x}}">
                   <input type="hidden" value="{{ $taxabled_amount }}"
                     name="taxabled_amount[{{$x}}]" id="item_taxabled_{{$x}}"></td>
                 <td class="ac nw">
                   <input type="text"
                    class="form-control {{ ($list->ordr==3) ? 'hidden' : 'show'}}"
                    value="{{ $tax_amount }}"
                    name="tax_amount[{{$x}}]" id="item_tax_{{$x}}"></td>
               </tr>
             @endforeach

           </tbody></table></div></div>

           </div>
        </div>
      </div>
<?php
//dd($prevPeriodLiquidationIVA);
  $previous_technical = $periodLiquidationIVA ? $periodLiquidationIVA->previous_technical
    : ($prevPeriodLiquidationIVA->positive_amount ?? 0);
  $technical_balance = $periodLiquidationIVA ? $periodLiquidationIVA->technical_balance
    : ($credit + $previous_technical - $debit); //saldo tecnico del periodo
  $previous_free_availability = $periodLiquidationIVA ?
   $periodLiquidationIVA->previous_free_availability
    : ($prevPeriodLiquidationIVA->total_free_availability ?? 0);

  $retention_amount = $periodLiquidationIVA ? $periodLiquidationIVA->retention_amount
    : ($liquidationIVARetPerComp->retention_amount ?? 0);
  $perception_amount = $periodLiquidationIVA ? $periodLiquidationIVA->perception_amount
    : $liquidationIVARetPerComp->perception_amount ?? 0;
  $compensation_amount = $periodLiquidationIVA ? $periodLiquidationIVA->compensation_amount
    : ($liquidationIVARetPerComp->compensation_amount ?? 0);

  $total_perceptions_retentions = $periodLiquidationIVA
   ? $periodLiquidationIVA->total_perceptions_retentions
    : ($retention_amount + $perception_amount);

  $free_availability_balance = $periodLiquidationIVA
   ? $periodLiquidationIVA->free_availability_balance
    : ($total_perceptions_retentions + $previous_free_availability - $compensation_amount);

$negative_amount = $periodLiquidationIVA
 ? $periodLiquidationIVA->negative_amount
  : (($technical_balance+$free_availability_balance>0) ? 0 :
  ($technical_balance+$free_availability_balance)*(-1));
$positive_amount = $periodLiquidationIVA
 ? $periodLiquidationIVA->positive_amount
  : (($technical_balance>0) ? $technical_balance : 0);
$total_free_availability = $periodLiquidationIVA
 ? $periodLiquidationIVA->total_free_availability
  : (($technical_balance+$free_availability_balance>0)
  ? (($technical_balance>0) ? $free_availability_balance
    : ($technical_balance+$free_availability_balance))
  : 0);

 ?>
        <div class="col-sm-12 col-md-6">
          <div>Resumen</div>
          <table class="table table-bordered table-hover">
            <tr>
              <td>TOTAL DEBITO</td>
              <td><input class="form-control mass-able" type="text" name="total_debit"
                 id="total_debit" value="{{ number_format($debit,2) }}"></td>
            </tr>
            <tr>
              <td>TOTAL CREDITO</td>
              <td><input class="form-control mass-able" type="text" name="total_credit"
                 id="total_credit" value="{{ number_format($credit,2) }}"></td>
            </tr>
            <tr class="info-strong">
              <td>SALDO TECNICO ANTERIOR</td>
              <td><input class="form-control mass-able" type="text" name="previous_technical"
                 id="previous_technical" value="{{ number_format($previous_technical,2) }}"></td>
            </tr>
            <tr>
              <td>SALDO TECNICO DEL PERIODO</td>
              <td><input class="form-control mass-able" type="text" name="technical_balance"
                 id="technical_balance" value="{{ number_format($technical_balance,2) }}"></td>
            </tr>
            <tr class="tr-sep"><td colspan="2"></td></tr>
            <tr>
              <td>SALDO DE LIBRE DISPONIBILIDAD ANTERIOR</td>
              <td><input class="form-control mass-able" type="text" name="previous_free_availability"
                 id="previous_free_availability" value="{{ number_format($previous_free_availability,2) }}"></td>
            </tr>
            <tr class="info">
              <td>RETENCIONES DEL SISTEMA</td>
              <td><input class="form-control mass-able" type="text" name="retention_amount"
                 id="retention_amount" value="{{ number_format($retention_amount,2) }}"></td>
            </tr>
            <tr class="info">
              <td>PERCEPCIONES DEL SISTEMA</td>
              <td><input class="form-control mass-able" type="text" name="perception_amount"
                 id="perception_amount" value="{{ number_format($perception_amount,2) }}"></td>
            </tr>
            <tr class="info">
              <td>COMPENSACIONES</td>
              <td><input class="form-control mass-able" type="text" name="compensation_amount"
                 id="compensation_amount" value="{{ number_format($compensation_amount,2) }}"></td>
            </tr>
            <tr class="info">
              <td>TOTAL DE PERCEPCIONES/ RETENC</td>
              <td><input class="form-control mass-able" type="text" name="total_perceptions_retentions"
                 id="total_perceptions_retentions" value="{{ number_format($total_perceptions_retentions,2) }}"></td>
            </tr>
            <tr>
              <td>SALDO DE LIBRE DISPONIBILIDAD DEL PERIODO</td>
              <td><input class="form-control mass-able" type="text" name="free_availability_balance"
                 id="free_availability_balance" value="{{ number_format($free_availability_balance,2) }}"></td>
            </tr>
            <tr class="tr-sep"><td colspan="2"></td></tr>
            <tr class="active">
              <td>a Pagar</td>
              <td><input class="form-control mass-able edit-able" type="text" name="negative_amount"
                 id="negative_amount" value="{{ number_format($negative_amount,2) }}"></td>
            </tr>
            <tr class="active">
              <td>Saldo tecnico</td>
              <td><input class="form-control mass-able edit-able" type="text" name="positive_amount"
                 id="positive_amount" value="{{ number_format($positive_amount,2) }}"></td>
            </tr>
            <tr class="active">
              <td>Saldo de Libre Disponibilidad</td>
              <td><input class="form-control mass-able edit-able" type="text" name="total_free_availability"
                 id="total_free_availability" value="{{ number_format($total_free_availability,2) }}"></td>
            </tr>

          </table>


        </div>


      </div>
   </div>
</div>

{{ Form::close() }}
