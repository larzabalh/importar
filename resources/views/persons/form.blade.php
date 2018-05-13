<div id="alertsFlag">

</div>

{!! Form::open(
  ['route' => ['persons.store'],
  'method' => 'post', 'class' => 'form-horizontal',
  'enctype' => 'multipart/form-data', 'role' => 'form',
  'id' => 'store-person'
  ]) !!}

@if($person)
  <input type="hidden" id="person_id" name="person_id" value="{{ $person->id }}">
@endif

<div class="panel panel-default">

  <div class="row">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item active">
        <a class="nav-link " id="datos-tab" data-toggle="tab"
         href="#datos" role="tab" aria-controls="datos"
          aria-selected="true" aria-expanded="true">Datos</a>
      </li>

    </ul>

    <div class="tab-content" id="tab-content-ot">

      <div class="tab-pane fade active in" id="datos"
       role="tabpanel" aria-labelledby="datos-tab">

          <div class="row">

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
                         {{ ( old('document_type', ($person?
                           strtoupper($person->document_type):'') )==$list ? 'selected':'') }}
                         >{{ $list }}</option>
                    @endforeach
                  </select>

                  <input type="text" class="form-control" name="document" id="document"
                   autocomplete="off" value="{{ ($person) ? $person->document :''}}">

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
                value="{{ ($person) ? $person->field_name1 :''}}">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label for="person_type_id">
                  Tipo de Persona
                </label>
                  <select class="form-control" id="person_type_id" name="person_type_id">
                    <option value=""></option>
                    @foreach ($personTypes as $key => $list)
                       <option value="{{ $list->id }}"
                         {{ ( old('person_type_id', ($person?
                           $person->person_type_id:'') )==$list->id ? 'selected':'') }}
                         >{{ $list->description }}</option>
                    @endforeach
                  </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label for="iva_condition_id">
                  Provincia / Zona
                </label>
                  <select class="form-control" id="zone_id" name="zone_id">
                    <option value=""></option>
                    @foreach ($zones as $key => $list)
                       <option value="{{ $list->id }}"
                         {{ ( old('zone_id', ($person?
                           $person->zone_id:'') )==$list->id ? 'selected':'') }}
                         >{{ $list->name }}</option>
                    @endforeach
                  </select>
              </div>
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label for="address"> Domicilio </label>
                <textarea class="form-control form-textarea" id="address"
                 name="address">{{ ($person) ? $person->address :''}}</textarea>
              </div>
            </div>
          </div>


        </div>

      </div>
 </div>

    {{ Form::close() }}
