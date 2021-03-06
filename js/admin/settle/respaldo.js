$( document ).ready( function() {

  $('#period_query').on( 'keyup', function(e) {
    $('#period_id').val('');
    //console.log(e.key);
    //console.log(this.value);
    var phrase = this.value;
    $.ajax({
      type : 'GET', async: false,
      url : $("#route-period-list").val().trim()
              .replace('&param', phrase),
      beforeSend: function () {
        //$(".se-pre-con").fadeIn("fast");
      }
    })
    .done(function(response){
       //$("#period-query").append(response);
       //console.log(response);
       //console.log($("#period-query ~ ul"));
       var elemento = {};
       $("#period_query ~ ul").empty();

       $.each(response.data, function(){
         elemento = $('<li/>', { 'class' :'btn btn-default list-items' });
         elemento.text(this.code);
         elemento.attr('data-id', this.id);
         elemento.attr('data-name', this.code);
         elemento.on('click', function(e) {
           //console.log(this);
          $('#period_id').val(this.getAttribute('data-id'));
          $('#period_query').val(this.getAttribute('data-name'));
          $("#period_query ~ ul").empty();
        });
        $("#period_query ~ ul").append(elemento);
       });

    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      if(jqXHR.status==422){
        var errores = JSON.parse(jqXHR.responseText);
      }else{
       console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
     }
   });
 });
 $('#period_query ~ ul').on( 'mouseleave', function(e) {
   $("#period_query ~ ul").empty();
   $('#period_query').val('');
 });

 //make readonly for dates
  $( "#receipt_date" ).prop('readonly', true);
  $( "#expiration_date" ).prop('readonly', true);

   //validate only numbers
   $('#number').attr({ maxLength : 9 }).mask('999999999', {
     placeholder: '000000000',
     onKeyPress: function(cep, e, field, options) {
       $(field).val(String(options.placeholder +
         cep).slice(-(options.placeholder.length-1)));
     }
   });
   $('#code_ticket').attr({ maxLength : 5 }).mask('99999', {
     placeholder : '00000',
     onKeyPress: function(cep, e, field, options) {
       $(field).val(String(options.placeholder +
         cep).slice(-(options.placeholder.length-1)));
     }
   });
   $('#period_query').mask('9999-99').attr({ maxLength : 8 });

   $("input[id^='amount_'").mask('99999999,99',
   { reverse : true, placeholder: "$ 0,00",
    'translation': {9: {pattern: /[0-9]/} } } )
    .attr({ maxLength : 12 })
    .on('keyup', function(e){
      var temp = this.id.replace('amount_', '');
      var value = parseFloat($(this).val().replace(',', '.'));
      var calculate = 0; var calculate_total=0;
      if(value>0){
        calculate = (value * parseFloat($('#percent_iva_'+temp).val()))/100;
      }
      $('#iva_amount_'+temp).val(calculate);
      $.each( $("input[id^='amount_'"), function(index, item){
        calculate = 0;
        var temp2 = item.id.replace('amount_', '');
        if(document.getElementById('iva_amount_'+temp2)){
          if(  parseFloat($('#iva_amount_'+temp2).val())>0 ){
            calculate = parseFloat($('#iva_amount_'+temp2).val());
          }
        } else { calculate = 0 }
        if(parseFloat(item.value)>0){
          calculate_total += parseFloat(item.value) + calculate ;
        }
      });
      $('#total-amount').val(calculate_total);
      $('#total-amount-mask').html('$ '+calculate_total.toString().replace('.', ','));

    });


   $('#client_query ~ ul').on( 'mouseleave', function(e) {
     $("#client_query ~ ul").empty();
     $('#client_query').val('');
   });
   $('#client_query').on( 'keyup', function(e) {
     $('#person_id_relationed').val('');
     //console.log(e.key);
     //console.log(this.value);
     var phrase = this.value;
     $.ajax({
       type : 'GET', async: false,
       url : $("#route-person-list").val().trim()
               .replace('&param', phrase),
       beforeSend: function () {
         //$(".se-pre-con").fadeIn("fast");
       }
     })
     .done(function(response){
        //$("#client-query").append(response);
        //console.log(response);
        //console.log($("#client-query ~ ul"));
        var person = {};
        $("#client_query ~ ul").empty();

        $.each(response.data, function(){
          person = $('<li/>', { 'class' :'btn btn-default btn-block list-items-down' });
          person.text(this.field_name1+' ('+this.field_name2+')');
          person.attr('data-id', this.id);
          person.attr('data-name', this.field_name1);
          person.on('click', function(e) {
            //console.log(this);
           $('#person_id_relationed').val(this.getAttribute('data-id'));
           $('#client_query').val(this.getAttribute('data-name'));
           $("#client_query ~ ul").empty();
          });

          //console.log(person);
          $("#client_query ~ ul").append(person);
        });

     })
     .fail(function(jqXHR, textStatus, errorThrown) {
       if(jqXHR.status==422){
         var errores = JSON.parse(jqXHR.responseText);
       }else{
        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
      }
    });
  });



  //  initialize tooltipster on text input elements
    $('#store-receipt [name^="amount["]').tooltipster({
        theme: ['tooltipster-light', 'tooltipster-light-validate'],
        animation: 'fade',
        delay: 300,
        trigger: 'custom',
        onlyOne: false,
        position: [ 'right'],
        distance: 3
      });
    $('#store-receipt input[name],input[type="text"],select,input[type="checkbox"],input[type=email]').tooltipster({
      theme: ['tooltipster-light', 'tooltipster-light-validate'],
      animation: 'fade',
      delay: 300,
      trigger: 'custom',
      onlyOne: false,
      position: ['top', 'right', 'bottom', 'left'],
      distance: 3
    });
  //configure the validation

  $('#general-button-save').on('click', function(){
    //console.log('clic en el boton');
    $('#store-receipt').submit();
  });

  $('#generalModal').on('hide.bs.modal', function (e) {
    //console.log('cerrando modal');
    $("[class='tooltipster-box']").remove();

  });


  $( "#receipt_date" ).datepicker(
    { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd', maxDate:new Date() }
  );

  $( "#expiration_date" ).datepicker(
     { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd', maxDate:new Date() }
   );

  //for receipt

  var validator = $( "#store-receipt" ).validate();
  validator.destroy();

  validator.validate({
    validClass: "valid-element",
    errorElement: "div",
    errorClass: "invalid-element",
	  debug: false,
    errorPlacement:  function (error, element) {
      var lastError = $(element).data('lastError'),
          newError = $(error).text();
      $(element).data('lastError', newError);
      if(newError !== '' && newError !== lastError){
        //console.log(element.attr("name"));
        //console.log(element);
        if (element.attr("name") == "fname" || element.attr("name") == "lname" ) {
          /*$('#'+Object.keys( element )[0]).focus()
          $(element).tooltipster('content', newError);
          $(element).tooltipster('show');*/
        } else {
          $(element).tooltipster('content', newError);
          $(element).tooltipster('show');
        }
      }
    },
    success : function (label, element) {
      $(element).tooltipster('hide');
    },
    //ignore : [ "submit", "reset", "[disabled]", "hidden", "not[name]" ],
    ignore : [ ":hidden[name!='no-use']" ],
		rules: {
			"period_code" : {	required: true, },
  		"period_id" : {	required: true, },
			"receipt_date" : { required: '#period_query', date: true,
        maxDatePeriod : [ 'yy-mm-dd', '#period_query' ]   },
      "expiration_date" : { date: true, },
      "client_name" : { required: true, },
      "person_id_relationed" : { required : true, },
      "code_ticket" : { required:true, digits: true, minlength:1, maxlength:4 },
      "number" : { required:true, digits: true, minlength:2, maxlength:18 },
      "type_receipt_id" : { required:true,   },
      "status_id" : { required: true, },
      "zone_id" : { required:true },
      "activity_id" : { required:true }
		},
		messages: {
			"period_code" : "Seleccione el periodo",
      "period_id" : "Seleccione el periodo",
      "receipt_date" : "Fecha inválida",
			"expiration_date" : "Fecha inválida.",
      "client_name" : "Seleccione el Cliente",
      "person_id_relationed" : "Seleccione el Cliente",
      "code_ticket" : "Requerido",
      "number" : "Numero inválido",
      "type_receipt_id" : "Seleccione el Tipo de Comprobante",
      "status_id" : "Seleccione una",
      "zone_id" : "Seleccione la Zona",
      "activity_id" : "Selecciona la Actividad",
    },

    submitHandler: function(form, e){
      var validator = this;
      console.log('registrando...');
      //console.log(form);
      e.preventDefault();
      e.stopPropagation()
      $.ajax({
        type : 'POST', async: false,
        url : form.action ,
        beforeSend: function () {
          $("#general-button-save").prop("disabled", true);
        },
        data : $(form).serialize(),
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      })
      .done(function(response){ // What to do if we succeed
        console.log(response);
        //$("#general-button-save").prop("disabled", false);
        //console.log(response.personalFile);
        //console.log($('#idPersonalFile').val());
        console.log('registrado...');
        window.callback_module(1);

        var divln = $('<div>')
.attr('class', 'alert alert-success alert-dismissable animate-alert-top fade in');
        var buttonln = $('<button>').attr('type', 'button')
          .attr('class', 'close').attr('data-dismiss', 'alert')
          .attr('aria-hidden', 'true');
        var iln = $("<i>").attr("class", "fa fa-close")
          .attr("aria-hidden", "true").attr("title", 'Cerrar')
          .attr("id", 'alertMessaje');
        var spanln = $("<span>").text('Guardado Exitosamente');

        $(buttonln).append( $(iln) );
        $(divln).append( $(buttonln) );
        $(divln).append( $(spanln) );
        $('#alertsFlag').empty();
        $('#alertsFlag').append( $(divln) );

        if(document.getElementById('receipt_id')){
          $('#generalModal').scrollTop($("#alertsFlagIIBB").offset().top);
          //$('#generalModal .modal-content .modal-header .modal-title').html('Cambio de Empresa');
          /*setTimeout( function(){
            $('#generalModal').modal('toggle');
          }, 1500);*/
        }else{
          //$(form)[0].reset();
          $('#period_query').focus();
          $('#total-amount-mask').html('$ 0,00');
          $('#total-amount').val('0');
        }

      })
      .fail(function(jqXHR, textStatus, errorThrown) { // What to do if we fail
        //capturo el error de las validaciones de Laravel
        if(jqXHR.status==422){
          var errores = JSON.parse(jqXHR.responseText);
           console.log(errores.errors);
           //window.errores = errores.errors;
           var err = $( errores.errors ).filter(function( key, el){
              var patt=/amount\.\d+/g;
              //console.log(Object.keys(el).toString());
             return !patt.test(Object.keys(el).toString())
           });
           //window.err = err;
          if(err.length>0){
            validator.showErrors( errores.errors );
          }else{

            var divln = $('<div>')
    .attr('class', 'alert alert-danger alert-dismissable animate-alert-top fade in');
            var buttonln = $('<button>').attr('type', 'button')
              .attr('class', 'close').attr('data-dismiss', 'alert')
              .attr('aria-hidden', 'true');
            var iln = $("<i>").attr("class", "fa fa-close")
              .attr("aria-hidden", "true").attr("title", 'Cerrar')
              .attr("id", "alertMessaje");
           var texto = 'Al menos debe de estar algún monto de Ingresos Brutos mayor a cero (0)';
            var spanln = $("<span>").text(texto);

            $(buttonln).append( $(iln) );
            $(divln).append( $(buttonln) );
            $(divln).append( $(spanln) );
            $('#alertsFlagIIBB').empty();
            $('#alertsFlagIIBB').append( $(divln) );
            $('#generalModal').scrollTop($("#alertsFlagIIBB").offset().top);
            $('#alertsFlagIIBB').focus();
          }

          //console.log(errores.errors[0]);
          $('#'+Object.keys( errores.errors )[0]).focus()
          $("#general-button-save").prop("disabled", false);
        }else{
         //otros errores;
         console.log(JSON.stringify(jqXHR));
         console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
       }
      });
    }

  });

  $('[name^="amount["]').each(function() {
        $(this).rules('add', {
            require_from_group: [1, ".amount-group"],
            //spanishMoneyFormat: true,
            messages: {
                require_from_group: "Al menos uno de ellos y Mayor a 0,01"
                //spanishMoneyFormat : "Al menos uno y Mayor a 0,01"
            }
        });
        $(this).on('blur', function(e){
          //console.log($(this).val().replace(',', '.'))
          //console.log(parseFloat($(this).val().replace(',', '.')))
          if(parseFloat($(this).val().replace(',', '.'))<=0.01){
            $(this).val('');
          }
        });
    });


/*

  $('#operations .icon-user,.icon-module').tooltipster({
    theme: ['tooltipster-light'],  animation: 'fade',  delay: 200,
    trigger: 'hover',  onlyOne: false, position: ['top'],
  });
  $('#back-item').tooltipster({
    theme: ['tooltipster-light'],   animation: 'fade',  delay: 300,
    trigger: 'hover', position: ['bottom'], distance: 3, 'content': 'Volver'});

  $('#operations .icon-module').tooltipster( 'content', 'Editar Modulos Acceso');
  $('#operations .icon-user').tooltipster( 'content', 'Editar User');

  $( "#generarPassword" ).on( "click", function() {
    var pass = RandomPassword(8, true, true, true);
    $( "#claveUser" ).val(pass);
    $( "#claveUser-confirm" ).val(pass);
  });

  $( "#verPassword" ).on( "mousedown", function() {
    $( "#claveUser" ).attr('type', 'text');
  });

  $( "#verPassword" ).on( "mouseup", function() {
    $( "#claveUser" ).attr('type', 'password');
  });

  //configure the validation
  $('#add-form').validate({
	   debug: true,
		rules: {
			"loginUser": {	required: true },
			"emailUser": { required: true, email: true	},
      "claveUser": { required: true, minlength: 6 },
      "claveUser_confirmation": { minlength: 6, equalTo: "#claveUser" },
      "avatar": { extension: "jpg|png|gif" }
		},
		messages: {
			"loginUser": "Ingresa el login."	,
			"emailUser": "Email invalido." ,
      "claveUser": { required :"Password requerido",
        minlength: jQuery.validator.format("Al menos {0} caracteres requiere!")
     },
      "claveUser_confirmation": {
        minlength: jQuery.validator.format("Al menos {0} caracteres requiere!"),
        equalTo: "Password no coinciden." },
      "avatar": { extension: "Solo puede subir archivos de tipo imagen (jpg, png, gif)" }
		},

    submitHandler: function(form){
      var validator = this;
      console.log('ejecutando...');
      $.ajax({
        type : 'GET',
        url : '/Logistica/security/users/validateNewDuplicated',
        beforeSend: function () {
          $("#send-button").prop("disabled", true);
        },
        data : {
         "loginUser" : $('#loginUser').val(),
         "emailUser" : $('#emailUser').val()
       }
      })
      .done(function(response){ // What to do if we succeed
        //console.log(response);
        console.log('registrando');
        form.submit();
        $("#send-button").prop("disabled", false);
      })
      .fail(function(jqXHR, textStatus, errorThrown) { // What to do if we fail
        //capturo el error de las validaciones de Laravel
         if(jqXHR.status==422){
           var errores = JSON.parse(jqXHR.responseText);
           //console.log(errores.errors);
           validator.showErrors( errores.errors );
           $("#send-button").prop("disabled", false);
         }else{
          //otros errores;
          console.log(JSON.stringify(jqXHR));
          console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
      });
      }
  });*/

});
