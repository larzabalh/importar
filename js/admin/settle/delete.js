$( document ).ready(function() {

  $("#general-button-delete").show();
  $("#general-button-delete").prop('disabled', false);

  $('#dangerModal').on('hide.bs.modal', function (e) {
    //console.log('cerrando modal');
    $("[class='tooltipster-box']").remove();

  });

  $( "#general-button-delete" ).off();
  $( "#general-button-delete" ).on('click', function(e){
      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();

      var route1 = $("#delete-settle")[0].action;
      console.log(route1);
      //console.log($("#delete-settle")[0].serialize());

      //Esta otra pantalla:
        //otra vez hacer la validacion del lado del servidor status==1
        //  Recargo ambos listados
        //  Cierro modal que abri

      $.ajax({
        type : 'DELETE',
        url : route1 ,
        data : $($("#delete-settle")[0]).serialize(),
        beforeSend: function (xhr, opts) {
          //console.log($.active);
          if($.active>1){
            xhr.abort();
            return false;
          }
          $("#general-button-delete").prop("disabled", true);
          $('#dangerModal #alertsFlag').empty();
          $('#dangerModal #warningsFlag').empty();
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      })
      .done(function(response){ // What to do if we succeed
        console.log(response);

        //console.log(response.personalFile);
        console.log('eliminando...');

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
        var spanln = $("<span>").text('Eliminado Exitosamente');

        $(buttonln).append( $(iln) );
        $(divln).append( $(buttonln) );
        $(divln).append( $(spanln) );
        $('#dangerModal #alertsFlag').empty();
        $('#dangerModal #warningsFlag').empty();
        $('#dangerModal #warningsFlag').append( $(divln) );

        $('#dangerModal').scrollTop($("#dangerModal #warningsFlag").offset().top);
        $("#general-button-delete").prop("disabled", true);

        setTimeout( function(){
          $('#dangerModal').modal('toggle');
        }, 2000);

      })
      .fail(function(jqXHR, textStatus, errorThrown) { // What to do if we fail
        var errores = JSON.parse(jqXHR.responseText);
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
           $('#dangerModal #alertsFlag').empty();
           $('#dangerModal #alertsFlag').append( $(divln) );
           $('#dangerModal').scrollTop($("#dangerModal #alertsFlag").offset().top);
           $('#dangerModal #alertsFlag').focus();

          $("#general-button-delete").prop('disabled', false);
        }else{
         //otros errores;
         //console.log(JSON.stringify(jqXHR));
         console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
       }
      });


  });


});
