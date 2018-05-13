$( document ).ready(function() {

  $("#general-button-delete").prop("disabled", false);

  $('#store-receipt input[name],input[type="text"],select,input[type="checkbox"],input[type=email]')
    .prop('disabled', true)
    .prop('readonly', true);

  $('#dangerModal').on('hide.bs.modal', function (e) {
    //console.log('cerrando modal');
    $("[class='tooltipster-box']").remove();

  });

  //for receipt
  $( "#general-button-delete" ).on('click', function(e){

      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();

      var route1 = $("#delete-route").val().trim();
      var receipt_id = $('#receipt_id').val();
      //console.log('route1->'+route1+',receipt_id->'+receipt_id);


      $.ajax({
        type : 'POST',
        url : route1.replace('&id', receipt_id) ,
        beforeSend: function (xhr, opts) {
          //console.log($.active);
          if($.active>1){
            xhr.abort();
            return false;
          }
          $("#general-button-delete").prop("disabled", true);
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      })
      .done(function(response){ // What to do if we succeed
        console.log(response);
        $("#general-button-delete").prop("disabled", false);
        //console.log(response.personalFile);
        console.log('eliminando...');
        window.callback_module(window.module.type_id);

        var divln = $('<div>')
.attr('class', 'alert alert-success alert-dismissable animate-alert-top fade in');
        var buttonln = $('<button>').attr('type', 'button')
          .attr('class', 'close').attr('data-dismiss', 'alert')
          .attr('aria-hidden', 'true');
        var iln = $("<i>").attr("class", "fa fa-close")
          .attr("aria-hidden", "true").attr("title", 'Cerrar')
          .attr("id", 'alertMessaje');
        var spanln = $("<span>").text('Eliminado Exitosamente');

        $(buttonln).append( $(iln) );
        $(divln).append( $(buttonln) );
        $(divln).append( $(spanln) );
        $('#alertsFlag').empty();
        $('#alertsFlag').append( $(divln) );

          $('#dangerModal').scrollTop($("#alertsFlag").offset().top);
          $('.panel.panel-default').html('');
          $("#general-button-delete").prop("disabled", true);
          $('#modal-add-place').html('');
          setTimeout( function(){
            $('#dangerModal').modal('toggle');
          }, 2000);

      })
      .fail(function(jqXHR, textStatus, errorThrown) { // What to do if we fail
        //console.log(jqXHR.responseText);
        var errores = JSON.parse(jqXHR.responseText);
        $("#btn-unlock-settle").prop('disabled', false);
        console.log(errores);
        //capturo el error de las validaciones de Laravel
        if(jqXHR.status==422){
          var errores = JSON.parse(jqXHR.responseText);
           //console.log(errores.errors);
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
            $('#dangerModal').scrollTop($("#alertsFlagIIBB").offset().top);
            $('#alertsFlagIIBB').focus();
          }

          //console.log(errores.errors[0]);
          $('#'+Object.keys( errores.errors )[0]).focus()
          $("#general-button-delete").prop("disabled", false);
        }else if(jqXHR.status==412){
          //proceso los errores customizados para mostrar en las Flags
          //console.log('no puedo eliminar');
           var divln = $('<div>')
      .attr('class', 'alert alert-danger alert-dismissable animate-alert-top fade in');
           var buttonln = $('<button>').attr('type', 'button')
             .attr('class', 'close').attr('data-dismiss', 'alert')
             .attr('aria-hidden', 'true');
           var iln = $("<i>").attr("class", "fa fa-close")
             .attr("aria-hidden", "true").attr("title", 'Cerrar')
             .attr("id", "alertMessaje");
             //console.log(errores)
            var texto = '<ul>';
            $.each( errores.errors, function( key, value ) {
              texto += '<li>'+value+'</li>';
            });
            texto += '</ul>';
            //console.log(texto);
           var spanln = $("<span>").html(texto);

           $(buttonln).append( $(iln) );
           $(divln).append( $(buttonln) );
           $(divln).append( $(spanln) );
           $('#dangerModal #alertsFlag').empty();
           $('#dangerModal #alertsFlag').append( $(divln) );
           $('#dangerModal').scrollTop(0);
           $('#dangerModal #alertsFlag').show();
           $("#general-button-delete").prop("disabled", false);

        }else{
         //otros errores;
         //console.log(JSON.stringify(jqXHR));
         console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
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
    $("#general-button-delete").hide().prop("disabled", true);
  }



});
