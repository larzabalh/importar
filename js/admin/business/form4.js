$( document ).ready(function() {

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

 $('#period_query').mask('9999-99').attr({ maxLength : 10 });

 $("#amount").mask('99999999,99',
 { reverse : true, placeholder: "$ 0,00",
  'translation': {9: {pattern: /[0-9]/} } } )
  .attr({ maxLength : 12 })
  .on('keyup', function(e){
    var temp = this.id.replace('amount_', '');
    var value = parseFloat($(this).val().replace(',', '.'));
    var calculate = 0; var calculate_total=0;
    $('#total-amount').val(value);
    $('#total-amount-mask').html('$ '+value.toString().replace('.', ','));
  } )
  ;


  //  initialize tooltipster on text input elements
    $('#store-receipt4 input[name],input[type="text"],select,input[type="checkbox"],input[type=email]').tooltipster(
      window.objectValidator);
  //configure the validation

  $('#general-button-save').on('click', function(){
    $('#store-receipt4').submit();
  });

  $('#generalModal').on('hide.bs.modal', function (e) {
    $("[class='tooltipster-box']").remove();
  });

  //for receipt
  $('#store-receipt4').validate({
    validClass: "valid-element",
    errorElement: "div",
    errorClass: "invalid-element",
	  debug: true,
    errorPlacement:  function (error, element) {
      var lastError = $(element).data('lastError'),
          newError = $(error).text();
      $(element).data('lastError', newError);
      if(newError !== '' && newError !== lastError){
        if (element.attr("name") == "fname" || element.attr("name") == "lname" ) {
        } else {
          $(element).tooltipster('content', newError);
          $(element).tooltipster('show');
        }
      }
    },
    success : function (label, element) {
      $(element).tooltipster('hide');
    },
    ignore : [ ":hidden[name!='no-use']" ],
		rules: {
			"period_code" : {	required: true, },
  		"period_id" : {	required: true, },
      "zone_id" : { required:true },
      "amount" : {required: true, pattern: /^[0-9]{1,9}\,{0,1}([0-9]{0,3})$/ }
		},
		messages: {
			"period_code" : "Seleccione el periodo",
      "period_id" : "Seleccione el periodo",
      "zone_id" : "Seleccione la Zona",
      "amount" : "Monto inválido"
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
             $('#alertsFlag').empty();
             $('#alertsFlag').append( $(divln) );
             $('#generalModal').scrollTop($("#alertsFlag").offset().top);
             $('#alertsFlag').focus();
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
