<fieldset >
  <input type="hidden" id="idPersonalFile" value="{{ isset($personalFile)
   ? $personalFile->idPersonalFile : '' }}">

  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 form-group
  {{ $errors->has('idCountry') ? ' has-error' : '' }} input-groups">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group
   {{ $errors->has('idCountry') ? ' has-error' : '' }} input-groups">
        <label for="idCountry" class="control-label">Nacionalidad *</label>
        <select id="idCountry" class="form-control" name="idCountry">
          <option value="">-- Nacionalidad --</option>
          @foreach ($countrys as $list)
            <option value="{{ $list->idField() }}"
              {{ ( old('idCountry', (isset($personalFile)?
                $personalFile->idCountry:'') )==$list->idField() ? 'selected':
                 (($list->idField()==95)? 'selected':'') ) }} >
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
          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
            <label class="">
                <input type="checkbox" name="naturalized" id="naturalized"
                value="1" {{ ( old('naturalized', (isset($personalFile)?
                  $personalFile->naturalized:'') )==1 ? 'checked' :'' ) }}>
            </label>
            <label for="naturalized">Naturalizado </label>
          </div>

          <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 ">
            <input id="officialGazette" type="text" class="form-control solo"
             name="officialGazette" value="{{ old('officialGazette',
                (!isset($personalFile)?'':$personalFile->officialGazette) ) }}"
               placeholder="Gaceta Oficial">
          </div>

          <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 ">
            <input id="officialGazetteDate" type="text" class="form-control solo"
            name="officialGazetteDate" value="{{ old('officialGazetteDate',
             (!isset($personalFile)?'':$personalFile->officialGazetteDate) ) }}"
              placeholder="Emision">
          </div>
        </div>
      </div>
  </div>

  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 form-group bg-success
   {{ $errors->has('personalID') ? ' has-error' : '' }} input-groups"
   id="forms-1">
    <label for="personalID" class="control-label">Cédula *</label>
    <div class="row">

      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
          <input id="personalID" type="text" class="form-control"
           name="personalID" value="{{ old('personalID',
              (!isset($personalFile)?'':$personalFile->personalID) ) }}"
             placeholder="Cedula">
          @if ($errors->has('personalID'))
              <span class="help-block">
                  <strong>{{ $errors->first('personalID') }}</strong>
              </span>
          @endif
      </div>


      <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3
      {{ $errors->has('emisionPersonalID') ? ' has-error' : '' }}">
          <input id="emisionPersonalID" type="text" class="form-control"
           name="emisionPersonalID" value="{{ old('emisionPersonalID',
            (!isset($personalFile)?'':$personalFile->emisionPersonalID) ) }}"
             placeholder="Emision">
          @if ($errors->has('emisionPersonalID'))
              <span class="help-block">
                  <strong>{{ $errors->first('emisionPersonalID') }}</strong>
              </span>
          @endif
      </div>


      <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3
       {{ $errors->has('expirationPersonalID') ? ' has-error' : '' }}">
          <input id="expirationPersonalID" type="text" class="form-control"
           name="expirationPersonalID" value="{{ old('expirationPersonalID',
          (!isset($personalFile)?'':$personalFile->expirationPersonalID) ) }}"
           placeholder="Expiración">
          @if ($errors->has('expirationPersonalID'))
            <span class="help-block">
              <strong>{{ $errors->first('expirationPersonalID') }}</strong>
            </span>
          @endif
      </div>

      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12
       {{ $errors->has('gender') ? ' has-error' : '' }}">
       <label class="">
           <input type="radio" value="1" name="gender" id="gender_f"
           {{ ( old('gender', (isset($personalFile)?
             $personalFile->gender:'') )==1 ? 'checked' :'' ) }}>
       </label>
       <label for="gender_f">Femenino</label>

       <label class="">
           <input type="radio" value="2" name="gender" id="gender_m"
           {{ ( old('gender', (isset($personalFile)?
             $personalFile->gender:'') )==2 ? 'checked' :'' ) }}>
       </label>
       <label for="gender_m">Masculino</label>

          @if ($errors->has('gender'))
            <span class="help-block">
              <strong>{{ $errors->first('gender') }}</strong>
            </span>
          @endif
      </div>
    </div>
  </div>

  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 form-group
  {{ $errors->has('firstName') ? ' has-error' : '' }}">
      <label for="firstName" class=" control-label">Nombres * <span class="tooltip_1">(1)</span></label>
        <div class="">
          <input id="firstName" type="text" class="form-control"
           name="firstName" value="{{ old('firstName',
          (!isset($personalFile)?'':$personalFile->firstName) ) }}"
             placeholder="Nombres">
          @if ($errors->has('firstName'))
              <span class="help-block">
                  <strong>{{ $errors->first('firstName') }}</strong>
              </span>
          @endif
      </div>
  </div>

  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 form-group
  {{ $errors->has('lastName') ? ' has-error' : '' }}">
      <label for="lastName" class=" control-label">Apellidos * <span class="tooltip_1">(1)</span></label>
        <div class="">
          <input id="lastName" type="text" class="form-control" name="lastName"
           value="{{ old('lastName',
              (!isset($personalFile)?'':$personalFile->lastName) ) }}"
               placeholder="Apellidos">
          @if ($errors->has('lastName'))
              <span class="help-block">
                  <strong>{{ $errors->first('lastName') }}</strong>
              </span>
          @endif
      </div>
  </div>

  <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 form-group bg-success
   {{ $errors->has('birthDate') || $errors->has('birthPlace')?' has-error':'' }}
     input-groups">
    <div class="row">
      <div class="col-xs-12 col-sm-4 col-md-4">
        <label for="birthDate" class="control-label">Fecha de Nacimiento * <span class="tooltip_1">(1)</span>
        </label>
          <input id="birthDate" type="text" class="form-control" name="birthDate"
           value="{{ old('birthDate',
          (!isset($personalFile)?'':$personalFile->birthDate) ) }}"
           placeholder="Fecha de Nacimiento">
          @if ($errors->has('birthDate'))
              <span class="help-block">
                  <strong>{{ $errors->first('birthDate') }}</strong>
              </span>
          @endif
      </div>
      <div class="col-xs-12 col-sm-8 col-md-8
       {{ $errors->has('birthPlace') ? ' has-error' : '' }}">
       <label for="birthDate" class="control-label">Lugar de Nacimiento * <span class="tooltip_1">(1)</span>
       </label>
        <input id="birthPlace" type="text" class="form-control" name="birthPlace"
         value="{{ old('birthPlace',
        (!isset($personalFile)?'':$personalFile->birthPlace) ) }}"
         placeholder="Lugar de Nacimiento">
        @if ($errors->has('birthPlace'))
            <span class="help-block">
                <strong>{{ $errors->first('birthPlace') }}</strong>
            </span>
        @endif
      </div>
    </div>
  </div>

  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 form-group
   {{ $errors->has('civilState') ? ' has-error' : '' }}">
      <label for="claveUser-confirm"
       class=" control-label">Estado Civil * <span class="tooltip_1">(1)</span></label>
      <div class="">
          <select id="civilState" class="form-control"
           name="civilState" value="">
            @foreach ($civilStates as $key => $value)
              <option value="{{ $key }}"
              {{ ( old('civilState', (isset($personalFile)?
                $personalFile->civilState:'') )==$key ? 'selected' :'' ) }}
                >{{ $value }}</option>
            @endforeach
          </select>
          @if ($errors->has('birthPlace'))
              <span class="help-block">
                  <strong>
                    {{ $errors->first('birthPlace') }}
                  </strong>
              </span>
          @endif
      </div>
  </div>

  <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 form-group bg-success
   {{ $errors->has('passportNumber') ? ' has-error' : '' }} input-groups">
    <label for="passportNumber" class=" control-label">Pasaporte *</label>
    <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
              <input id="passportNumber" type="text" class="form-control"
               name="passportNumber" value="{{ old('passportNumber',
              (!isset($personalFile)?'':$personalFile->passportNumber) ) }}"
               placeholder="Pasaporte">
              @if ($errors->has('passportNumber'))
                  <span class="help-block">
                      <strong>{{ $errors->first('passportNumber') }}</strong>
                  </span>
              @endif
      </div>


      <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3
       {{ $errors->has('emisionPassport') ? ' has-error' : '' }}">
              <input id="emisionPassport" type="text" class="form-control"
               name="emisionPassport" value="{{ old('emisionPassport',
              (!isset($personalFile)?'':$personalFile->emisionPassport) ) }}"
               placeholder="Emisión">
              @if ($errors->has('emisionPassport'))
                  <span class="help-block">
                      <strong>{{ $errors->first('emisionPassport') }}</strong>
                  </span>
              @endif
      </div>


      <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3
       {{ $errors->has('expirationPassport') ? ' has-error' : '' }}">
              <input id="expirationPassport" type="text" class="form-control"
               name="expirationPassport" value="{{ old('expirationPassport',
              (!isset($personalFile)?'':$personalFile->expirationPassport) ) }}"
               placeholder="Expiración">
              @if ($errors->has('expirationPassport'))
                  <span class="help-block">
                      <strong>{{ $errors->first('expirationPassport') }}</strong>
                  </span>
              @endif
      </div>

    </div>
  </div>

  <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 form-group
  {{ $errors->has('bloodType') ? ' has-error' : '' }}">
      <label for="bloodType" class=" control-label">Tipo de Sangre</label>
      <div class="">
        <select id="bloodType" class="form-control"
         name="bloodType" >
          @foreach ($bloodTypes as $key => $value)
            <option value="{{ $key }}"
            {{ ( old('bloodType', (isset($personalFile)?
              $personalFile->bloodType:'') )==$key ? 'selected' :'' ) }}
              >{{ $value }}</option>
          @endforeach
        </select>
        @if ($errors->has('bloodType'))
            <span class="help-block">
                <strong>{{ $errors->first('bloodType') }}</strong>
            </span>
        @endif
      </div>
  </div>

  <div class="col-xs-12 col-md-12 col-lg-12 form-group bg-success
  {{ $errors->has('idState') ? ' has-error ' : '' }} input-groups">
    <label for="idState" class="control-label">Datos en Venezuela *</label>
    <div class="row">

    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
        <select id="idState" class="form-control" name="idState">
            <option value="">-- Estado --</option>
          @foreach ($states as $list)
            <option value="{{ $list->idField() }}"
              {{ ( old('idState', (isset($personalFile)?
                $personalFile->idState:'') )==$list->idField()
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
     id="idCountry_img" class="img-loading">

    <div class="col-xs-12 col-sm-6 col-md-9 col-lg-9
     {{ $errors->has('addressOrigin') ? ' has-error' : '' }}">
        <input id="addressOrigin" type="text" class="form-control"
         name="addressOrigin" value="{{ old('addressOrigin',
        (!isset($personalFile)?'':$personalFile->addressOrigin) ) }}"
         placeholder="Dirección">
        @if ($errors->has('addressOrigin'))
            <span class="help-block">
                <strong>{{ $errors->first('addressOrigin') }}</strong>
            </span>
        @endif
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6
     {{ $errors->has('localPhoneNumber') ? ' has-error' : '' }}">
        <input id="localPhoneNumber" type="phone" class="form-control"
         name="localPhoneNumber" value="{{ old('localPhoneNumber',
        (!isset($personalFile)?'':$personalFile->localPhoneNumber) ) }}"
         placeholder="Telefono Local">
        @if ($errors->has('localPhoneNumber'))
            <span class="help-block">
                <strong>{{ $errors->first('localPhoneNumber') }}</strong>
            </span>
        @endif
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6
     {{ $errors->has('mobilePhoneNumber') ? ' has-error' : '' }}">
        <input id="mobilePhoneNumber" type="phone" class="form-control"
         name="mobilePhoneNumber" value="{{ old('mobilePhoneNumber',
        (!isset($personalFile)?'':$personalFile->mobilePhoneNumber) ) }}"
         placeholder="Telefono Movil">
        @if ($errors->has('mobilePhoneNumber'))
            <span class="help-block">
                <strong>{{ $errors->first('mobilePhoneNumber') }}</strong>
            </span>
        @endif
    </div>
  </div>
