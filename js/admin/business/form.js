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

//window.oldValue=0;
/*window.assignOldValue = function(ev){
	//console.log($('#'+ev.target.id).val());
	var valor = parseFloat($('#'+ev.target.id).val().replace(',', '.'));
	window.oldValue = (valor==NaN)?0:valor;
}*/

window.iibbCalculates = function(id){
	var total = 0;
	$('input[name^="sifere_coef["]').each(function(key, el){
		if(id!=undefined && id!='' && id!=null && id==el.id){
			valor=0;
		}else{
			valor = parseFloat(this.value.replace(',', '.'))
			valor = (valor==NaN)?0:valor;
		}
		total += valor;
	});
	return total;
}

var deleteActivity = function(ev){
	$("#activity_id").append(
		$('<option>', { value: this.getAttribute('data-id'),
				text: this.getAttribute('data-text') })
	);
	$('#activity_id').sortSelect();
	$('#tr_activity_'+this.getAttribute('data-id')).remove();
	$('#activity_quantity').val(parseFloat($('#activity_quantity').val())-1);
}
var deleteZone = function(ev){
	$("#zone_id").append(
		$('<option>', { value: this.getAttribute('data-id'),
				text: this.getAttribute('data-text') })
	);
	$('#zone_id').sortSelect();
	$('#tr_zone_'+this.getAttribute('data-id')).remove();
	$('#zone_quantity').val(parseFloat($('#zone_quantity').val())-1);
}
var deleteLiquidator = function(ev){
	$("#liquidator_id").append(
		$('<option>', { value: this.getAttribute('data-id'),
				text: this.getAttribute('data-text') })
	);
	$('#liquidator_id').sortSelect();
	$('#tr_liquidator_'+this.getAttribute('data-id')).remove();
	$('#liquidator_quantity').val(parseFloat($('#liquidator_quantity').val())-1);
}
var deletePayMethod = function(ev){
	$("#pay_method_id").append(
		$('<option>', { value: this.getAttribute('data-id'),
				text: this.getAttribute('data-text') })
	);
	//ordeno el Select
	$('#pay_method_id').sortSelect();
	$('#tr_pay_method_'+this.getAttribute('data-id')).remove();
	$('#pay_method_quantity').val(parseFloat($('#pay_method_quantity').val())-1);
}
var keyUpSifereCoef = function(ev){
	curr_val = 0;
	curr_val = parseFloat($(this).val().replace(',', '.'));
	//if(parseFloat($('#zone_quantity').val())===1){
		if(curr_val>1){ $(this).val('1');	return false;	}
	/*}else{
		permitido=1-window.iibbCalculates(this.id);
		if(permitido<curr_val){
			$(this).val(permitido.toFixed(4).replace('.', ','));
			return false;
		}
	}*/
};

