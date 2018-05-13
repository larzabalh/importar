<fieldset >
  <input type="hidden" id="idForeignFile" value="{{ isset($foreignFile)
   ? $foreignFile->idForeignFile : '' }}">
  <input type="hidden" name="idPersonalFile" value="{{ isset($personalFile)
   ? $personalFile->idPersonalFile : '' }}">

  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-6 form-group
  {{ $errors->has('idCountry') ? ' has-error' : '' }} input-groups">
      <label for="idCountryForeign" class="control-label">
        País de residencia actual *</label>
      <div class="">
          <select id="idCountryForeign" class="form-control" name="idCountry">
            <option value="">-- Reside en --</option>
            @foreach ($countrys as $list)
              <option value="{{ $list->idField() }}"
                {{ ( old('idCountry', (isset($foreignFile)?
                  $foreignFile->idCountry:'') )==$list->idField() ? 'selected':
                   (($list->idField()==5)? 'selected':'') ) }} >
                   {{ $list->getName() }}</option>
            @endforeach
          </select>
          @if ($errors->has('idCountry'))
              <span class="help-block">
                  <strong>{{ $errors->first('idCountry') }}</strong>
              </span>
          @endif
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group bg-success
       {{ $errors->has('naturalized') ? ' has-error' : '' }} input-groups
        form-nat">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="">
                <input type="checkbox" name="naturalized" id="naturalizedForeign"
                value="1" {{ ( old('naturalized', (isset($foreignFile)?
                  $foreignFile->naturalized:'') )==1 ? 'checked' :'' ) }}>
            </label>
            <label for="naturalizedForeign">Naturalizado </label>
          </div>
        </div>
      </div>
  </div>

  <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6 form-group bg-success
   {{ $errors->has('personalID') ? ' has-error' : '' }} input-groups"
   id="forms-2">
    <label for="personalIDForeign" class="control-label">
      DNI / RUT / VISA / Documento *</label>
    <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <input id="personalIDForeign" type="text"
         class="form-control foreigns-id-group"
         name="personalID" value="{{ old('personalID',
            (!isset($foreignFile)?'':$foreignFile->personalID) ) }}"
           placeholder="Número">
        @if ($errors->has('personalID'))
            <span class="help-block">
                <strong>{{ $errors->first('personalID') }}</strong>
            </span>
        @endif
      </div>

      <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3
      {{ $errors->has('emisionPersonalID') ? ' has-error' : '' }}">
              <input id="emisionPersonalIDForeign" type="" class="form-control"
               name="emisionPersonalID" value="{{ old('emisionPersonalID',
                (!isset($foreignFile)?'':$foreignFile->emisionPersonalID) ) }}"
                 placeholder="Emision">
              @if ($errors->has('emisionPersonalID'))
                  <span class="help-block">
                      <strong>{{ $errors->first('emisionPersonalID') }}</strong>
                  </span>
              @endif
      </div>


      <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3
       {{ $errors->has('expirationPersonalID') ? ' has-error' : '' }}">
              <input id="expirationPersonalIDForeign" type="" class="form-control"
               name="expirationPersonalID" value="{{ old('expirationPersonalID',
              (!isset($foreignFile)?'':$foreignFile->expirationPersonalID) ) }}"
               placeholder="Expiración">
              @if ($errors->has('expirationPersonalID'))
                <span class="help-block">
                  <strong>{{ $errors->first('expirationPersonalID') }}</strong>
                </span>
              @endif
      </div>

    </div>
  </div>

  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 form-group
  {{ $errors->has('alternativePersonalID') ? ' has-error' : '' }}  input-groups">
      <label for="alternativePersonalIDForeign" class=" control-label">
        Precaria / Documento Temporal</label>
      <div class="">
          <input id="alternativePersonalIDForeign" type="text"
           class="form-control foreigns-id-group"
           name="alternativePersonalID" value="{{ old('alternativePersonalID',
          (!isset($foreignFile)?'':$foreignFile->alternativePersonalID) ) }}"
             placeholder="Número">
          @if ($errors->has('alternativePersonalID'))
              <span class="help-block">
                  <strong>{{ $errors->first('alternativePersonalID') }}</strong>
              </span>
          @endif
      </div>
  </div>

  <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 form-group bg-success
  {{ $errors->has('idState') ? ' has-error ' : '' }} input-groups">
    <label for="idStateForeign" class="control-label">Ubicación*</label>
    <div class="row">

    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        <select id="idStateForeign" class="form-control" name="idState">
            <option value="">-- Provincia / Estado --</option>
          @foreach ($statesForeigns as $list)
            <option value="{{ $list->idField() }}"
              {{ ( old('idState', (isset($foreignFile)?
                $foreignFile->idState:'') )==$list->idField()
                 ? 'selected' :'' ) }}
              >{{ $list->getName() }}</option>
          @endforeach
        </select>
        @if ($errors->has('idState'))
            <span class="help-block">
                <strong>{{ $errors->first('idState') }}</strong>
            </span>
        @endif
    </div>
    <img src="{{ Storage::disk('public')->url('/img/loading1.gif') }}"
     id="idCountryForeign_img" class="img-loading">

    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8
     {{ $errors->has('addressForeign') ? ' has-error' : '' }}">
        <input id="addressForeign" type="text" class="form-control"
         name="addressForeign" value="{{ old('addressForeign',
        (!isset($foreignFile)?'':$foreignFile->addressForeign) ) }}"
         placeholder="Dirección">
        @if ($errors->has('addressForeign'))
            <span class="help-block">
                <strong>{{ $errors->first('addressForeign') }}</strong>
            </span>
        @endif
    </div>
  </div>
