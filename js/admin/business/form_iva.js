var showSubtotalsAmounts = function(){
  $.each($('.section-data'), function(key,  item){
  var item_inside = $(item).find( "table" );
  var spans = $(item).find( "h4.panel-title a span.amount" );
     $.each(item_inside, function(pos, table){
       var taxes = $(table).find("input[id^='item_taxabled_']:hidden");
       var ivas = $(table).find("input[id^='item_tax_'].form-control");
       var total = totalv = 0;
       $.each(taxes, function(i, v){
         totalv +=parseFloat(v.value);
         var subtotal = v.value*ivas[i].value/100;
         total+=subtotal;
       })

      spans[pos].innerHTML = '$ '+totalv;
     });
  });
}

$( document ).ready(function() {

  showSubtotalsAmounts();

  $('#status').prop('readonly', true);
  $("#div-lock-settle").hide();
  $("#btn-prev-lock-settle").show();
  //$("#btn-recalculate").hide();
  //$("#btn-lock-settle").hide();
  //$("#btn-prev-lock-settle").hide();

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

  $("#store-settle input.form-control").prop("readonly", true);

  $("#btn-unlock-settle").off();

  $("#btn-prev-lock-settle").on("click", function(e){
    e.preventDefault();
    $('#generalModal').scrollTop(0);
    $("#div-lock-settle").show();
  });

  $("#btn-cancel-lock").on("click", function(e){
    e.preventDefault();
    $('#generalModal').scrollTop(0);
    $("#div-lock-settle").hide();
  });

  $(".mass-able").mask('99999999,99',
  { reverse : true, placeholder: "$ 0,00",
   'translation': {9: {pattern: /[0-9\-]/} } } )
   .attr({ maxLength : 12 });

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
      //$(".mass-able").prop('readonly', false);

      //habilido los campos inputs para sus ediciones
     $("#positive_amount").on('keyup', function(e){
         var amount = parseFloat($(this).val().replace(',', '.'));
         if(amount>0){ $("#negative_amount").val('0,00') }
      });
      $("#negative_amount").on('keyup', function(e){
        var amount = parseFloat($(this).val().replace(',', '.'));
        if(amount>0){ $("#positive_amount").val('0,00') }
     });

      $(".edit-able").prop('readonly', false);

    }else if($('#store-settle #status').val()==='2'){

    }
  };

  lock_function();



    $("#btn-lock-settle").on("click", function(e){
      e.preventDefault();
      //alert('Primero hacer validaciones y luego cerrar!!!');
      $("#btn-lock-settle").prop("disabled", true);
      $("#btn-recalculate").prop("disabled", true);
      $("#general-button-save").prop("disabled", true);

      var data_id = $('#period_liquidation_id').val();
      var route1 = $('#find-settle-route').val().trim().replace('&id', data_id );
      window.errores = false;  window.eMessaje ='';

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

       $('#generalModal').scrollTop(0);
       $("#div-lock-settle").hide();
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

        $('#generalModal').scrollTop(0);
        $("#btn-unlock-settle").prop("disabled", true);
        $("#div-lock-settle").hide();

        setTimeout( function(){
          $('#generalModal').modal('toggle');
        }, 1000);

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
           $('#generalModal').scrollTop(0);
           $('#generalModal #alertsFlag').focus();

        }else{
         //otros errores;
         //console.log(JSON.stringify(jqXHR));
         console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
       }
      });
    });

    $("#btn-recalculate").on("click", function(){

      //hago la consulta via ajax y me traigo las 3 cosas juntas
      var route1 = $('#recalculate-settle-route').val().trim()
        .replace('&period_liquidation_id', $('#store-settle #period_liquidation_id').val())
        .replace('&person_id', $('#current-person-id').val());
        //console.log(route1)
        $.ajax({
          type : 'GET',
          url : route1,
          beforeSend: function () {
            //$(".se-pre-con").fadeIn("fast");
          }
        })
        .done(function(response){
          //console.log(response);
          window.data = response[0];
          window.liquidation = {};
          window.liquidation['recalculated'] = response[1];
          window.liquidation['previous'] = response[2] ? response[2]
           : {'positive_amount':0,'total_free_availability':0};

           //console.log(window.liquidation);
           //return false;
           window.original = [];
           var debit = credit = 0;
           $.each(window.data, function(key,  value){
             item_col1 = 0;
             var id_i =parseInt($('#item_'+value.ordr+'_'+value.activity_id+'_'+value.type+'_'+value.id).val());

           window.original[id_i] = {};
           window.original[id_i].item_col1 = $('#item_col1_'+id_i).val();
           window.original[id_i].item_taxabled = $('#item_taxabled_'+id_i).val();
           window.original[id_i].item_tax =  $('#item_tax_'+id_i).val();
           window.original[id_i].type = value.type;

             var tax_amount = parseFloat(value.taxabled_amount)*parseFloat(value.percent_iva)/100;
             tax_amount = parseFloat(tax_amount.toFixed(2));
             //re-calculo los valores de debito y credito
             if(value.type==1){ debit += tax_amount; }
             else if(value.type==2){ credit += tax_amount; }

             item_col1 = parseFloat(value.taxabled_amount);
             if(value.ordr==2){ item_col1 = tax_amount+parseFloat(value.taxabled_amount); }
             $('#item_col1_'+id_i).val(item_col1);
             $('#item_taxabled_'+id_i).val(parseFloat(value.taxabled_amount));
             $('#item_tax_'+id_i).val(parseFloat(tax_amount));
             //return false;
           });

           //ajusto los valores de los campos subtotales y totales
           //console.log('debit->'+debit);
           $('#total_debit').val(debit.toString().replace('.', ','));
           $('#total_credit').val(credit.toString().replace('.', ','));
            //console.log(window.liquidation);
           var liquidationIVARetPerComp = window.liquidation.recalculated;
           var prevPeriodLiquidationIVA = window.liquidation.previous;
           //console.log(prevPeriodLiquidationIVA.positive_amount);
           var previous_technical = parseFloat(prevPeriodLiquidationIVA.total_free_availability);
           var technical_balance = parseFloat((credit + previous_technical - debit).toFixed(2)); //saldo tecnico del periodo
           var previous_free_availability = parseFloat(prevPeriodLiquidationIVA.total_free_availability) ;

           var retention_amount = parseFloat(liquidationIVARetPerComp.retention_amount ? liquidationIVARetPerComp.retention_amount : 0);
           var perception_amount = parseFloat(liquidationIVARetPerComp.perception_amount ? liquidationIVARetPerComp.perception_amount  : 0);
           var compensation_amount = parseFloat(liquidationIVARetPerComp.compensation_amount ? liquidationIVARetPerComp.compensation_amount : 0);

           var total_perceptions_retentions = (retention_amount + perception_amount);

           var free_availability_balance =
           (total_perceptions_retentions + previous_free_availability - compensation_amount);

           var negative_amount = (technical_balance+free_availability_balance>0) ? 0 :
           (technical_balance+free_availability_balance)*(-1);

           var positive_amount =  ((technical_balance>0) ? technical_balance : 0);

           var total_free_availability = ((technical_balance+free_availability_balance>0)
           ? ((technical_balance>0) ? free_availability_balance
             : (technical_balance+free_availability_balance))
           : 0);
           window.original.data=[];
           window.original.data['negative_amount'] = $('#negative_amount').val();
           window.original.data['positive_amount'] = $('#positive_amount').val();
           window.original.data['total_free_availability'] = $('#total_free_availability').val();
           window.original.data['previous_technical'] = $('#previous_technical').val();
           window.original.data['previous_free_availability'] = $('#previous_free_availability').val();
           window.original.data['retention_amount'] = $('#retention_amount').val();
           window.original.data['perception_amount'] = $('#perception_amount').val();
           window.original.data['compensation_amount'] = $('#compensation_amount').val();


           $('#previous_technical').val(previous_technical.toString().replace('.', ','));
           $('#technical_balance').val(technical_balance.toString().replace('.', ','));
           $('#previous_free_availability').val(previous_free_availability.toString().replace('.', ','));
           $('#retention_amount').val(retention_amount.toString().replace('.', ','));
           $('#perception_amount').val(perception_amount.toString().replace('.', ','));
           $('#compensation_amount').val(compensation_amount.toString().replace('.', ','));
           $('#total_perceptions_retentions').val(total_perceptions_retentions.toString().replace('.', ','));
           $('#free_availability_balance').val(free_availability_balance.toString().replace('.', ','));
           $('#negative_amount').val(negative_amount.toString().replace('.', ','));
           $('#positive_amount').val(positive_amount.toString().replace('.', ','));
           $('#total_free_availability').val(total_free_availability.toString().replace('.', ','));

           $('#generalModal').scrollTop(0);
           $("#div-lock-settle").hide();

           $('#generalModal #warningsFlag').html('<div class="alert alert-warning">'+
           '<h4>Se ha realizado el recalculo de esta liquidacion</h4>'+
           '<button id="btn-rollback" class="btn btn-warning"><span class="fa fa-mail-reply">'+
           '</span>Devolver Cambios</button></div>');

           $('#btn-rollback').off();

           $('#btn-rollback').on('click', function(e){
             e.preventDefault;
             //console.log(window.original);
             var cont = debit = credit = 0;
             $.each(window.original, function(key){
               if(!window.original[key+1]){
                 return true;
               }
               value=window.original[key+1];
               tax_amount = parseFloat(value.item_tax);
               //re-calculo los valores de debito y credito
               if(value.type==1){ debit += tax_amount; }
               else if(value.type==2){ credit += tax_amount; }
               //console.log(value);
               $('#item_col1_'+cont).val(parseFloat(value.item_col1));
               $('#item_taxabled_'+cont).val(parseFloat(value.item_taxabled));
               $('#item_tax_'+cont).val(tax_amount);
             });

             $('#total_debit').val(debit.toFixed(2).toString().replace('.', ','));
             $('#total_credit').val(credit.toFixed(2).toString().replace('.', ','));

             var previous_technical = parseFloat((window.original.data.positive_amount));
             var technical_balance = parseFloat((credit + previous_technical - debit).toFixed(2)); //saldo tecnico del periodo
             var previous_free_availability = parseFloat(window.original.data.previous_free_availability);

             var retention_amount = parseFloat(window.original.data.retention_amount);
             var perception_amount = parseFloat(window.original.data.perception_amount);
             var compensation_amount = parseFloat(window.original.data.compensation_amount);

             var total_perceptions_retentions = (retention_amount + perception_amount);

             var free_availability_balance =
             (total_perceptions_retentions + previous_free_availability - compensation_amount);

             var negative_amount = ((technical_balance+free_availability_balance>0) ? 0 :
             (technical_balance+free_availability_balance)*(-1)).toFixed(2);

             var positive_amount =  ((technical_balance>0) ? technical_balance : 0).toFixed(2);

             var total_free_availability = ((technical_balance+free_availability_balance>0)
             ? ((technical_balance>0) ? free_availability_balance
               : (technical_balance+free_availability_balance))
             : 0).toFixed(2);
             //console.log('negative_amount*'+negative_amount);

             $('#previous_technical').val(previous_technical.toString().replace('.', ','));
             $('#technical_balance').val(technical_balance.toString().replace('.', ','));
             $('#previous_free_availability').val(previous_free_availability.toString().replace('.', ','));
             $('#retention_amount').val(retention_amount.toString().replace('.', ','));
             $('#perception_amount').val(perception_amount.toString().replace('.', ','));
             $('#compensation_amount').val(compensation_amount.toString().replace('.', ','));
             $('#total_perceptions_retentions').val(total_perceptions_retentions.toString().replace('.', ','));
             $('#free_availability_balance').val(free_availability_balance.toString().replace('.', ','));
             $('#negative_amount').val(negative_amount.toString().replace('.', ','));
             $('#positive_amount').val(positive_amount.toString().replace('.', ','));
             $('#total_free_availability').val(total_free_availability.toString().replace('.', ','));

             $('#generalModal #warningsFlag').html('<div class="alert alert-info '+
              'alert-dismissable animate-alert-top fade in flexb">'+
             '<h4>Cambios devueltos con exito</h4><button type="button" '+
             ' class="close" data-dismiss="modal" aria-label="Close"><span '+
             ' aria-hidden="true" class="fa fa-window-close"></span></button></div>');
            showSubtotalsAmounts();
           });

         })
         .fail(function(jqXHR, textStatus, errorThrown) {
           if(jqXHR.status==422){
             var errores = JSON.parse(jqXHR.responseText);
           }else{
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
           }
           return false;
         });

         showSubtotalsAmounts();
    });

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
 			"negative_amount" : {	required: true, },
 			"positive_amount" : {	required: true, },
 			"total_free_availability" : {	required: true, }
 		},
 		messages: {
      "negative_amount" : "Requerido",
 			"positive_amount" : "Requerido",
 			"total_free_availability" : "Requerido"
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
         console.log(response);
         //return false;
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

         $('#generalModal').scrollTop(0);
         $("#div-lock-settle").hide();
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
});
