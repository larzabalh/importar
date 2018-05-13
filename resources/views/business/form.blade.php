<div id="alertsFlag">

</div>

{!! Form::open(
  ['route' => ['business.store'],
  'method' => 'post', 'class' => 'form-horizontal',
  'enctype' => 'multipart/form-data', 'role' => 'form',
  'id' => 'store-business'
  ]) !!}

@if($business)
  <input type="hidden" id="person_id" name="person_id" value="{{ $business->id }}">
  <input type="hidden" id="person_configuration_id" name="person_configuration_id"
   value="{{ $businessConfiguration->id??'' }}">
@endif

<div class="panel panel-default">

  <div class="row">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item active">
        <a class="nav-link " id="datos-tab" data-toggle="tab"
         href="#datos" role="tab" aria-controls="datos"
          aria-selected="true" aria-expanded="true">Datos</a>
      </li>

      <li class="nav-item">
        <a class="nav-link " id="obligaciones-tab" data-toggle="tab"
         href="#obligaciones" role="tab" aria-controls="obligaciones"
          aria-selected="true">Obligaciones</a>
      </li>


      <li class="nav-item">
        <a class="nav-link " id="configuracion-tab" data-toggle="tab"
         href="#configuracion" role="tab" aria-controls="configuracion"
          aria-selected="true">Configuración</a>
      </li>


      <li class="nav-item">
        <a class="nav-link " id="claves-tab" data-toggle="tab"
         href="#claves" role="tab" aria-controls="claves"
          aria-selected="true">Claves</a>
      </li>

    </ul>

    <div class="tab-content" id="tab-content-ot">

      <div class="tab-pane fade active in" id="datos"
       role="tabpanel" aria-labelledby="datos-tab">

          <div class="row">

            <div class="col-md-2">
              <div class="form-group" >
                <label for="person_configuration_id">
                  ID
                </label>
                <input class="form-control" name="person_configuration_id" id="person_configuration_id"
                 autocomplete="off" value="{{ ($business) ? $business->configuration[0]->id :''}}" readonly>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="document_type">
                  Documento<i title="Requerido" class="fa fa-asterisk fa-fw"></i>
                </label>
                <div class="form-inline">
                  <select class="form-control" id="document_type" name="document_type">
                    <option value=""></option>
                    @foreach ($documentTypes as $key => $list)
                       <option value="{{ $list }}"
                         {{ ( old('document_type', ($business?
                           strtoupper($business->document_type):'') )==$list ? 'selected':'') }}
                         >{{ $list }}</option>
                    @endforeach
                  </select>

                  <input type="text" class="form-control" name="document" id="document"
                   autocomplete="off" value="{{ ($business) ? $business->document :''}}">

                   <button type="button" id="search_person" class="btn btn-primary">
                     <span class="fa fa-search" title="Buscar"></span>
                     Buscar</button>

                 </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group" >
                <label for="client_query">
                  Razon Social
                  <i title="Requerido" class="fa fa-asterisk fa-fw"></i>
                </label>
                <input class="form-control" id="field_name1" name="field_name1"
                autocomplete="off" type="text"
                value="{{ ($business) ? $business->field_name1 :''}}">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group" >
                <label for="" id="active-group">
                  Activo<i title="Requerido" class="fa fa-asterisk fa-fw"></i>
                </label>
                <div class="form-group" style="height: 34px;">
                  <label class="radio-inline">
                    <input  type="radio" name="active" class="form reset-mass"
                     value="1" id="active" {{ ( old('active', (($business && $business->configuration[0])?
                       $business->configuration[0]->active: '') )==1 ? 'checked' :'' ) }}>No
                  </label>
                  <label class="radio-inline">
                    <input  type="radio" name="active" class="form reset-mass"
                     value="2" id="active" {{ ( old('active', (($business && $business->configuration[0])?
                       $business->configuration[0]->active:'2') )==2 ? 'checked' :'' ) }}>Si
                  </label>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label for="person_type_id">
                  Tipo de Persona<i title="Requerido" class="fa fa-asterisk fa-fw"></i>
                </label>
                  <select class="form-control" id="person_type_id" name="person_type_id">
                    <option value=""></option>
                    @foreach ($personTypes as $key => $list)
                       <option value="{{ $list->id }}"
                         {{ ( old('person_type_id', ($business?
                           $business->person_type_id:'') )==$list->id ? 'selected':'') }}
                         >{{ $list->description }}</option>
                    @endforeach
                  </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label for="iva_condition_id">
                  Condición frente al IVA<i title="Requerido" class="fa fa-asterisk fa-fw"></i>
                </label>
                  <select class="form-control" id="iva_condition_id" name="iva_condition_id">
                    <option value=""></option>
                    @foreach ($ivaConditions as $key => $list)
                       <option value="{{ $list->id }}"
                         {{ ( old('iva_condition_id', ($business?
                           $business->configuration[0]->iva_condition_id:'') )==$list->id ? 'selected':'') }}
                         >{{ $list->description }}</option>
                    @endforeach
                  </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label for="month_close">
                  Mes de Cierre<i title="Requerido" class="fa fa-asterisk fa-fw"></i>
                </label>
                  <select class="form-control" id="month_close" name="month_close">
                    <option value=""></option>
                    @foreach ($months as $key => $list)
                       <option value="{{ $key }}"
                         {{ ( old('month_close', ($business?
                           $business->configuration[0]->month_close:'') )==$key ? 'selected':'') }}
                         >{{ $list }}</option>
                    @endforeach
                  </select>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label for="address"> Domicilio </label>
                <textarea class="form-control form-textarea" id="address"
                 name="address">{{ ($business) ? $business->address :''}}</textarea>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="bs-callout bs-callout-info" id="callout-xref-input-group">
                <div class="row">

                  <div class="col-sm-6">
                    <h4><span>Actividades</span></h4>

                    <div class="cincuentas">
                      <div class="">
                        <select class="form-control" id="activity_id" name="activity_id">
                          <option value=""></option>
                          @foreach ($activities as $key => $list)
                             <option value="{{ $list->id }}">{{ $list->name }}</option>
                          @endforeach
                        </select>
                        <input type="hidden" id="activity_quantity" name="activity_quantity"
                         value="{{count($businessActivities)}}">
                      </div>
                      <div class="">
                        <button class="dt-button btn btn-info" id="btn-add-activity"
                          type="button">
                          <span class="fa fa-plus fa-fw"></span>Agregar</button>

                      </div>
                    </div>

                  </div>

                  <div class="col-sm-6">
                    <table class="table table-striped table-border">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Ops</th>
                        </tr>
                      </thead>
                      <tbody id="data-activities">
                        @foreach ($businessActivities as $key => $list)
                        <tr id="tr_activity_{{$list->activity_id}}">
                          <td>
                            <span>{{ $list->name }}</span>
                            <input type="hidden" name="activity_id[{{$list->activity_id}}]"
                             value="{{$list->activity_id}}" class="no-val">
                          </td>
                          <td>
                            <button type="button" class="receipt-edit btn btn-danger"
                            id="delete_activity_{{$list->activity_id}}"
                            data-id="{{$list->activity_id}}" data-text="{{ $list->name }}">
                              <i class="fa fa-trash-o"></i></button>
                            <!--<button type="button" class="receipt-edit btn btn-default">
                              <i class="fa fa-thumbs-up"></i></button>-->
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>

                  </div>

                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="bs-callout bs-callout-info" id="callout-xref-input-group">
                <div class="row">
                  <div class="col-sm-5">
                    <h4><span>Zonas</span></h4>
                    <div class="cincuentas">
                      <div class="">
                        <select class="form-control" id="zone_id" name="zone_id" >
                          <option value=""></option>
                          @foreach ($zones as $key => $list)
                             <option value="{{ $list->id }}">{{ $list->name }}</option>
                          @endforeach
                        </select>
                        <input type="hidden" id="zone_quantity" name="zone_quantity"
                         value="{{count($businessZones)}}">
                      </div>
                      <div class="">
                        <button class="dt-button btn btn-info" id="btn-add-zone"
                          type="button">
                          <span class="fa fa-plus fa-fw"></span>Agregar</button>
                      </div>
                    </div>

                  </div>

                  <div class="col-sm-7">
                    <table class="table table-striped table-border">
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Coef.</th>
                          <th>Aliq.</th>
                          <th>Ops</th>
                        </tr>
                      </thead>
                      <tbody id="data-zones">
                        @foreach ($businessZones as $key => $list)
                        <tr id="tr_zone_{{$list->zone_id}}">
                          <td>
                            <span>{{ $list->name }}</span>
                            <input type="hidden" name="zone_id[{{$list->zone_id}}]"
                             value="{{$list->zone_id}}" class="no-val">
                          </td>
                          <td>
                            <input type="text" name="sifere_coef[{{$list->zone_id}}]"
                            value="{{$list->sifere_coef}}"
                             class="form-control">
                          </td>
                          <td>
                            <input type="text" name="iibb_aliquot[{{$list->zone_id}}]"
                             value="{{ number_format($list->iibb_aliquot, 2, '.', ',') }}"
                             class="form-control">
                          </td>
                          <td>
                            <button type="button" class="receipt-edit btn btn-danger"
                            id="delete_zone_{{$list->zone_id}}"
                            data-id="{{$list->zone_id}}" data-text="{{ $list->name }}">
                              <i class="fa fa-trash-o"></i></button>
                            <!--<button type="button" class="receipt-edit btn btn-default"
                              type="button">
                              <i class="fa fa-thumbs-up"></i></button>-->
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>

                  </div>

                </div>
              </div>
            </div>
          </div>

        </div>

      <div class="tab-pane fade " id="obligaciones"
       role="tabpanel" aria-labelledby="obligaciones-tab">

       <div class="row">
         <div class="col-sm-12">
           <div class="bs-callout bs-callout-info" id="callout-xref-input-group">
             <div class="row">
               <div class="col-sm-12">
                 <h4>Reportes</h4>
               </div>
             </div>
             <div class="row">
               <div class="col-sm-2 checkbox">
                 <label>
                   <input type="checkbox" id="obligation_sell" name="obligation_sell"
                   {{ ($businessConfiguration && $businessConfiguration->obligation_sell) ? 'checked':'' }}>Ventas
                  </label>
                </div>
                <div class="col-sm-2 checkbox">
                  <label>
                    <input type="checkbox" id="obligation_buy" name="obligation_buy"
                    {{ ($businessConfiguration && $businessConfiguration->obligation_buy) ? 'checked':'' }}>Compras
                  </label>
                </div>
                <div class="col-sm-2 checkbox">
                  <label>
                    <input type="checkbox" id="obligation_iva" name="obligation_iva"
                    {{ ($businessConfiguration && $businessConfiguration->obligation_iva) ? 'checked':'' }}>IVA
                  </label>
                </div>
                <div class="col-sm-2 checkbox">
                  <label>
                    <input type="checkbox" id="obligation_electronic_receipt"
                    {{ ($businessConfiguration && $businessConfiguration->obligation_electronic_receipt) ? 'checked':'' }}
                     name="obligation_electronic_receipt">Factura Electronica
                  </label>
                </div>
                <div class="col-sm-2 checkbox">
                  <label>
                    <input type="checkbox" id="obligation_salaries"
                    {{ ($businessConfiguration && $businessConfiguration->obligation_salaries) ? 'checked':'' }}
                     name="obligation_salaries">Sueldos
                  </label>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="type_person_id">
                      IIBB<i title="Requerido" class="fa fa-asterisk fa-fw"></i>
                    </label>
                      <select class="form-control" id="obligation_iibb" name="obligation_iibb">
                        <option value=""></option>
                        @foreach ($iibbObligations as $key => $list)
                           <option value="{{ $key }}"
                             {{ ( old('obligation_iibb', ($business?
                               $business->configuration[0]->obligation_iibb:'') )==$key ? 'selected':'') }}
                             >{{ $list }}</option>
                        @endforeach
                      </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="type_person_id">
                      Otros Impuestos
                    </label>
                      <select class="form-control" id="obligation_other_taxes" name="obligation_other_taxes">
                        <option value=""></option>
                        @foreach ($otherTaxes as $key => $list)
                           <option value="{{ $key }}"
                             {{ ( old('obligation_iibb', ($business?
                               $business->configuration[0]->obligation_other_taxes:'') )==$key ? 'selected':'') }}
                             >{{ $list }}</option>
                        @endforeach
                      </select>
                  </div>
                </div>

             </div>


           </div>
         </div>
       </div>

      </div>

      <div class="tab-pane fade " id="configuracion"
       role="tabpanel" aria-labelledby="configuracion-tab">

       <div class="row">
         <div class="col-md-6">
           <div class="form-group">
             <label for="settle_calc_by_coef">
               Cálculo del IIBB
             </label>
               <select class="form-control" id="settle_calc_by_coef" name="settle_calc_by_coef">
                 <option value=""></option>
                 @foreach ($iibbCalculates as $key => $list)
                    <option value="{{ $key }}"
                      {{ ( old('settle_calc_by_coef', ($business?
                        $business->configuration[0]->settle_calc_by_coef:'') )==$key ? 'selected':'') }}
                      >{{ $list }}</option>
                 @endforeach
               </select>
           </div>
         </div>

         <div class="col-md-6">
           <div class="form-group">
             <label for="liquidation_start_period">
               Period de Liquidacion de Inicio<i title="Requerido" class="fa fa-asterisk fa-fw"></i>
             </label>
               <input class="form-control" id="liquidation_start_period" name="liquidation_start_period"
                autocomplete="off" type="text"
                 value="{{ (($business && $business->configuration[0]))
                   ? $business->configuration[0]->liquidation_start_period :''}}">
               <ul></ul>
           </div>
         </div>

         <div class="col-md-6">
           <div class="form-group">
             <label for="priority_order">
               Orden de Prioridad
             </label>
               <select class="form-control" id="priority_order" name="priority_order">
                 <option value=""></option>
                 @foreach ($priorityOrder as $key => $list)
                    <option value="{{ $key }}"
                      {{ ( old('priority_order', ($business?
                        $business->configuration[0]->priority_order:'') )==$key ? 'selected':'') }}
                      >{{ $list }}</option>
                 @endforeach
               </select>
           </div>
         </div>

         <div class="col-sm-12">
           <div class="bs-callout bs-callout-info" id="callout-xref-input-group">
             <div class="row">
               <div class="col-sm-6">
                 <h4><span>Liquidadores</span></h4>
                 <div class="cincuentas">
                   <div class="">
                     <select class="form-control" id="liquidator_id" name="liquidator_id">
                       <option value=""></option>
                       @foreach ($liquidators as $key => $list)
                          <option value="{{ $list->id }}">{{ $list->name }}</option>
                       @endforeach
                     </select>
                     <input type="hidden" id="liquidator_quantity" name="liquidator_quantity"
                      value="{{ count($businessLiquidators) }}">
                   </div>
                   <div class="">
                     <button class="dt-button btn btn-info" id="btn-add-liquidator"
                      type="button">
                       <span class="fa fa-plus fa-fw"></span>Agregar</button>
                   </div>
                 </div>

               </div>

               <div class="col-sm-6">
                 <table class="table table-striped table-border">
                   <thead>
                     <tr>
                       <th>Nombre</th>
                       <th>Ops</th>
                     </tr>
                   </thead>
                   <tbody id="data-liquidators">
                     @foreach ($businessLiquidators as $key => $list)
                     <tr id="tr_liquidator_{{$list->liquidator_id}}">
                       <td>
                         <span>{{ $list->name }}</span>
                         <input type="hidden" name="liquidator_id[{{$list->liquidator_id}}]"
                          value="{{$list->liquidator_id}}" class="no-val">
                       </td>
                       <td>
                         <button type="button" class="receipt-edit btn btn-danger"
                         id="delete_liquidator_{{$list->liquidator_id}}"
                         data-id="{{$list->liquidator_id}}" data-text="{{ $list->name }}">
                           <i class="fa fa-trash-o"></i></button>
                       </td>
                     </tr>
                     @endforeach
                   </tbody>
                 </table>

               </div>

             </div>
           </div>
         </div>

         <div class="col-sm-12">
           <div class="bs-callout bs-callout-info" id="callout-xref-input-group">
             <div class="row">

               <div class="col-sm-6">
                 <h4><span>Métodos de Pago</span></h4>

                 <div class="cincuentas">
                   <div class="">
                     <select class="form-control" id="pay_method_id" name="pay_method_id">
                       <option value=""></option>
                       @foreach ($payMethods as $key => $list)
                          <option value="{{ $list->id }}">{{ $list->description }}</option>
                       @endforeach
                     </select>
                     <input type="hidden" id="pay_method_quantity" name="pay_method_quantity"
                      value="{{ count($businessPayMethods) }}">
                   </div>
                   <div class="">
                     <button class="dt-button btn btn-info"
                      id="btn-add-pay_method" type="button">
                       <span class="fa fa-plus fa-fw"></span>Agregar</button>

                   </div>
                 </div>

               </div>

               <div class="col-sm-6">
                 <table class="table table-striped table-border">
                   <thead>
                     <tr>
                       <th>Nombre</th>
                       <th>Ops</th>
                     </tr>
                   </thead>
                   <tbody id="data-pay_methods">
                     @foreach ($businessPayMethods as $key => $list)
                     <tr id="tr_pay_method_{{$list->pay_method_id}}">
                       <td>
                         <span>{{ $list->description }}</span>
                         <input type="hidden" name="pay_method_id[{{$list->pay_method_id}}]"
                          value="{{$list->pay_method_id}}" class="no-val">
                       </td>
                       <td>
                         <button type="button" class="receipt-edit btn btn-danger"
                         id="delete_pay_method_{{$list->pay_method_id}}"
                         data-id="{{$list->pay_method_id}}" data-text="{{ $list->description }}">
                           <i class="fa fa-trash-o"></i></button>
                       </td>
                     </tr>
                     @endforeach
                   </tbody>
                 </table>

               </div>

             </div>
           </div>
         </div>
       </div>

      </div>

      <div class="tab-pane fade " id="claves"
           role="tabpanel" aria-labelledby="claves-tab">
           <div style="font-size:80px; text-align:center;">
             <p>Proximamente</p>
             <span class="fa fa-clock-o" ></span>
           </div>
      </div>
   </div>
 </div>

    {{ Form::close() }}