</div>

  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 form-group
  {{ $errors->has('localPhoneNumber') ? ' has-error' : '' }}">
    <label for="localPhoneNumberForeign" class=" control-label">Teléfono Local *</label>
    <div class="">
      <input id="localPhoneNumberForeign" type="phone"
       class="form-control foreigns-phone-group"
       name="localPhoneNumber" value="{{ old('localPhoneNumber',
      (!isset($foreignFile)?'':$foreignFile->localPhoneNumber) ) }}"
       placeholder="Telefono Local">
      @if ($errors->has('localPhoneNumber'))
          <span class="help-block">
              <strong>{{ $errors->first('localPhoneNumber') }}</strong>
          </span>
      @endif
    </div>
  </div>

  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 form-group
  {{ $errors->has('mobilePhoneNumber') ? ' has-error' : '' }}">
      <label for="mobilePhoneNumberForeign" class=" control-label">
        Teléfono Móvil *</label>
      <div class="">
        <input id="mobilePhoneNumberForeign" type="phone"
         class="form-control foreigns-phone-group"
         name="mobilePhoneNumber" value="{{ old('mobilePhoneNumber',
        (!isset($foreignFile)?'':$foreignFile->mobilePhoneNumber) ) }}"
         placeholder="Telefono Movil">
        @if ($errors->has('mobilePhoneNumber'))
            <span class="help-block">
                <strong>{{ $errors->first('mobilePhoneNumber') }}</strong>
            </span>
        @endif
      </div>
  </div>

  <div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 form-group
  {{ $errors->has('dateIn') ? ' has-error' : '' }} input-groups">
    <label for="dateIn" class=" control-label">Fecha de ingreso al país</label>
      <input id="dateIn" type="" class="form-control"
       name="dateIn" value="{{ old('dateIn',
      (!isset($foreignFile)?'':$foreignFile->dateIn) ) }}"
       placeholder="Fecha Ingreso">
      @if ($errors->has('dateIn'))
          <span class="help-block">
              <strong>{{ $errors->first('dateIn') }}</strong>
          </span>
      @endif
  </div>


  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group bg-success
  {{ $errors->has('idImmigrationSituation') ? ' has-error ' : '' }} input-groups">
    <label class="control-label">Situación Migratoria *</label>
    <div class="row">

    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
        <select id="idImmigrationSituation" class="form-control"
          name="idImmigrationSituation">
            <option value="">-- Seleccione --</option>
          @foreach ($immigrationSituations as $list)
            <option value="{{ $list->idField() }}"
              {{ ( old('idImmigrationSituation', (isset($foreignFile)?
                $foreignFile->idImmigrationSituation:'') )==$list->idField()
                 ? 'selected' :'' ) }}
              >{{ $list->getDescription() }}</option>
          @endforeach
        </select>
        @if ($errors->has('idImmigrationSituation'))
            <span class="help-block">
                <strong>{{ $errors->first('idImmigrationSituation') }}</strong>
            </span>
        @endif
    </div>

    <div class="col-xs-12 col-sm-6 col-md-9 col-lg-9" id="extra-immsit">

      <div id="sentence-ff" style="display:{{ !isset($foreignFile) ? 'none' :
        (($foreignFile->idImmigrationSituation==7) ? '':'none')}}">
        <label class="">
            <input type="checkbox" name="hasSentence" id="hasSentence"
            value="1" {{ ( old('hasSentence', (isset($foreignFile)?
              $foreignFile->hasSentence:'') )==1 ? 'checked' :'' ) }}>
        </label>
        <label for="hasSentence">Cumple Condena</label>

        <input id="sentenceDescription" type="text"
         class="form-control form-sentence"
         name="sentenceDescription" value="{{ old('sentenceDescription',
            (!isset($foreignFile)?'':$foreignFile->sentenceDescription) ) }}"
           placeholder="Condena" >

        <input id="sentenceFrom" type="text"
         class="form-control  form-sentence"
         name="sentenceFrom" value="{{ old('sentenceFrom',
            (!isset($foreignFile)?'':$foreignFile->sentenceFrom) ) }}"
           placeholder="Desde">

         <input id="sentenceTo" type="text"
          class="form-control form-sentence"
          name="sentenceTo" value="{{ old('sentenceTo',
             (!isset($foreignFile)?'':$foreignFile->sentenceTo) ) }}"
            placeholder="Hasta">
      </div>

      <div id="study-ff" style="display:{{ !isset($foreignFile) ? 'none' :
        (($foreignFile->idImmigrationSituation==6) ? '':'none')}}">
        <input id="studyDescription" type="text"
         class="form-control"
         name="studyDescription" value="{{ old('studyDescription',
            (!isset($foreignFile)?'':$foreignFile->studyDescription) ) }}"
           placeholder="Estudios">
      </div>
    </div>

  </div>
  </div>



  <div class="col-xs-12 form-group">
  {!! Form::button($submitButtonText,
   ['class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'send-button-ff'])
  !!}
  </div>
</fieldset>
