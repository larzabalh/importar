$( document ).ready(function() {

  window.data = JSON.parse($('#base_values').val());

  $('#status').prop('readonly', true);

  $("#div-lock-settle").hide();
  $("#btn-prev-lock-settle").show();

  $("#btn-prev-lock-settle").prop("disabled", false);
  $("#btn-lock-settle").prop("disabled", false);
  $("#btn-recalculate").prop("disabled", false);
  $("#general-button-save").prop("disabled", false);

  $("#btn-unlock-settle").prop("disabled", false);

  $('#general-button-save').off();
  $('#btn-prev-lock-settle').off();
  $('#btn-lock-settle').off();
  $('#btn-recalculate').off();
  $('#btn-rollback').off();

  $("#btn-unlock-settle").off();

  var lock_function = function () {
    $("#btn-lock-settle").prop("disabled", false);
    $("#btn-lock-settle").removeClass("disabled");

    if($("#previous_period_liquidation_id").val()>0){
      if($("#previous_period_liquidation_status").val()!=2){

        $("#btn-lock-settle").prop("disabled", true);
        $("#btn-lock-settle").addClass("disabled");
        var divln = $('<div>')
      .attr('class', 'alert alert-danger alert-dismissable animate-alert-top fade in');
        var buttonln = $('<button>').attr('type', 'button')
          .attr('class', 'close').attr('data-dismiss', 'alert')
          .attr('aria-hidden', 'true');
        /*var iln = $("<i>").attr("class", "fa fa-close")
          .attr("aria-hidden", "true").attr("title", 'Cerrar')
          .attr("id", 'alertMessaje');*/
        var spanln = $("<span>").text('No se puede este periodo cerrar debido '+
        ' anterior no está cerrado');

      //  $(buttonln).append( $(iln) );
        $(divln).append( $(buttonln) );
        $(divln).append( $(spanln) );
        $('#warningsFlag').empty();
        $('#warningsFlag').append( $(divln) );
        $("#div-lock-settle").hide();

      }else{
        $(".mass-able").prop('readonly', true);
      }
    }
    $(".mass-able").prop('readonly', true);
    //console.log($('#store-settle #status').val());
    if( $('#store-settle #status').val()==='1'){
      $(".mass-able").prop('readonly', false);
      //habilido los campos inputs para sus ediciones
      $(".mass-able").mask('99999999,99',
      { reverse : true, placeholder: "$ 0,00",
       'translation': {9: {pattern: /[0-9]/} } } )
       .attr({ maxLength : 12 })
       .on('keyup', function(e){
         var name_i = $(this)[0].id.split("_");
         var id_i = parseInt(name_i[name_i.length-1]);
         var c_input = $(this)[0].id.substring(0, $(this)[0].id.length - ($(id_i).length+1));
         var tax_amount = positive_amount = negative_amount = result = base_amount=0;
         var previous_period_balance  = base_amount = 0;

         var coef = parseFloat($('#coef_'+id_i).val().replace(',', '.'));
         var aliquot = parseFloat($('#aliquot_'+id_i).val().replace(',', '.'));
         var sircreb = parseFloat($('#sircreb_amount_'+id_i).val().replace(',', '.'));
         var perception = parseFloat($('#perception_amount_'+id_i).val().replace(',', '.'));
         var retention = parseFloat($('#retention_amount_'+id_i).val().replace(',', '.'));

       switch (c_input) {
         case 'base_amount':
          base_amount = parseFloat($(this).val().replace(',', '.'));
          previous_period_balance = parseFloat($('#previous_period_balance_'+id_i).val().replace(',', '.'));
           break;
         case 'previous_period_balance':
          previous_period_balance = parseFloat($(this).val().replace(',', '.'));
          base_amount = parseFloat($('#base_amount_'+id_i).val().replace(',', '.'));
           break;
         case 'negative_amount':
          negative_amount = parseFloat($(this).val().replace(',', '.'));
          base_amount = parseFloat($('#base_amount_'+id_i).val().replace(',', '.'));
          previous_period_balance = parseFloat($('#previous_period_balance_'+id_i).val().replace(',', '.'));
           break;
         case 'positive_amount':
          positive_amount = parseFloat($(this).val().replace(',', '.'));
          base_amount = parseFloat($('#base_amount_'+id_i).val().replace(',', '.'));
          previous_period_balance = parseFloat($('#previous_period_balance_'+id_i).val().replace(',', '.'));
           break;
         case 'tax_amount':
          previous_period_balance = parseFloat($('#previous_period_balance_'+id_i).val().replace(',', '.'));
           break;
         default:
          consolelog('campo no permitido->'+c_input);
          return false;
          break;
       }
         base_amount = base_amount>0 ?base_amount : 0;
         previous_period_balance = previous_period_balance>0 ?previous_period_balance : 0;
         positive_amount = positive_amount>0 ?positive_amount : 0;
         negative_amount = negative_amount>0 ?negative_amount : 0;

      if(c_input=='tax_amount'){
        tax_amount = parseFloat($(this).val().replace(',', '.'));
      }else{
        tax_amount = (base_amount*coef*aliquot/100).toFixed(2);
      }
      //console.log(tax_amount)

         result = (tax_amount - previous_period_balance - sircreb - retention -
            perception).toFixed(2);
          negative_amount = result>0 ? result : 0;
          positive_amount = result<0 ? result*(-1) : 0;

          switch (c_input) {
            case 'base_amount':
        $('#previous_period_balance_'+id_i).val(previous_period_balance.toString().replace('.', ','));
        $('#negative_amount_'+id_i).val(negative_amount.toString().replace('.', ','));
        $('#positive_amount_'+id_i).val(positive_amount.toString().replace('.', ','));
            break;
            case 'previous_period_balance':
        $('#base_amount_'+id_i).val(base_amount.toString().replace('.', ','));
        $('#negative_amount_'+id_i).val(negative_amount.toString().replace('.', ','));
        $('#positive_amount_'+id_i).val(positive_amount.toString().replace('.', ','));
            break;
            case 'negative_amount':
        $('#base_amount_'+id_i).val(base_amount.toString().replace('.', ','));
        $('#previous_period_balance_'+id_i).val(previous_period_balance.toString().replace('.', ','));
        $('#positive_amount_'+id_i).val(positive_amount.toString().replace('.', ','));
            break;
            case 'positive_amount':
        $('#base_amount_'+id_i).val(base_amount.toString().replace('.', ','));
        $('#previous_period_balance_'+id_i).val(previous_period_balance.toString().replace('.', ','));
        $('#negative_amount_'+id_i).val(negative_amount.toString().replace('.', ','));
            break;
            case 'tax_amount':
        $('#previous_period_balance_'+id_i).val(previous_period_balance.toString().replace('.', ','));
        $('#negative_amount_'+id_i).val(negative_amount.toString().replace('.', ','));
        $('#positive_amount_'+id_i).val(positive_amount.toString().replace('.', ','));
            break;
            default:
              consolelog('campo no permitido->'+c_input);
              return false;
            break;
          }

          if(c_input!='tax_amount'){
            $('#tax_amount_'+id_i).val(tax_amount.toString().replace('.', ','));
          }

       });
    }else if($('#store-settle #status').val()==='2'){

    }
  };

  lock_function();

  $("#btn-recalculate").on("click", function(){
    //console.log(this);
    //ajax primero y luego...
    //console.log(window.data);
    window.original = [];
    $.each(window.data, function(key, value){
      //console.log($('#zone_id_'+key).val());
      if(!$('#zone_id_'+key).val()){
        return true;
      }

      var id_i =parseFloat($('#zone_id_'+key).val());

      var coef = parseFloat($('#coef_'+id_i).val().replace(',', '.'));
      var aliquot = parseFloat($('#aliquot_'+id_i).val().replace(',', '.'));

//original values
window.original[id_i] = {};
window.original[id_i].base_amount = $('#base_amount_'+id_i).val();
window.original[id_i].tax_amount = $('#tax_amount_'+id_i).val();
window.original[id_i].previous_period_balance =  $('#previous_period_balance_'+id_i).val();
window.original[id_i].sircreb = $('#sircreb_amount_'+id_i).val();
window.original[id_i].perception = $('#perception_amount_'+id_i).val();
window.original[id_i].retention = $('#retention_amount_'+id_i).val();
window.original[id_i].negative_amount = $('#negative_amount_'+id_i).val();
window.original[id_i].positive_amount = $('#positive_amount_'+id_i).val();

//console.log(value);
//new values
      var previous_period_balance = (value.previous_period_balance)? value.previous_period_balance : 0;
      var base_amount = (value.base_amount);
      var sircreb = (value.sircreb_amount);
      var perception = (value.perception_amount);
      var retention = (value.retention_amount);
      var tax_amount = (base_amount*coef*(aliquot/100)).toFixed(2);
      var result = (tax_amount - previous_period_balance - sircreb - retention -
         perception).toFixed(2);
      var negative_amount = result>0 ? result : 0;
      var positive_amount = result<0 ? result*(-1) : 0;

      $('#base_amount_'+id_i).val(base_amount.toString().replace('.', ','));
      $('#tax_amount_'+id_i).val(tax_amount.toString().replace('.', ','));
      $('#previous_period_balance_'+id_i).val(previous_period_balance.toString().replace('.', ','));
      $('#sircreb_amount_'+id_i).val(sircreb.toString().replace('.', ','));
      $('#perception_amount_'+id_i).val(perception.toString().replace('.', ','));
      $('#retention_amount_'+id_i).val(retention.toString().replace('.', ','));
      $('#negative_amount_'+id_i).val(negative_amount.toString().replace('.', ','));
      $('#positive_amount_'+id_i).val(positive_amount.toString().replace('.', ','));

    });
    $('#generalModal #warningsFlag').html('<div class="alert alert-warning">'+
    '<h4>Se ha realizado el recalculo de esta liquidacion</h4>'+
    '<button id="btn-rollback" class="btn btn-warning"><span class="fa fa-mail-reply">'+
    '</span>Devolver Cambios</button></div>');

    $('#btn-rollback').on('click', function(e){
      e.preventDefault;
      //console.log(window.original);

      $.each(window.original, function(key, value){
        if(!key){
          return true;
        }
        //console.log(value);
        $('#base_amount_'+key).val(value.base_amount);
        $('#tax_amount_'+key).val(value.tax_amount);
        $('#previous_period_balance_'+key).val(value.previous_period_balance);
        $('#sircreb_amount_'+key).val(value.sircreb);
        $('#perception_amount_'+key).val(value.perception);
        $('#retention_amount_'+key).val(value.retention);
        $('#negative_amount_'+key).val(value.negative_amount);
        $('#positive_amount_'+key).val(value.positive_amount);
      });
      $('#generalModal #warningsFlag').html('<div class="alert alert-info '+
       'alert-dismissable animate-alert-top fade in flexb">'+
      '<h4>Cambios devueltos con exito</h4><button type="button" '+
      ' class="close" data-dismiss="modal" aria-label="Close"><span '+
      ' aria-hidden="true" class="fa fa-window-close"></span></button></div>');

    });
  });

  $("#btn-unlock-settle").on("click", function(e){

    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();

    var route1 = $("#open-settle-route").val().trim();
    //console.log(route1);
    //console.log($("#delete-settle")[0].serialize());

    //otra vez hacer la validacion del lado del servidor status==2
    //  Recargo ambos listados
    //  Cierro modal

    $.ajax({
      type : 'PATCH',
      url : route1 ,
      data : {
        'period_liquidation_id':$('#period_liquidation_id').val()
       },
      beforeSend: function (xhr, opts) {
        //console.log($.active);
        if($.active>1){
          xhr.abort();
          return false;
        }
        $("#btn-unlock-settle").prop("disabled", true);
        $('#generalModal #alertsFlag').empty();
        $('#generalModal #warningsFlag').empty();
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    })
    .done(function(response){ // What to do if we succeed
      //console.log(response);

      //console.log(response.personalFile);
      //console.log('eliminando...');

      $('#modal-report-body').html('');

      window.callback_module(1, '#principal-data');
      window.callback_module(2, '#closed-data');

      var divln = $('<div>')
    .attr('class', 'alert alert-success alert-dismissable animate-alert-top fade in');
      var buttonln = $('<button>').attr('type', 'button')
        .attr('class', 'close').attr('data-dismiss', 'alert')
        .attr('aria-hidden', 'true');
      var iln = $("<i>").attr("class", "fa fa-close")
        .attr("aria-hidden", "true").attr("title", 'Cerrar')
        .attr("id", 'alertMessaje');
      var spanln = $("<span>").text('Abierto Exitosamente');

      $(buttonln).append( $(iln) );
      $(divln).append( $(buttonln) );
      $(divln).append( $(spanln) );
      $('#generalModal #alertsFlag').empty();
      $('#generalModal #warningsFlag').empty();
      $('#generalModal #warningsFlag').append( $(divln) );

      $('#generalModal').scrollTop($("#generalModal #warningsFlag").offset().top);
      $("#btn-unlock-settle").prop("disabled", true);

      setTimeout( function(){
        $('#generalModal').modal('toggle');
      }, 2000);

    })
    .fail(function(jqXHR, textStatus, errorThrown) { // What to do if we fail
      var errores = JSON.parse(jqXHR.responseText);
      $("#btn-unlock-settle").prop('disabled', false);
      console.log(errores);
      if(jqXHR.status==412){
        //proceso los errores customizados para mostrar en las Flags
         var divln = $('<div>')
    .attr('class', 'alert alert-danger alert-dismissable animate-alert-top fade in');
         var buttonln = $('<button>').attr('type', 'button')
           .attr('class', 'close').attr('data-dismiss', 'alert')
           .attr('aria-hidden', 'true');
         var iln = $("<i>").attr("class", "fa fa-close")
           .attr("aria-hidden", "true").attr("title", 'Cerrar')
           .attr("id", "alertMessaje");

          var texto = '<ul>';
          $.each( errores.errors, function( key, value ) {
            texto += '<li>'+value+'</li>';
          });
          texto += '</ul>';

         var spanln = $("<span>").html(texto);

         $(buttonln).append( $(iln) );
         $(divln).append( $(buttonln) );
         $(divln).append( $(spanln) );
         $('#generalModal #alertsFlag').empty();
         $('#generalModal #alertsFlag').append( $(divln) );
         $('#generalModal').scrollTop($("#generalModal #alertsFlag").offset().top);
         $('#generalModal #alertsFlag').focus();

      }else{
       //otros errores;
       //console.log(JSON.stringify(jqXHR));
       console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
     }
    });
  });

  $("#btn-prev-lock-settle").on("click", function(e){
    e.preventDefault();
    $("#div-lock-settle").show();
  });

  $("#btn-cancel-lock").on("click", function(e){
    e.preventDefault();
    $("#div-lock-settle").hide();
  });

  $("#btn-lock-settle").on("click", function(e){
    e.preventDefault();
    //alert('Primero hacer validaciones y luego cerrar!!!');
    $("#btn-lock-settle").prop("disabled", true);
    $("#btn-recalculate").prop("disabled", true);
    $("#general-button-save").prop("disabled", true);

    var data_id = $('#period_liquidation_id').val();
    var route1 = $('#find-settle-route').val().trim().replace('&id', data_id );
    window.errores = false;  window.eMessaje ='';
    //ajax falla, usar el status del campo o hacerlo desde el controller
    //

    /*$.ajax({
      type : 'GET',
      url : route1,
      beforeSend: function () {
        //$(".se-pre-con").fadeIn("fast");
      }
    })
    .done(function(response){
      console.log(response);
      console.log(response[0]);
      if(!response[0] ){
        window.eMessaje = 'Error: El Periodo no existe.';
        window.errores = true;
      }else if( response[0].status!=1){
        window.eMessaje = 'Error: El Periodo no tiene como estatus Abierto.';
        window.errores = true;
      }

    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      if(jqXHR.status==422){
        var errores = JSON.parse(jqXHR.responseText);
      }else{
       console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
     }
     window.errores = true;
   });
   if(window.errores===true){*/
   if($('#status').val()!=1){
     window.eMessaje = 'Error: El Periodo no tiene como estatus Abierto.'+
     'Por favor <a href="'+$('#index-settle-route').val()+'">REFRESCA</a> la pantalla.';
     var divln = $('<div>')
   .attr('class', 'alert alert-warning alert-dismissable animate-alert-top fade in');
     var buttonln = $('<button>').attr('type', 'button')
       .attr('class', 'close').attr('data-dismiss', 'alert')
       .attr('aria-hidden', 'true');
     var iln = $("<i>").attr("class", "fa fa-close")
       .attr("aria-hidden", "true").attr("title", 'Cerrar')
       .attr("id", 'alertMessaje');
     var spanln = $("<span>").html(window.eMessaje);

     $(buttonln).append( $(iln) );
     $(divln).append( $(buttonln) );
     $(divln).append( $(spanln) );
     $('#alertsFlag').empty();
     $('#alertsFlag').append( $(divln) );

     $('#generalModal').scrollTop($("#alertsFlag").offset().top);
   }else{
    $('#status').val('2');
    //console.log('aqui guardo');
    $('#store-settle').submit();
    $("#div-lock-settle").hide();
    $("#generalModal #warningsFlag").empty();
   }
    $("#btn-lock-settle").prop("disabled", false);
    $("#btn-recalculate").prop("disabled", false);
    $("#general-button-save").prop("disabled", false);

  });


 //make readonly
  $( ".reset-mass" ).prop('readonly', true);



/*
   $("input[class='reset-mass'").mask('99999999,99',
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
*/

  //  initialize tooltipster on text input elements
    $('#store-settle input[name],input[type="text"],select,input[type="checkbox"],input[type=email]').tooltipster(
    window.objectValidator);
  //configure the validation

  $('#general-button-save').on('click', function(){
    //console.log('clic en el boton');
    $('#store-settle').submit();
  });

  $('#generalModal').on('hide.bs.modal', function (e) {
    //console.log('cerrando modal');
    $("[class='tooltipster-box']").remove();

  });

  //for settle
  $( "#store-settle" ).validate({
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
    ignore : [ ":hidden[name!='no-use']", "[disabled]" ],
		rules: {
			"period_id" : {	required: true, }
		},
		messages: {
			"period_id" : "Seleccione el periodo",
    },

    submitHandler: function(form, e){
      var validator = this;
      //console.log('registrando...');
      //console.log(form);
      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();
      //console.log('deteniendo');
      //return false;
      $.ajax({
        type : 'POST',
        url : form.action ,
        beforeSend: function (xhr, opts) {
          //console.log($.active);
          if($.active>1){
            xhr.abort();
            return false;
          }
          $("#btn-lock-settle").prop("disabled", true);
          $("#btn-recalculate").prop("disabled", true);
          $("#general-button-save").prop("disabled", true);
        },
        data : $(form).serialize(),
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      })
      .done(function(response){ // What to do if we succeed
        //console.log(response);
        $("#btn-lock-settle").prop("disabled", false);
        $("#btn-recalculate").prop("disabled", false);
        $("#general-button-save").prop("disabled", false);
        //console.log(response.personalFile);
        //console.log($('#idPersonalFile').val());
        //console.log('registrado...');
        window.callback_module(1, '#principal-data');
        window.callback_module(2, '#closed-data');

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

        $('#generalModal').scrollTop($("#alertsFlag").offset().top);
        $('#modal-report-body').html('');
        $("#btn-lock-settle").prop("disabled", true);
        $("#btn-recalculate").prop("disabled", true);
        $("#general-button-save").prop("disabled", true);
        $('#modal-add-place').html('');
        setTimeout( function(){
          $('#generalModal').modal('toggle');
        }, 1000);



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
            /*
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
            */
          }

          //console.log(errores.errors[0]);
          $('#'+Object.keys( errores.errors )[0]).focus()
          $("#btn-lock-settle").prop("disabled", false);
          $("#btn-recalculate").prop("disabled", false);
          $("#general-button-save").prop("disabled", false);
        }else{
         //otros errores;
         //console.log(JSON.stringify(jqXHR));
         console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
       }
      });
    }

  });

  $('.mass-able').each(function() {
        $(this).rules('add', {
            required: true,
            messages: {
                required: "Debe de estar lleno"
            }
        });
    });


});
