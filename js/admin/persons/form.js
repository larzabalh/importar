window.verifyDocument = function(documento, type) {
	if(type.length==0) {		return false;	}
	console.log('validando '+type);
	if(type=='CUIT'){
		if(documento.length !=13){			return false;		}
		var acumulado 	= 0;
		var digitos 	= documento.split("-");
		var digito	= digitos[2];
		var todos = digitos[0].split("").concat(digitos[1].split(""));

		for(var i = 0; i < todos.length; i++) {
			acumulado += todos[9 - i] * (2 + (i % 6));
		}
		var verif = 11 - (acumulado % 11);
		if(verif == 11) {			verif = 0;		}
		return digito == verif;
	}else if(type=='CUIL'){
		if(documento.length !=13){			return false;		}
		return true;
	}else{
		if(documento.length <4){			return false;		}		return true;
	}
	return false;
}

$( document ).ready(function() {
	$('#document_type').off();
	$("#document").off();

	$('#general-button-save').off();
	$('#store-person').off();

  $('#general-button-save').prop('disabled', false);

	$('#document_type').on('change', function(ev){
		if(this.value=='CUIT' || this.value=='CUIL'){
			$("#document").attr({ maxLength : 13 }).mask('99-99999999-9',
			{ reverse : true, placeholder: "20-12345678-9",
			 'translation': {9: {pattern: /[0-9]/} } } );
		}else if(this.value=='DNI'){
			$("#document").attr({ maxLength : 8 }).mask('99999999',
			{ reverse : true, placeholder: "12345678",
			 'translation': {9: {pattern: /[0-9]/} } } );
		}else{
			window.validator.showErrors({
				"document": "Tipo de documento ó Documento inválido"
			});
			return false;
		}
	});

	$("#document").on('blur', function(ev){
		 //console.log(this);
		 if(!window.verifyDocument(this.value, $('#document_type').val())){
			 window.validator.showErrors({
			   "document": "Tipo de documento ó Documento inválido"
			 });
		 }
    });

//  initialize tooltipster on text input elements
  /*$('#store-person [name^="amount["]').tooltipster(window.objectValidator);*/

	$('#store-person input[name], #store-person select, '+
		'#store-person input[type="checkbox"], #store-person input[type="radio"]').tooltipster(
		window.objectValidator );

	//configure the validation
	$('#general-button-save').off();

	$('#general-button-save').on('click', function(ev){
		ev.preventDefault();
		console.log('clic en el boton');
		$('#store-person').submit();
	});
	//when modal was hide, hide the toolstipsters
	$('#generalModal').on('hide.bs.modal', function (e) {
		//console.log('cerrando modal');
		$("[class='tooltipster-box']").remove();
	});

  //for validate and save
  window.validator = $('#store-person').validate({
    validClass: "valid-element",
    errorElement: "div",
    errorClass: "invalid-element",
	  debug: true,
    errorPlacement:  function (error, element) {
			var lastError = $(element).data('lastError'),
					newError = $(error).text();
			$(element).data('lastError', newError);
			$(element).tooltipster('content', newError);

			if(Object.keys(window.validator.errorMap).length>0 &&
				$('[name="'+Object.keys(window.validator.errorMap)[0]).parents('.tab-pane')[0].id
			  == element.parents('.tab-pane')[0].id){
				$(element).tooltipster('show');
			}
			//$(element).tooltipster('show');
    },
		invalidHandler: function(event, validator) {
			//console.log('handler');
			//console.log($(validator.currentElements[0]));
			var cambio = $(validator.currentElements[0]);
			$('#'+$('[name="'+Object.keys(window.validator.errorMap)[0])
				.parents('.tab-pane')[0].id+'-tab').click();
			setTimeout( function(){
				validator.showErrors( window.validator.errorMap );
			}, 500);
		},
    success : function (label, element) {
      $(element).tooltipster('hide');
    },
    ignore : [ ":hidden[name!='no-use']" ],
		rules: {
			"document_type" : {	required: true, },
  		"document" : {	required: true, },
			"field_name1" : { required: true, }
		},
		messages: {
			"document_type" : "Seleccione",
      "document" : "Ingrese el documento",
      "field_name1" : "Ingrese el nombre"
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
          $("#general-button-save").prop("disabled", true);
        },
        data : $(form).serialize(),
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      })
      .done(function(response){ // What to do if we succeed
        //console.log(response);
				//console.log('Ahora aqui');
        $("#general-button-save").prop("disabled", false);
        //console.log('registrando...');
        window.callback_module(1, '#principal-data');

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

        if(document.getElementById('person_id')){
          $('#generalModal').scrollTop($("#alertsFlag").offset().top);
          $('.panel.panel-default').html('');
          $("#general-button-save").prop("disabled", true);
          $('#modal-add-place').html('');

        }else{
          /*$('#period_query').focus();
          $('#total-amount-mask').html('$ 0,00');
          $('#total-amount').val('0');
          $('.reset-mass').val(function() {
            return this.defaultValue;
          });*/

        }
				setTimeout( function(){
					$('#generalModal').modal('toggle');
				}, 1000);
				window.reloadPersons();

      })
      .fail(function(jqXHR, textStatus, errorThrown) {
				//console.log(jqXHR);
				//console.log(textStatus);
				//console.log(errorThrown	);

				var errores = $.parseJSON(jqXHR.responseText);
				 console.log(errores);
        //capturo el error de las validaciones de Laravel
         if(jqXHR.status==422){
            window.errores = errores.errors;
						//para las cantidades
            var e_quantity = $( errores.errors ).filter(function( key, el){
               var patt=/_quantity/;
              return patt.test(Object.keys(el).toString())
            });
						//para los errores con los datos array de las zonas (futuro)\

						//para todos los demas
						var err = $( errores.errors ).filter(function( key, el){
               var patt=/_quantity/; var patt2 = /sifere/; var patt3 = /aliquot/;
              return !patt.test(Object.keys(el).toString())
							 	&& !patt2.test(Object.keys(el).toString())
								&& !patt3.test(Object.keys(el).toString())
            });
            //window.err = err;
           if(err.length>0){
						 $('#'+$('[name="'+Object.keys(err[0])[0]).parents('.tab-pane')[0]
						 	.id+'-tab').click();
             validator.showErrors( err[0] );
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

});