$( document ).ready(function() {
	$('#document_type').off();
	$("#document").off();

	$('#general-button-save').off();
	$('#store-business').off();

  $('#general-button-save').prop('disabled', false);

  $('#person_configuration_id').prop('readonly', true);

	if( $('#liquidation_start_period').val() ){
		$('#liquidation_start_period').prop('readonly' ,  true);
	}

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
  /*$('#store-business [name^="amount["]').tooltipster(window.objectValidator);*/

  $('#btn-add-activity').off();
	$('#btn-add-activity').on('click', function(ev){
		//alert('en actividad...');
		ev.preventDefault();
		var x = parseFloat($('#activity_quantity').val())+1;
		var curr_act = $('#activity_id');
		//valido que tenga una actividad seleccionada
		if(!curr_act.val()){
			$(curr_act).tooltipster('show');
			window.validator.showErrors({ "activity_id": "Debe seleccionar la Actividad" });
			return false;
		}else{
			//Genero los td de:
			//Nombre e id (oculto, usando array)
			var span1 = $('<span>').text(curr_act[0].selectedOptions[0].innerHTML);
			var input1 = $('<input>').attr('name', 'activity_id['+curr_act.val()+']')
				.attr('value', curr_act.val()).attr('type', 'hidden').attr('class', 'no-val');
			var td1 = $('<td>').append($(span1)).append($(input1));
			//Operacion de eliminar la fila, esta debe tener una confirmacion
			//	tipo globo tooltip con boton aceptar y cancelar.
			var button2 = "<button id='delete_activity_"+x+"' type='button'"+
			 "data-id='"+curr_act.val()+"' data-text='"+curr_act[0].selectedOptions[0].innerHTML
			 +"' class='business-delete btn btn-danger'><i class='fa fa-trash'></i></button>";
			 var td2 = $('<td>').html(button2);
			 //Genero el tr
	 		var tr1 = $('<tr>').attr('id', 'tr_activity_'+curr_act.val()).append($(td1)).append($(td2));
			//lo appendeo en la tabla
			$('#data-activities').append( $(tr1) );
			//se elimina con remove del DOM y vuelve a agregarlo al select
			$('#delete_activity_'+x).on('click', deleteActivity);
			$('#store-business input[type=text], #store-business input[type=number]').tooltipster( window.objectValidator);
		}

		//blanqueo el activity_id
		$("#activity_id option[value='"+curr_act.val()+"']").remove();
		curr_act[0].selectedIndex=0;
		$('#activity_quantity').val(x);
		$(curr_act).tooltipster('hide');
	});
	$('[id^="delete_activity_"]').each(function(){
		$(this).on('click', deleteActivity);
	});

	$('#btn-add-zone').off();
	$('#btn-add-zone').on('click', function(ev){
		//alert('aqui voy'); //console.log(ev);
		ev.preventDefault();
		var x = parseFloat($('#zone_quantity').val())+1;
		var curr_act = $('#zone_id');
		//valido que tenga una actividad seleccionada
		if(!curr_act.val()){
			$(curr_act).tooltipster('show');
			window.validator.showErrors({ "zone_id": "Debe seleccionar la Zona" });
			return false;
		}else{
			/*if(window.iibbCalculates()===1){
				$(curr_act).tooltipster('show');
				window.validator.showErrors({ "zone_id":
			 "El coeficiente de sifere esta al maximo, disminuya alguno para agregar otra zona" });
				return false;
			}
			if(parseFloat($('#zone_quantity').val())!=0 && window.iibbCalculates()===0){
				$(curr_act).tooltipster('show');
				window.validator.showErrors({ "zone_id":
			 		"Agregue el valor a los coeficientes vacios" });
				return false;
			}*/

			sifere_coef = parseFloat(1-window.iibbCalculates()).toFixed(4).replace('.', ',');
			//Genero los td de:
			//Nombre e id (oculto, usando array)
			var span1 = $('<span>').text(curr_act[0].selectedOptions[0].innerHTML);
			var input1 = $('<input>').attr('name', 'zone_id['+curr_act.val()+']')
				.attr('value', curr_act.val()).attr('type', 'hidden');
			var td1 = $('<td>').append($(span1)).append($(input1));
			//Input para Coef
			var input2 = $('<input>').attr('name', 'sifere_coef['+curr_act.val()+']')
				.attr('id', 'sifere_coef_'+curr_act.val())
				.attr('class', 'form-control').attr('type', 'text').mask('9,9999',
			  	{ reverse : false, placeholder: "0,0000",
				 'translation': {9: {pattern: /[0-9]/}} } ).attr({ maxLength : 6 })
				 .ForceNumericOnly().attr('value', sifere_coef)
				 .on('keyup', keyUpSifereCoef);
			var td2 = $('<td>').append($(input2));
			//Input para Aliquot
			var input3 = $('<input>').attr('name', 'iibb_aliquot['+curr_act.val()+']')
				.attr('id', 'iibb_aliquot_'+curr_act.val()+'')
				.attr('class', 'form-control').attr('type', 'text')
				//.attr('step', 0.01).attr('min', 1).attr('max', 50)
				.mask('99,99', { reverse : false, placeholder: "% 0,00",
				 'translation': {9: {pattern: /[0-9]/} } } ).attr({ maxLength : 5 });
			var td3 = $('<td>').append($(input3));
			//Operacion de eliminar la fila, esta debe tener una confirmacion
			//	tipo globo tooltip con boton aceptar y cancelar.
			var button4 = "<button id='delete_zone_"+x+"' type='button'"+
			 "data-id='"+curr_act.val()+"' data-text='"+curr_act[0].selectedOptions[0].innerHTML
			 +"' class='business-delete btn btn-danger'><i class='fa fa-trash'></i></button>";
			 var td4 = $('<td>').html(button4);
			 //Genero el tr
	 		var tr1 = $('<tr>').attr('id', 'tr_zone_'+curr_act.val()).append($(td1)).append($(td2))
				.append($(td3)).append($(td4));
			//lo appendeo en la tabla
			$('#data-zones').append( $(tr1) );

			$('input[name^="sifere_coef["], input[name^="iibb_aliquot["]').tooltipster( window.objectValidator);

			//se elimina con remove del DOM y vuelve a agregarlo al select
			$('#delete_zone_'+x).on('click', deleteZone);
		}

		//blanqueo el zone_id
		$("#zone_id option[value='"+curr_act.val()+"']").remove();
		curr_act[0].selectedIndex=0;
		$('#zone_quantity').val(x);
		$(curr_act).tooltipster('hide');

		//agrego las validaciones al validador de jquery
		$('[name^="sifere_coef["], [name^="iibb_aliquot["]').each(function() {
			$(this).rules('add', { required: true, messages: { required :"Valor invalido" } });
			$(this).on('blur', function(e){
				if($(this).val()=='' || parseFloat($(this).val().replace(',', '.'))<=0.0001){
					$(this).val('');
				}
			});
		});

	});
	$('[id^="delete_zone_"]').each(function(){
		$(this).on('click', deleteZone);
	});

	$('[name^="sifere_coef["]')
		.mask('9,9999', { reverse : false, placeholder: "0,0000",
	 'translation': {9: {pattern: /[0-9]/}} } ).attr({ maxLength : 6 })
	.each(function() {	$(this).on('keyup', keyUpSifereCoef); });

	$('[name^="iibb_aliquot["]').mask('99,99',
		{ reverse : true, placeholder: "% 0,00",
		'translation': {9: {pattern: /[0-9]/} } } ).attr({ maxLength : 5 } );

	var initial_date = 2016;

	$('#liquidation_start_period').attr({ maxLength : 7 }).mask('2099-99',
		{ reverse : false, placeholder: "2018-01",
		'translation': {9: {pattern: /[0-9]/} } })
		.on('keyup', function(ev){
			var temp = this.value.split('-');
			var valor = parseFloat(temp[0]); var valor2 = parseFloat(temp[1]);
			//console.log(temp);
			if(temp.length===1 && !(valor===2 || valor===20 || valor===200 || (valor>=201 && valor<=209)
			 	|| valor>=2000 )){
					this.value=this.value.substr(0,(this.value.length-1));
			}else if ( temp.length===2 && (valor2>=1 && valor2<=12) ){

			}else{
				this.value=this.value.substr(0,5);
			}
		});

  $('#btn-add-liquidator').off();
	$('#btn-add-liquidator').on('click', function(ev){
		//alert('en actividad...');
		ev.preventDefault();
		var x = parseFloat($('#liquidator_quantity').val())+1;
		var curr_act = $('#liquidator_id');
		//valido que tenga una actividad seleccionada
		if(!curr_act.val()){
			$(curr_act).tooltipster('show');
			window.validator.showErrors({ "liquidator_id": "Debe seleccionar al Liquidador" });
			return false;
		}else{
			//Genero los td de:
			//Nombre e id (oculto, usando array)
			var span1 = $('<span>').text(curr_act[0].selectedOptions[0].innerHTML);
			var input1 = $('<input>').attr('name', 'liquidator_id['+curr_act.val()+']')
				.attr('value', curr_act.val()).attr('type', 'hidden');
			var td1 = $('<td>').append($(span1)).append($(input1));
			//Operacion de eliminar la fila, esta debe tener una confirmacion
			//	tipo globo tooltip con boton aceptar y cancelar.
			var button2 = "<button id='delete_liquidator_"+x+"' type='button'"+
			 "data-id='"+curr_act.val()+"' data-text='"+curr_act[0].selectedOptions[0].innerHTML
			 +"' class='business-delete btn btn-danger'><i class='fa fa-trash'></i></button>";
			 var td2 = $('<td>').html(button2);
			 //Genero el tr
	 		var tr1 = $('<tr>').attr('id', 'tr_liquidator_'+curr_act.val()).append($(td1)).append($(td2));
			//lo appendeo en la tabla
			$('#data-liquidators').append( $(tr1) );
			//se elimina con remove del DOM y vuelve a agregarlo al select
			$('#delete_liquidator_'+x).on('click', deleteLiquidator);
		}

		//blanqueo el activity_id
		$("#liquidator_id option[value='"+curr_act.val()+"']").remove();
		curr_act[0].selectedIndex=0;
		$('#liquidator_quantity').val(x);
		$(curr_act).tooltipster('hide');
	});
	$('[id^="delete_liquidator_"]').each(function(){
		$(this).on('click', deleteLiquidator);
	});

  $('#btn-add-pay_method').off();
	$('#btn-add-pay_method').on('click', function(ev){
		//alert('en actividad...');
		ev.preventDefault();
		var x = parseFloat($('#pay_method_quantity').val())+1;
		var curr_act = $('#pay_method_id');
		//valido que tenga una actividad seleccionada
		if(!curr_act.val()){
			$(curr_act).tooltipster('show');
			window.validator.showErrors({ "pay_method_id": "Debe seleccionar un metodo de pago" });
			return false;
		}else{
			//Genero los td de:
			//Nombre e id (oculto, usando array)
			var span1 = $('<span>').text(curr_act[0].selectedOptions[0].innerHTML);
			var input1 = $('<input>').attr('name', 'pay_method_id['+curr_act.val()+']')
				.attr('value', curr_act.val()).attr('type', 'hidden');
			var td1 = $('<td>').append($(span1)).append($(input1));
			//Operacion de eliminar la fila, esta debe tener una confirmacion
			//	tipo globo tooltip con boton aceptar y cancelar.
			var button2 = "<button id='delete_pay_method_"+x+"' type='button'"+
			 "data-id='"+curr_act.val()+"' data-text='"+curr_act[0].selectedOptions[0].innerHTML
			 +"' class='business-delete btn btn-danger'><i class='fa fa-trash'></i></button>";
			 var td2 = $('<td>').html(button2);
			 //Genero el tr
	 		var tr1 = $('<tr>').attr('id', 'tr_pay_method_'+curr_act.val()).append($(td1)).append($(td2));
			//lo appendeo en la tabla
			$('#data-pay_methods').append( $(tr1) );
			//se elimina con remove del DOM y vuelve a agregarlo al select
			$('#delete_pay_method_'+x).on('click', deletePayMethod);
		}

		//blanqueo el activity_id
		$("#pay_method_id option[value='"+curr_act.val()+"']").remove();
		curr_act[0].selectedIndex=0;
		$('#pay_method_quantity').val(x);
		$(curr_act).tooltipster('hide');
	});
	$('[id^="delete_pay_method_"]').each(function(){
		$(this).on('click', deletePayMethod);
	});

	$('#store-business input[name], #store-business select, '+
		'#store-business input[type="checkbox"], #store-business input[type="radio"]').tooltipster(
		window.objectValidator );

	//configure the validation
	$('#general-button-save').off();

	$('#general-button-save').on('click', function(ev){
		ev.preventDefault();
		//console.log('clic en el boton');
		$('#store-business').submit();
	});
	//when modal was hide, hide the toolstipsters
	$('#generalModal').on('hide.bs.modal', function (e) {
		//console.log('cerrando modal');
		$("[class='tooltipster-box']").remove();

	});
  //for receipt
  window.validator = $('#store-business').validate({
    validClass: "valid-element",
    errorElement: "div",
    errorClass: "invalid-element",
	  debug: true,
    errorPlacement:  function (error, element) {
			var lastError = $(element).data('lastError'),
					newError = $(error).text();
			//para elementos de cantidad como zonas, actividades...
			if (element.attr("name").search("_quantity")>0 ) {
				var res = element.attr("name").substr(0, element.attr("name").search("_quantity"));
				element = $('#'+res+'_id');
			}
			$(element).data('lastError', newError);
			$(element).tooltipster('content', newError);
			//solo muestro los errores para los elementos del primer TAB
			//console.log(element.parents('.tab-pane')[0].id);
			//console.log( $('#'+Object.keys(window.validator.errorMap)[0]).parents('.tab-pane')[0].id);
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

			if ($(element).attr("name").search("_quantity")>0 ) {
				var res = $(element).attr("name").substr(0, $(element).attr("name").search("_quantity"));
				element = $('#'+res+'_id');
			}
      $(element).tooltipster('hide');
    },
    ignore : [ ":hidden[name!='no-use']" ],
		rules: {
			"document_type" : {	required: true, },
  		"document" : {	required: true, },
			"field_name1" : { required: true, },
			"active" : { required:true, },
			/*{ required: '#period_query', date: true,
        maxDatePeriod : [ 'yy-mm-dd', '#period_query' ]   },*/
      "person_type_id" : { required: true, },
      "iva_condition_id" : { required : true, },
      "month_close" : { required:true, },
			//"activity_quantity" : { required: true, min : 1 },
			//"zone_quantity" : { required: true, min : 1 },
			"obligation_iibb" : { required : true, },
			//"obligation_other_taxes" : { required : true, },
			// "settle_calc_by_coef" : { required : true, },
			"liquidation_start_period" : { required : true, },
			//"liquidator_quantity" : { required: true, min : 1 },
			/*"pay_method_quantity" : { required: true, min : 1 },*/
		},
		messages: {
			"document_type" : "Seleccione",
      "document" : "Ingrese el documento",
      "field_name1" : "Ingrese el nombre",
			"active" : "Seleccione si esta activo o no",
      "person_type_id" : "Seleccione",
      "iva_condition_id" : "Seleccione",
      "month_close" : "Seleccione",
			//"activity_quantity" : "Agregue al menos una Actividad",
			//"zone_quantity" : "Agregue al menos una Zona",
			"obligation_iibb" : "Seleccione",
			//"obligation_other_taxes" : "Seleccione",
			//"settle_calc_by_coef" : "Seleccione",
			"liquidation_start_period" : "Ingrese el periodo de inicio",
			///"liquidator_quantity" : "Agregue al menos un Liquidador",
			/*"pay_method_quantity" : "Agregue al menos un Liquidador",*/
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

        if(document.getElementById('receipt_id')){
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

					 if(e_quantity.length>0){
             var divln = $('<div>')
     .attr('class', 'alert alert-danger alert-dismissable animate-alert-top fade in');
             var buttonln = $('<button>').attr('type', 'button')
               .attr('class', 'close').attr('data-dismiss', 'alert')
               .attr('aria-hidden', 'true');
             var iln = $("<i>").attr("class", "fa fa-close")
               .attr("aria-hidden", "true").attr("title", 'Cerrar')
               .attr("id", "alertMessaje");
            var texto = 'Faltan Elemenos de Actividades, Zonas o Liquidadores por seleccionar.';
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


/* no funciona pero igual no importa
		$('[name^="sifere_coef["], [name^="iibb_aliquot["]')
			.each(function() {
			$(this).rules('add', { required: true, messages: { required :"Valor invalido" } });
			$(this).on('blur', function(e){
				if($(this).val()=='' || parseFloat($(this).val().replace(',', '.'))<=0.0001){
					$(this).val('');
				}
			});
		});
*/

/*
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
     $.parseJSON($('#period_liquidation_close').val()) : null;
    //console.log(period_liquidation_close);
    if(period_liquidation_close!=null){
      //console.log(period_liquidation_close);
      $('input').prop('readonly', true).prop('disabled', true).off();
      $('select').prop('disabled', true);
      $("#general-button-save").hide().prop("disabled", true);
    }

*/
});
