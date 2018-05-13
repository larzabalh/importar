$( document ).ready(function() {

  $('#store-pf span.tooltip_1').tooltipster({
    theme: ['tooltipster-light'],  animation: 'fade',  delay: 100,
    trigger: 'hover',  onlyOne: false,
    position: ['top', 'right', 'bottom', 'left'],
    distance: 3, content: $('#legend1').text()
  });

  //make readonly for dates
  $( "#emisionPersonalID" ).prop('readonly', true);
  $( "#expirationPersonalID" ).prop('readonly', true);
  $( "#birthDate" ).prop('readonly', true);
  $( "#emisionPassport" ).prop('readonly', true);
  $( "#expirationPassport" ).prop('readonly', true);
  $( "#birthFileDate" ).prop('readonly', true);

  //make disabled for fields not allowed
  $( "#officialGazette" ).prop('disabled', true);
  $( "#officialGazetteDate" ).prop('disabled', true);

  //event for naturalized in PersonalFile
  $('#naturalized').click(function() {
      $( "#officialGazette" ).prop('disabled', !(this.checked));
      $( "#officialGazetteDate" ).prop('disabled', !(this.checked));
      if(this.checked){
        $( "#officialGazetteDate" ).prop('readonly', (this.checked));
        $( "#officialGazetteDate" ).datepicker(
           { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd',
            maxDate:new Date() }
         ).attr('type','text');
      }else{
        $( "#officialGazette" ).prop('value', '');
        $( "#officialGazetteDate" ).prop('value', '');
      }
  });

  //for Foreign data
  $( "#emisionPersonalIDForeign" ).prop('readonly', true);
  $( "#expirationPersonalIDForeign" ).prop('readonly', true);
  $( "#dateIn" ).prop('readonly', true);
  $( "#sentenceFrom" ).prop('readonly', true);
  $( "#sentenceTo" ).prop('readonly', true);

  //datepicker for these fields
  $( "#emisionPersonalID" ).datepicker(
   { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd' }
  ).on('change', function(){
     $("#expirationPersonalID").datepicker( 'option', 'minDate', $(this).val() );
  }).attr('type','text');
  $( "#expirationPersonalID" ).datepicker(
    { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd' }
  ).on('change', function(){
      $("#emisionPersonalID").datepicker( 'option', 'maxDate', $(this).val() );
  }).attr('type','text');

  $( "#sentenceFrom" ).datepicker(
    { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd',
     'maxDate' : $('#sentenceTo').val() }
  ).on('change', function(){
      $("#sentenceTo").datepicker( 'option', 'minDate', $(this).val() );
  }).attr('type','text');
  $( "#sentenceTo" ).datepicker(
     { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd',
      'minDate' : $('#sentenceFrom').val() }
  ).on('change', function(){
       $("#sentenceFrom").datepicker( 'option', 'maxDate', $(this).val() );
  }).attr('type','text');

  $( "#birthDate" ).datepicker(
     { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd', defaultDate: "-18Y", maxDate:new Date() }
   ).attr('type','text');
  $( "#birthFileDate" ).datepicker(
     { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd', defaultDate: "-18Y", maxDate:new Date() }
   ).attr('type','text');

  $( "#emisionPassport" ).datepicker(
     { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd' }
   ).on('change', function(){
       $("#expirationPassport").datepicker( 'option', 'minDate', $(this).val() );
   }).attr('type','text');
  $( "#expirationPassport" ).datepicker(
      { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd' }
   ).on('change', function(){
        $("#emisionPassport").datepicker( 'option', 'maxDate', $(this).val() );
   }).attr('type','text');

  $( "#birthFileDate" ).datepicker(
    { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd', defaultDate: "-18Y", maxDate:new Date() }
  ).attr('type','text');

  $( "#emisionPersonalIDForeign" ).datepicker(
     { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd' }
   ).on('change', function(){
       $("#expirationPersonalIDForeign").datepicker( 'option', 'minDate', $(this).val() );
   }).attr('type','text');
  $( "#expirationPersonalIDForeign" ).datepicker(
      { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd' }
   ).on('change', function(){
        $("#emisionPersonalIDForeign").datepicker( 'option', 'maxDate', $(this).val() );
   }).attr('type','text');

  $( "#dateIn" ).datepicker(
     { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd', maxDate:new Date() }
   ).attr('type','text');


  //event for hasSentence in ForeignFile
  $('#hasSentence').click(function() {
     $( "#sentenceDescription" ).prop('disabled', !(this.checked));
     $( "#sentenceFrom" ).prop('disabled', !(this.checked));
     $( "#sentenceTo" ).prop('disabled', !(this.checked));
     $( "#sentenceFrom" ).prop('readonly', (this.checked));
     $( "#sentenceTo" ).prop('readonly', (this.checked));
     if(this.checked){
       $( "#sentenceFrom" ).prop('readonly', (this.checked));
       $( "#sentenceTo" ).prop('readonly', (this.checked));
     }else{
       //$( "#officialGazette" ).prop('value', '');
       //$( "#officialGazetteDate" ).prop('value', '');
     }
  });

  //only numbers
  $("#personalID").mask("999999999", { placeholder : "12345678" } );
  //$('#personalID').ForceNumericOnly().attr({ maxLength : 8 });
  $('#passportNumber').ForceNumericOnly().attr({ maxLength : 15 });

  //maxLength for text fields
  $('#firstName').attr({ maxLength : 30 });
  $('#lastName').attr({ maxLength : 30 });
  $('#birthPlace').attr({ maxLength : 50 });
  $('#addressOrigin').attr({ maxLength : 150 });
  $('#principalEmail').attr({ maxLength : 40 });
  $('#secondaryEmail').attr({ maxLength : 40 });

  $('#personalIDForeign').attr({ maxLength : 30 });
  $('#alternativePersonalID').attr({ maxLength : 30 });

  //masking fields
  $("#localPhoneNumber").mask("0999-999-99-99", { placeholder : "0212-123-45-67" } );
  $("#mobilePhoneNumber").mask("0999-999-99-99", { placeholder : "0212-123-45-67" } );

  $("#localPhoneNumberForeign").mask("9999999999999", { placeholder : "" } );
  $("#mobilePhoneNumberForeign").mask("9999999999999", { placeholder : "" } );

  //on change the country change the states
  $( "#idCountry" ).on( "change", function() {
    if($(this).val()==0){
      console.log('Esta vacio y no continuo');
    }else{
      $.ajax({
        type : 'GET',
        url : '/Finanzas/masters/states/byCountry',
        beforeSend: function () {
          $( "#idState" ).empty();
          $( "#idState_img" ).show();
          $( "#idState" ).hide();
        },
        data : {
         "idCountry" : $(this).val()
       }
     })
     .done(function(response){
       $( "#idState_img" ).hide();
       $( "#idState" ).show();
       $.each(response.state, function(){
             $('<option/>', {
                 'value': this.idState,
                 'text': this.stateName
             }).appendTo('#idState');
         });
     })
     .fail(function(jqXHR, textStatus, errorThrown) {
        if(jqXHR.status==422){
          var errores = JSON.parse(jqXHR.responseText);
        }else{
         console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
       }
     });
   }
  });

  $( "#idCountryForeign" ).on( "change", function() {
    //console.log('Valor del pais->'+$(this).val());
    if($(this).val()==0){
      console.log('Esta vacio y no continuo');
    }else{
      $.ajax({
        type : 'GET',
        url : '/Finanzas/masters/states/byCountry',
        beforeSend: function () {
          $( "#idStateForeign" ).empty();
          $( "#idStateForeign_img" ).show();
          $( "#idStateForeign" ).hide();
        },
        data : {
         "idCountryForeign" : $(this).val()
       }
     })
     .done(function(response){
       $( "#idStateForeign_img" ).hide();
       $( "#idStateForeign" ).show();
       //console.log(response);
       //console.log('buscando');
       $.each(response.state, function(){
             $('<option/>', {
                 'value': this.idState,
                 'text': this.stateName
             }).appendTo('#idStateForeign');
         });
     })
     .fail(function(jqXHR, textStatus, errorThrown) { // What to do if we fail
       //capturo el error de las validaciones de Laravel
        if(jqXHR.status==422){
          var errores = JSON.parse(jqXHR.responseText);
          //console.log(errores.errors);
          //validator.showErrors( errores.errors );
        }else{
         //otros errores;
         //console.log(JSON.stringify(jqXHR));
         console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
       }
     });
   }
  });

//on change immigration situation
$( "#idImmigrationSituation" ).on( "change", function() {
  //console.log('Valor del pais->'+$(this).val());
  if($(this).val()==0){
    console.log('Esta vacio y no continuo');
  }else{
    $.ajax({
      type : 'GET',
      url : '/Finanzas/masters/immigrationsituation/jsonById',
      beforeSend: function () {
      },
      data : {
       "idImmigrationSituation" : $(this).val()
     }
   })
   .done(function(response){
     console.log(response);
     $('#sentence-ff').hide();
     $('#study-ff').hide();
     if(response.value.juditial==1){ $('#sentence-ff').show(); }
     if(response.value.study==1){ $('#study-ff').show(); }

   })
   .fail(function(jqXHR, textStatus, errorThrown) {
      if(jqXHR.status==422){
        var errores = JSON.parse(jqXHR.responseText);
      }else{
       console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
     }
   });
 }
});

  //button add contact
  $('#add-button-contact').click( function(){

    let idPersonalFile1 = $('#idPersonalFile').val();

    if(idPersonalFile1==''){
      var modal = $('#alertsModal');
      let html = '<div class="alert alert-danger" role="alert">';
        html+='<span class="glyphicon glyphicon-exclamation-sign"';
        html+=' aria-hidden="true"></span>Primero debe cargar la Persona</div>';
      $('#alertsModal .modal-content .modal-body').html(html);
      $(modal).modal('show', {backdrop: 'static'});
      return false;
    }

    new_item = $('#new-item');
    $(new_item).empty();

    let form = $(document.createElement('form'));
    $(form).attr("action", "/Finanzas/masters/personalfile/stepContact")
      .attr("method", "POST").attr('id', 'contact-form')
      .attr("class", "form-horizontal").attr('enctype', 'multipart/form-data')
      .attr('role', 'form');

    let idForeingFile = $("<input>").attr("type", "hidden")
    .attr("name", "idForeignFile").val($('#idForeignFile').val());
    let idPersonalFile = $("<input>").attr("type", "hidden")
    .attr("name", "idPersonalFile").val($('#idPersonalFile').val());


    $(form).append( $(idForeingFile) );
    $(form).append( $(idPersonalFile) );

    let fieldset = $("<fieldset>");

    //creating nationality element
    let div1 = $('<div>')
.attr('class', 'col-xs-12 col-sm-4 col-md-4 col-lg-3 form-group input-groups');
    let label1 = $('<label>').attr('for', 'idCountryContact')
      .attr('class', 'control-label').text('Nacionalidad *');
    let nat = $("<select>").attr("name", "idCountry")
      .attr("class", "form-control").attr("id", 'idCountryContact');

        $.ajax({ type : 'GET', url : '/Finanzas/masters/countrys/allCountrys',
       })
       .done(function(response){
         $.each(response.countrys, function(){
            $('<option/>', { 'value': this.idCountry,'text': this.countryName
            }).attr('selected',  ( (this.idCountry==5)? true : false ) )
            .appendTo( $(nat) );
          });
       });

    $(div1).append( $(label1) );
    $(div1).append( $(nat) );


    //creating primary Document element
    let div2 = $('<div>')
.attr('class', 'col-xs-12 col-sm-4 col-md-4 col-lg-3 form-group input-groups');
    let label2 = $('<label>').attr('for', 'personalIDContact')
      .attr('class', 'control-label').text('Cédula / DNI / Documento *');
    let personalID = $("<input>").attr("type", "text").attr("name", "personalID")
      .attr("placeholder", 'Documento')
      .attr("class", "form-control contact-id-group")
      .attr("id", 'personalIDContact');

    $(div2).append( $(label2) );
    $(div2).append( $(personalID) );

    //creating secondary Document element
    let div3 = $('<div>')
.attr('class', 'col-xs-12 col-sm-4 col-md-4 col-lg-3 form-group input-groups');
    let label3 = $('<label>').attr('for', 'alternativePersonalIDContact')
      .attr('class', 'control-label').text('Precaria / Documento Temporal');
    let alternativePersonalID = $("<input>").attr("type", "text")
      .attr("name", "alternativePersonalID")
      .attr("placeholder", 'Precaria')
      .attr("class", "form-control contact-id-group")
      .attr("id", 'alternativePersonalIDContact');

    $(div3).append( $(label3) );
    $(div3).append( $(alternativePersonalID) );


    //creating first_name element
    let divfn = $('<div>')
.attr('class', 'col-xs-12 col-sm-4 col-md-4 col-lg-3 form-group input-groups');
    let labelfn = $('<label>').attr('for', 'firstNameContact')
      .attr('class', 'control-label').text('Nombres *');
    let firstName = $("<input>").attr("type", "text")
      .attr("name", "firstName")
      .attr("placeholder", 'Nombres').attr("class", "form-control")
      .attr("id", 'firstNameContact');

    $(divfn).append( $(labelfn) );
    $(divfn).append( $(firstName) );

    //creating secondary Document element
    let divln = $('<div>')
.attr('class', 'col-xs-12 col-sm-4 col-md-4 col-lg-3 form-group input-groups');
    let labelln = $('<label>').attr('for', 'lastNameContact')
      .attr('class', 'control-label').text('Apellidos *');
    let lastName = $("<input>").attr("type", "text")
      .attr("name", "lastName")
      .attr("placeholder", 'Apellidos').attr("class", "form-control")
      .attr("id", 'lastNameContact');

    $(divln).append( $(labelln) );
    $(divln).append( $(lastName) );

    //creating relation element
    let div4 = $('<div>')
.attr('class', 'col-xs-12 col-sm-4 col-md-4 col-lg-3 form-group input-groups');
    let label4 = $('<label>').attr('for', 'idRelationTypeContact')
      .attr('class', 'control-label').text('Parentesco');
      let relation = $("<select>").attr("name", "idRelationType")
        .attr("class", "form-control").attr("id", 'idRelationTypeContact');

      $.ajax({ type : 'GET', url : '/Finanzas/masters/relationship/allRelations',
       })
       .done(function(response){
         $.each(response.relations, function(){
            $('<option/>', { 'value': this.idRelationType,
             'text': this.nameRelationType
            }).appendTo( $(relation) );
          });
       });

    $(div4).append( $(label4) );
    $(div4).append( $(relation) );


    //creating country residence element
    let div5 = $('<div>')
.attr('class', 'col-xs-12 col-sm-4 col-md-4 col-lg-3 form-group input-groups');
    let label5 = $('<label>').attr('for', 'idCountryResidenceContact')
      .attr('class', 'control-label').text('País Residencia *');
    let idCountryRes = $("<select>").attr("name", "idCountryResidence")
      .attr("class", "form-control").attr("id", 'idCountryResidenceContact');

        $.ajax({ type : 'GET', url : '/Finanzas/masters/countrys/allCountrys',
       })
       .done(function(response){
         $.each(response.countrys, function(){
            $('<option/>', { 'value': this.idCountry,'text': this.countryName})
            .attr('selected',  ( (this.idCountry==95)? true : false ) )
            .appendTo( $(idCountryRes) );
          });
       });

    $(div5).append( $(label5) );
    $(div5).append( $(idCountryRes) );


    //creating state element
    let div6 = $('<div>')
    .attr('class', 'col-xs-12 col-sm-4 col-md-4 col-lg-3 form-group input-groups');
    let label6 = $('<label>').attr('for', 'idStateContact')
      .attr('class', 'control-label').text('Provincia / Localidad / Estado');
      let idState = $("<select>").attr("name", "idState")
        .attr("class", "form-control").attr("id", 'idStateContact');

      $.ajax({ type : 'GET', url : '/Finanzas/masters/states/byCountry',
      beforeSend: function () {
        $( "#idStateContact" ).empty();  $( "#idStateContact" ).hide();
      },
      data : {  "idCountry" : 95  }
       })
       .done(function(response){
         $.each(response.state, function(){
            $('<option/>', { 'value': this.idState,'text': this.stateName})
            .appendTo( $(idState) );
          });
       });

     $(div6).append( $(label6) );
     $(div6).append( $(idState) );


     //creating address element
     let div7 = $('<div>')
 .attr('class', 'col-xs-12 col-sm-4 col-md-4 col-lg-3 form-group input-groups');
     let label7 = $('<label>').attr('for', 'addressContact')
       .attr('class', 'control-label').text('Dirección Residencia');
     let addressContact = $("<input>").attr("type", "text")
       .attr("name", "addressContact")
       .attr("placeholder", 'Dirección').attr("class", "form-control")
       .attr("id", 'addressContact');

     $(div7).append( $(label7) );
     $(div7).append( $(addressContact) );


      //creating Mobile and Local Phone element
      let div8 = $('<div>')
  .attr('class', 'col-xs-12 col-sm-4 col-md-4 col-lg-3 form-group input-groups');
      let label8 = $('<label>').attr('class', 'control-label')
      .text('Teléfono Móvil *');

      let mobilePhoneContact = $("<input>").attr("type", "text")
        .attr("name", "mobilePhoneNumber")
        .attr("placeholder", 'Télefono Móvil')
        .attr("class", "form-control contact-phone-group")
        .attr("id", 'mobilePhoneNumberContact');

      $(div8).append( $(label8) );
      $(div8).append( $(mobilePhoneContact) );



      //creating Mobile and Local Phone element
      let div9 = $('<div>')
  .attr('class', 'col-xs-12 col-sm-4 col-md-4 col-lg-3 form-group input-groups');
      let label9 = $('<label>').attr('class', 'control-label')
      .text('Teléfono Local *');

      let localPhoneContact = $("<input>").attr("type", "text")
        .attr("name", "localPhoneNumber")
        .attr("placeholder", 'Télefono Local')
        .attr("class", "form-control contact-phone-group")
        .attr("id", 'localPhoneNumberContact');

      $(div9).append( $(label9) );
      $(div9).append( $(localPhoneContact) );

      //creating email element
      let div10 = $('<div>')
  .attr('class', 'col-xs-12 col-sm-4 col-md-4 col-lg-3 form-group input-groups');
      let label10 = $('<label>').attr('for', 'addressContact')
        .attr('class', 'control-label').text('Email');
      let emailContact = $("<input>").attr("type", "text")
        .attr("name", "principalEmail")
        .attr("placeholder", 'Email').attr("class", "form-control")
        .attr("id", 'principalEmailContact');

      $(div10).append( $(label10) );
      $(div10).append( $(emailContact) );


      //creating Emergency contact element
      let div11 = $('<div>')
  .attr('class', 'col-xs-12 col-sm-4 col-md-4 col-lg-3 form-group input-groups');
      let br = $('<br>');
      let emergency = $("<input>").attr("type", "checkbox")
        .attr("name", "emergencyContact")
        .attr("id", 'emergencyContact').attr('value', '1');
      let label11 = $('<label>').attr('for', 'emergencyContact')
        .attr('class', 'control-label').text('Es contacto de Emergencia');

      $(div11).append( $(br) );
      $(div11).append( $(emergency) );
      $(div11).append( $(label11) );

      //creating Emergency contact element
      let div12 = $('<div>')
  .attr('class', 'col-xs-12 col-sm-12 col-md-12 col-lg-12');
      let save = $("<input>").attr("type", "submit")
        .attr('class', 'btn btn-primary')
        .attr("id", 'save-button-contact').attr('value', 'Guardar');
      let cancel = $("<input>").attr("type", "button")
        .attr('class', 'btn btn-danger')
        .attr('formnovalidate', 'formnovalidate').attr('name', 'ignore-cancel')
        .attr("id", 'cancel-button-contact').attr('value', 'Cancelar');

      $(div12).append( $(save) );
      $(div12).append( '      ' );
      $(div12).append( $(cancel) );


    //appends elements in order
    $(fieldset).append( $(div1) );
    $(fieldset).append( $(div2) );
    $(fieldset).append( $(div3) );
    $(fieldset).append( $(divfn) );
    $(fieldset).append( $(divln) );
    $(fieldset).append( $(div4) );
    $(fieldset).append( $(div5) );
    $(fieldset).append( $(div6) );
    $(fieldset).append( $(div7) );
    $(fieldset).append( $(div8) );
    $(fieldset).append( $(div9) );
    $(fieldset).append( $(div10) );
    $(fieldset).append( $(div11) );
    $(fieldset).append( $(div12) );

    $(form).append( $(fieldset) );

    form.appendTo( $(new_item) );

    //for change the country in contact
    $( "#idCountryResidenceContact" ).on( "change", function() {
      if($(this).val()==0){
        console.log('Esta vacio y no continuo');
      }else{
        $.ajax({
          type : 'GET',
          url : '/Finanzas/masters/states/byCountry',
          beforeSend: function () {
            $( "#idStateContact" ).empty();
            $( "#idStateContact" ).hide();
          },
          data : {
           "idCountry" : $(this).val()
         }
       })
       .done(function(response){
         $( "#idStateContact" ).show();
         $.each(response.state, function(){
               $('<option/>', {
                   'value': this.idState,
                   'text': this.stateName
               }).appendTo('#idStateContact');
           });
       })
       .fail(function(jqXHR, textStatus, errorThrown) {
          if(jqXHR.status==422){
            var errores = JSON.parse(jqXHR.responseText);
          }else{
           console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
         }
       });
     }
    });

    //for cancel button
    $('#cancel-button-contact').click(function() {
        $('#add-button-contact').show();
        $(new_item).empty();
    });


    //the tooltipster
    $('#contact-form input[type="text"],select,input[type="checkbox"],input[type=email]').tooltipster(
      window.objectValidator);


    //for Contact Data
    $('#contact-form').validate({
      validClass: "valid-element",
      errorElement: "div",
      errorClass: "invalid-element",
  	  debug: true,
      errorPlacement:  function (error, element) {
        let lastError = $(element).data('lastError'),
            newError = $(error).text();
        $(element).data('lastError', newError);
        if(newError !== '' && newError !== lastError){
            $(element).tooltipster('content', newError);
            $(element).tooltipster('show');
        }
      },
      success : function (label, element) {
        //onsole.log('label->'+label+', element->'+element);
        if ( $(element) ) { $(element).tooltipster('hide'); }
      },
  		rules: {
  			"idCountry" : {	required: true, },
  			"personalID" : { required:true, minlength:6, maxlength:15,	},
  			"alternativePersonalID" : { minlength:6, maxlength:15,	},
        "firstName" : { required: true, minlength:3 },
        "lastName" : { required:true, minlength:3 },
        "idRelationType" : { required:true },
        "idCountryResidence" : { required:true },
        "idState" : { required:true },
        "addressContact" : { required:true, minlength:5 },
        "localPhoneNumber" : {require_from_group: [1, ".contact-phone-group"]},
        "mobilePhoneNumber" : {require_from_group: [1, ".contact-phone-group"]},
        "principalEmail" : { required: true, email: true }
  		},
  		messages: {
  			"idCountry" : "Selecciona la Nacionalidad"	,
  			"personalID" :  { required : "Debe llenado Documento Principal",
          minlength : "Al menos 6 caracteres", maxlength: "maximo 15 caracteres" },
        "alternativePersonalID" :
          { minlength : "Al menos 6 caracteres", maxlength: "maximo 15 caracteres" },
        "firstName" : "Nombre es requerido",
        "lastName" : "Apellido es requerido",
        "idRelationType" : "Parentesco es Requerido",
        "idCountryResidence" : "País de Residencia es requerido",
        "idState" : "Estado o Provincia es requerido",
        "addressContact" : "Direccion es requerido",
        "localPhoneNumber" : "Debe llenarse al menos el Local o Movil" ,
        "mobilePhoneNumber" : "Debe llenarse al menos el Local o Movil" ,
        "principalEmail" : "Inválido"
      },

      submitHandler: function(form){
        var validator = this;
        console.log('ejecutando...');
        $.ajax({
          type : 'POST',
          url : form.action,
          beforeSend: function (jqXHR) {
            //console.log(form);
            /*if($('#idPersonalFile').val()==''){
              $('#label-form-pf').click();
              $('#send-button-pf').click();
              jqXHR.abort();
            }else{
              $("#send-button-ff").prop("disabled", true);
            }*/
          },
          data : $(form).serialize(),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        })
        .done(function(response){ // What to do if we succeed
          console.log(response);
          /*$("#send-button-ff").prop("disabled", false);
          //console.log(response.personalFile);
          //console.log($('#idPersonalFile').val());
          let errors= Array();
          if(response.foreignFile!=null
            && response.foreignFile.idForeignFile!=$('#idForeignFile').val()){
            errors['personalIDForeign']='Este documento ya está registrado';
            validator.showErrors( errors );
            validator.focusInvalid();
          }else{
            console.log('registrando');
            form.submit();
          }*/

        })
        .fail(function(jqXHR, textStatus, errorThrown) { // What to do if we fail
          //capturo el error de las validaciones de Laravel
           if(jqXHR.status==422){
             var errores = JSON.parse(jqXHR.responseText);
             //console.log(errores.errors);
             validator.showErrors( errores.errors );
             //$("#send-button-ff").prop("disabled", false);
           }else{
            //otros errores;
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
          }
        });
        }
    });


    $(this).hide();

  });


  //  initialize tooltipster on text input elements
    $('#store-pf input[type="text"],select,input[type="checkbox"],input[type=email]').tooltipster(
      window.objectValidator );

  //configure the validation
  //for Personal Data
  $('#store-pf').validate({
    validClass: "valid-element",
    errorElement: "div",
    errorClass: "invalid-element",
	  debug: true,
    errorPlacement:  function (error, element) {
      var lastError = $(element).data('lastError'),
          newError = $(error).text();
      $(element).data('lastError', newError);
      if(newError !== '' && newError !== lastError){
          $(element).tooltipster('content', newError);
          $(element).tooltipster('show');
      }
    },
    success : function (label, element) {
      $(element).tooltipster('hide');
    },
		rules: {
			"idCountry" : {	required: true, },
			"personalID" : { required: true, digits: true, minlength:6, maxlength:9,	},
      "officialGazette" : { required: "#naturalized:checked" },
      "officialGazetteDate" : { required: "#naturalized:checked", date: true },
      "emisionPersonalID" : { date: true, },
      "expirationPersonalID" :{ date: true, },
      "firstName" : { required:true, },
      "lastName" : { required:true, },
      "birthDate" : { required:true, date:true, },
      "birthPlace" : { required:true, },
      "passportNumber" : { required:true, digits: true, minlength:6, maxlength:18 },
      "emisionPassport" : { required:true,  date: true, },
      "expirationPassport" :{ required:true, date: true, },
      "civilState" : { required:true, },
      "idState" : { required:true, },
      "addressOrigin" : { required:true, },
      "principalEmail" : { required:true, email:true, },
      "secondaryEmail" : { email:true, },
      "birthFileDate" : { date:true, }
		},
		messages: {
			"idCountry" : "Selecciona la Nacionalidad",
      "officialGazette" : "Ingrese en número de gaceta",
      "officialGazetteDate" : "Fecha inválida",
			"personalID" : "Cédula inválida.",
      "emisionPersonalID" : "Fecha Emisión inválida",
      "expirationPersonalID" : "Fecha Expiración inválida",
      "firstName" : "Nombre es requerido",
      "lastName" : "Apellido es requerido",
      "birthDate" : "Fecha de Nacimiento es requerido",
      "birthPlace" : "Lugar de Nacimiento es requerido",
      "passportNumber" : "Pasaporte inválido",
      "emisionPassport" : "Fecha Emisión inválida",
      "expirationPassport" : "Fecha Expiración inválida",
      "civilState" : "Estado Civil es requerido",
      "idState" : "Estado es requerido",
      "addressOrigin" : "Direccion es requerido",
      "principalEmail" : "Correo Principal inválido",
      "secondaryEmail" : "Correo Secundario inválido",
      "birthFileDate" : "Fecha Acta inválida"
    },

    submitHandler: function(form){
      var validator = this;
      //console.log('ejecutando...');
      $.ajax({
        type : 'GET',
        url : '/Finanzas/masters/personalfile/findByPersonalID',
        beforeSend: function () {
          $("#send-button-pf").prop("disabled", true);
        },
        data : {
         "idCountry" : $('#idCountry').val(),
         "personalID" : $('#personalID').val()
       }
      })
      .done(function(response){ // What to do if we succeed
        $("#send-button-pf").prop("disabled", false);
        //console.log(response.personalFile);
        //console.log($('#idPersonalFile').val());
        let errors= Array();
        if(response.personalFile!=null
          && response.personalFile.idPersonalFile!=$('#idPersonalFile').val()){
          errors['personalID']='Cedula ya está registrada';
          validator.showErrors( errors );
          validator.focusInvalid();
        }else{
          console.log('registrando');
          form.submit();
        }

      })
      .fail(function(jqXHR, textStatus, errorThrown) { // What to do if we fail
        //capturo el error de las validaciones de Laravel
         if(jqXHR.status==422){
           var errores = JSON.parse(jqXHR.responseText);
           //console.log(errores.errors);
           validator.showErrors( errores.errors );
           $("#send-button-pf").prop("disabled", false);
         }else{
          //otros errores;
          console.log(JSON.stringify(jqXHR));
          console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
      });
      }
  });
  //for Foreign Data
  $('#store-ff').validate({
    validClass: "valid-element",
    errorElement: "div",
    errorClass: "invalid-element",
	  debug: true,
		rules: {
			"idCountry" : {	required: true, },
			"personalID" : { require_from_group: [1, ".foreigns-id-group"],
        minlength:6, maxlength:15,	},
      "emisionPersonalID" : { date: true, },
      "expirationPersonalID" :{ date: true, },
			"alternativePersonalID" : { require_from_group: [1, ".foreigns-id-group"],
        minlength:6, maxlength:15,	},
      "idState" : { required:true, digits:true },
      "addressForeign" : { required:true, },
      "localPhoneNumber" : {require_from_group: [1, ".foreigns-phone-group"]},
      "mobilePhoneNumber" : {require_from_group: [1, ".foreigns-phone-group"]},
      "dateIn" : { date:true, },
      "idImmigrationSituation" : {required : true },
      "sentenceDescription" : { required: "#hasSentence:checked" },
      "sentenceFrom" : { required: "#hasSentence:checked", date: true },
      "sentenceTo" : { required: "#hasSentence:checked", date: true }
		},
		messages: {
			"idCountry" : "Selecciona la Páis de Residencia"	,
			"personalID" :
        { require_from_group :"Debe llenado Documento o precaria",
       minlength : "Al menos 6 caracteres", maxlength: "maximo 15 caracteres" },
      "emisionPersonalID" : "Fecha Emisión inválida",
      "expirationPersonalID" : "Fecha Expiración inválida",
      "alternativePersonalID" :
        { require_from_group :"Debe llenado Documento o precaria",
       minlength : "Al menos 6 caracteres", maxlength: "maximo 15 caracteres" },
      "idState" : "Provincia/Estado es requerido",
      "addressForeign" : "Direccion es requerido",
      "localPhoneNumber" : "Debe llenarse al menos el Local o Movil",
      "mobilePhoneNumber" : "Debe llenarse al menos el Local o Movil",
      "dateIn" : "Fecha inválida",
      "idImmigrationSituation" : "Seleccione",
      "sentenceDescription" : "Ingrese la Condena",
      "sentenceFrom" : "Requerido",
      "sentenceTo" : "Requerido"
    },


    submitHandler: function(form){
      var validator = this;
      console.log('ejecutando...');
      $.ajax({
        type : 'GET',
        url : '/Finanzas/masters/personalfile/findByForeignID',
        beforeSend: function (jqXHR) {
          if($('#idPersonalFile').val()==''){
            $('#label-form-pf').click();
            $('#send-button-pf').click();
            jqXHR.abort();
          }else{
            $("#send-button-ff").prop("disabled", true);
          }
        },
        data : {
         "idCountry" : $('#idCountry').val(),
         "personalID" : $('#personalID').val()
       }
      })
      .done(function(response){ // What to do if we succeed
        $("#send-button-ff").prop("disabled", false);
        //console.log(response.personalFile);
        //console.log($('#idPersonalFile').val());
        let errors= Array();
        if(response.foreignFile!=null
          && response.foreignFile.idForeignFile!=$('#idForeignFile').val()){
          errors['personalIDForeign']='Este documento ya está registrado';
          validator.showErrors( errors );
          validator.focusInvalid();
        }else{
          console.log('registrando');
          form.submit();
        }

      })
      .fail(function(jqXHR, textStatus, errorThrown) { // What to do if we fail
        //capturo el error de las validaciones de Laravel
         if(jqXHR.status==422){
           var errores = JSON.parse(jqXHR.responseText);
           //console.log(errores.errors);
           validator.showErrors( errores.errors );
           $("#send-button-ff").prop("disabled", false);
         }else{
          //otros errores;
          console.log(JSON.stringify(jqXHR));
          console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
      });
      }
  });

});