</div>

  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 form-group
  {{ $errors->has('principalEmail') ? ' has-error' : '' }}">
    <label for="principalEmail" class=" control-label">Email Principal *</label>
    <div class="">
      <input id="principalEmail" type="email" class="form-control"
       name="principalEmail" value="{{ old('principalEmail',
      (!isset($personalFile)?'':$personalFile->principalEmail) ) }}"
       placeholder="mail@dominio.com">
      @if ($errors->has('principalEmail'))
          <span class="help-block">
              <strong>{{ $errors->first('principalEmail') }}</strong>
          </span>
      @endif
    </div>
  </div>

  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 form-group
  {{ $errors->has('secondaryEmail') ? ' has-error' : '' }}">
      <label for="secondaryEmail" class=" control-label">Email Secundario</label>
      <div class="">
          <input id="secondaryEmail" type="email" class="form-control"
           name="secondaryEmail" value="{{ old('secondaryEmail',
          (!isset($personalFile)?'':$personalFile->secondaryEmail) ) }}"
           placeholder="mail@dominio.com">
          @if ($errors->has('secondaryEmail'))
              <span class="help-block">
                  <strong>{{ $errors->first('secondaryEmail') }}</strong>
              </span>
          @endif
      </div>
  </div>

  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 form-group
  {{ $errors->has('instruccionDegree') ? ' has-error' : '' }}">
      <label for="instruccionDegree"
       class="control-label">Grado de Instrucción</label>
      <div class="">
          <select id="instruccionDegree" class="form-control"
           name="instruccionDegree" >
            @foreach ($instruccionDegrees as $key => $value)
              <option value="{{ $key }}"
              {{ ( old('instruccionDegree', (isset($personalFile)?
                $personalFile->instruccionDegree:'') )==$key ? 'selected' :'' ) }}
                >{{ $value }}</option>
            @endforeach
          </select>
          @if ($errors->has('instruccionDegree'))
              <span class="help-block">
                  <strong>{{ $errors->first('instruccionDegree') }}</strong>
              </span>
          @endif

      </div>
  </div>

  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 form-group
  {{ $errors->has('jobOcupattion') ? ' has-error' : '' }}">
      <label for="jobOcupattion" class=" control-label">Oficio / Profesión</label>
      <div class="">
          <input id="jobOcupattion" type="text" class="form-control"
           name="jobOcupattion" value="{{ old('jobOcupattion',
          (!isset($personalFile)?'':$personalFile->jobOcupattion) ) }}"
           placeholder="Oficio/Ocupación">
          @if ($errors->has('jobOcupattion'))
              <span class="help-block">
                  <strong>{{ $errors->first('jobOcupattion') }}</strong>
              </span>
          @endif
      </div>
  </div>

  <div class="col-xs-12 col-sm-12 col-md-7 col-lg-6 form-group bg-success
  {{ $errors->has('birthNumberFile') ? ' has-error' : '' }} input-groups">
    <label for="birthNumberFile" class=" control-label">Acta Nacimiento </label>
    <div class="row">
      <div class="col-xs-12 col-sm-9 col-md-8 col-lg-9
       {{ $errors->has('birthNumberFile') ? ' has-error' : '' }}">
        <input id="birthNumberFile" type="text" class="form-control"
         name="birthNumberFile" value="{{ old('birthNumberFile',
        (!isset($personalFile)?'':$personalFile->birthNumberFile) ) }}"
         placeholder="Número - Folio">
        @if ($errors->has('birthNumberFile'))
            <span class="help-block">
                <strong>{{ $errors->first('birthNumberFile') }}</strong>
            </span>
        @endif
      </div>

      <div class="col-xs-12 col-sm-3 col-md-4 col-lg-3
       {{ $errors->has('birthFileDate') ? ' has-error' : '' }}">
          <input id="birthFileDate" type="text" class="form-control"
           name="birthFileDate" value="{{ old('birthFileDate',
          (!isset($personalFile)?'':$personalFile->birthFileDate) ) }}"
           placeholder="Fecha Emisión">
          @if ($errors->has('birthFileDate'))
              <span class="help-block">
                  <strong>{{ $errors->first('birthFileDate') }}</strong>
              </span>
          @endif
      </div>

    </div>
  </div>

  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 form-group
   {{ $errors->has('pensionerIVSS') ? ' has-error' : '' }}">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <label class="">
            <input type="checkbox" value=1 name="pensionerIVSS"
            {{ ( old('pensionerIVSS', (isset($personalFile)?
              $personalFile->pensionerIVSS:'') )==1 ? 'checked' :'' ) }}
             id="pensionerIVSS">
        </label>
        <label for="pensionerIVSS">Pensionado del IVSS</label>
      </div>

    </div>
  </div>

  <span>(*) Campos Requeridos</span>
  <span id="legend1">(1) Como se refleja en el Pasaporte o Cédula</span>

  <div class="col-xs-12 form-group">
  {!! Form::button($submitButtonText,
   ['class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'send-button-pf'])
  !!}
  </div>
</fieldset>
