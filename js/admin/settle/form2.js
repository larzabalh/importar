$( document ).ready(function() {

  $('#type_receipt_id').off();

  $('#type_receipt_id').on('change', {type_id : $('#type_receipt_id')[0] }
   , window.type_receipt_fields);
   //console.log($('#type_receipt_id').val());
   if($('#type_receipt_id').val()!=''){
     var data = { data : {type_id : $('#type_receipt_id')[0] } };
     //console.log('aqui entro',data);
     window.type_receipt_fields( data );
   }
   console.log('valor:',$('#type_receipt_id').val());

  $("#general-button-save").prop("disabled", false);
  $('#period_query').on( 'keyup', function(e) {
    $('#period_id').val('');
    var phrase = this.value;
    $.ajax({
      type : 'GET',
      url : $("#route-period-list").val().trim()
              .replace('&param', phrase),
      beforeSend: function () {
      }
    })
    .done(function(response){
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
   setTimeout( function(){
     $("#period_query ~ ul").empty(); $('#period_query').val('');
   }, 1000);
 });
 //make readonly for dates
  $( "#receipt_date" ).prop('readonly', true);

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
 $('#period_query').mask('9999-99').attr({ maxLength : 10 });

 $("input[id^='amount_'").mask('99999999,99',
 { reverse : true, placeholder: "$ 0,00",
  'translation': {9: {pattern: /[0-9]/} } } )
  .attr({ maxLength : 12 })
  .on('keyup', function(ev){
    //console.log(this)
     window.recalculateFields(this)
   });


   $('#client_query ~ ul').on( 'mouseleave', function(e) {
     setTimeout( function(){
       $("#client_query ~ ul").empty(); $('#client_query').val('');
     }, 1000);
   });
   $('#client_query').on( 'keyup', function(e) {
     $('#person_id_relationed').val('');
     var phrase = this.value;
     $.ajax({
       type : 'GET',
       url : $("#route-person-list").val().trim()
               .replace('&param', phrase),
       beforeSend: function () {
       }
     })
     .done(function(response){
        var person = {};
        $("#client_query ~ ul").empty();

        $.each(response.data, function(){
          person = $('<li/>', { 'class' :'btn btn-default btn-block list-items-down' });
          person.text(this.field_name1+' ('+this.field_name2+')');
          person.attr('data-id', this.id);
          person.attr('data-name', this.field_name1);
          person.on('click', function(e) {
           $('#person_id_relationed').val(this.getAttribute('data-id'));
           $('#client_query').val(this.getAttribute('data-name'));
           $("#client_query ~ ul").empty();
          });

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
    $('#store-receipt2 [name^="amount["]').tooltipster(window.objectValidator);
    $('#store-receipt2 input[name],input[type="text"],select,input[type="checkbox"],input[type=email]').tooltipster(
      window.objectValidator );
  //configure the validation

  $('#general-button-save').on('click', function(){
    //console.log('clic en el boton');
    $('#store-receipt2').submit();
  });

  $('#generalModal').on('hide.bs.modal', function (e) {
    //console.log('cerrando modal');
    $("[class='tooltipster-box']").remove();

  });


  $( "#receipt_date" ).datepicker(
    { changeMonth: true, changeYear:true, dateFormat: 'yy-mm-dd', maxDate:new Date() }
  );


  //for receipt
  $('#store-receipt2').validate({
    validClass: "valid-element",
    errorElement: "div",
    errorClass: "invalid-element",
	  debug: true,
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
      "client_name" : { required: true, },
      "person_id_relationed" : { required : true, },
      "code_ticket" : { required:true, digits: true, minlength:1, maxlength:4 },
      "number" : { required:true, digits: true, minlength:2, maxlength:18 },
      "type_receipt_id" : { required:true,   },
      "status_id" : { required: true, }
		},
		messages: {
			"period_code" : "Seleccione el periodo",
      "period_id" : "Seleccione el periodo",
      "receipt_date" : "Fecha inválida",
      "client_name" : "Seleccione el Proveedor",
      "person_id_relationed" : "Seleccione el Proveedor",
      "code_ticket" : "Requerido",
      "number" : "Numero inválido",
      "type_receipt_id" : "Seleccione el Tipo de Comprobante",
      "status_id" : "Seleccione una"
    },

    submitHandler: function(form, e){
      var validator = this;
      //console.log('registrando...');
      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();
      $.ajax({
        type : 'POST',
        url : form.action ,
        beforeSend: function (xhr, opts) {
          if($.active>1){
            xhr.abort();
            return false;
          }
          $("#general-button-save").prop("disabled", true);
        },
        data : $(form).serialize(),
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      })
      .done(function(response){ // What to do if we succeed
        console.log(response);
        $("#general-button-save").prop("disabled", false);
        //console.log('registrado...');
        window.callback_module(window.module.type_id);

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
          $('#generalModal').scrollTop($("#alertsFlag").offset().top);
          $('.panel.panel-default').html('');
          $("#general-button-save").prop("disabled", true);
          $('#modal-add-place').html('');
          setTimeout( function(){
            $('#generalModal').modal('toggle');
          }, 2000);
        }else{
          $('#period_query').focus();
          $('#total-amount-mask').html('$ 0,00');
          $('#total-amount').val('0');
          $('.reset-mass').val(function() {
            return this.defaultValue;
          });
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

    var period_liquidation_close = ($('#period_liquidation_close').val()) ?
     JSON.parse($('#period_liquidation_close').val()) : null;
    //console.log(period_liquidation_close);
    if(period_liquidation_close!=null){
      //console.log(period_liquidation_close);
      $('input').prop('readonly', true).prop('disabled', true).off();
      $('select').prop('disabled', true);
      $("#general-button-save").hide().prop("disabled", true);
    }


});
