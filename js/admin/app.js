/*function generarPassword(destino) {
 var strCaracteresPermitidos = 'a,b,c,d,e,f,g,h,i,j,k,m,n,p,q,r,';
 strCaracteresPermitidos += 's,t,u,v,w,x,y,z,1,2,3,4,5,6,7,8,9';
 var strArrayCaracteres = new Array(34);
 strArrayCaracteres = strCaracteresPermitidos.split(',');
 var length = form.txtCampoLongitud.value, i = 0, j, tmpstr = "";
 do {
  var randscript = -1
  while (randscript &lt; 1 || randscript &gt; strArrayCaracteres.length ||
           isNaN(randscript)) {
   randscript = parseInt(Math.random() * strArrayCaracteres.length)
  }
  j = randscript;
  tmpstr = tmpstr + strArrayCaracteres[j];
  i = i + 1;
 } while (i &gt; length)
 document.getElementById(destino).value = tmpstr;
}*/


//Configuracion de validaciones identicas en todos los formularios
window.objectValidator = {  theme: ['tooltipster-light', 'tooltipster-light-validate'],
    animation: 'fade',  delay: 300,  trigger: 'custom',  onlyOne: false,
    position: ['top', 'right', 'bottom', 'left'],  distance: -10, debug: false
  };


// Numeric only control handler
jQuery.fn.ForceNumericOnly =
function(){
    return this.each(function()    {
        $(this).keydown(function(e)        {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
            return (key == 8 ||  key == 9 ||  key == 13 ||  key == 46 ||
                key == 110 ||  key == 190 ||  (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
        });
    });
};

$.fn.sortSelect = function(){
    var mylist = $(this);
    var listitems = mylist.children('option').get();
    listitems.sort(function(a, b) {
       var compA = $(a).html().toUpperCase();
       var compB = $(b).html().toUpperCase();
       return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
    });
    $.each(listitems, function(idx, itm) { mylist.append(itm); });
  };

$(document).ready(function () {

  jQuery.validator.addMethod("maxDate1",
      function(value, element, params) {
        console.log(params);
          if (!params[0])
              throw ' params missing format ';
          if (typeof(params[1]) == 'undefined' )
              throw ' params missing maxDate ';
          var dateFormat = params[0];
          var maxDate = params[1];
          if (maxDate == 0) {
              maxDate = new Date();
              maxDate.setHours(0); // make it 00:00:0
              maxDate.setMinutes(0);
              maxDate.setSeconds(0);
              maxDate.setMilliseconds(0);
          }else{
            if(typeof(maxDate)=='string'){
              maxDate = $.datepicker.parseDate( dateFormat, maxDate )
            }
          }
          if (typeof(params[2]) == 'undefined' ){  params[2] = maxDate;  }
          try {
              var valueAsDate = $.datepicker.parseDate( dateFormat, value )
              return (valueAsDate.getTime() < maxDate.getTime());
          } catch (x) {
              return false;
          }
      },' must to be {2}.');

  jQuery.validator.addMethod("maxDatePeriod", function(value, element, params) {
        if (!params[0]){
            throw ' params missing format ';
        }else{ var dateFormat = params[0]; }
        if (typeof(params[1]) == 'undefined' ){
            throw ' params missing compare period field ';
        }else{
          var maxDate = new Date($(params[1]).val().substring(0,4),
          $(params[1]).val().substring(5,7), 0)
        }
        try {
            var valueAsDate = $.datepicker.parseDate( dateFormat, value )
            //console.log(valueAsDate.getTime(), maxDate.getTime())
            return (valueAsDate.getTime() <= maxDate.getTime());
        } catch (x) {
          console.log('error', x)
          return false;
        }
    },' must to be {2}.');

});

//ocultar la imagen loading inicial
$(window).load(function() {
		// Animate loader off screen
	$(".se-pre-con").fadeOut("slow");
});

$( document ).ready(function() {

  $.ajaxSetup({ cache: true });

  $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("active");
      //console.log('Ejecutando toggle');
  });

  //event for width and resize
  var eventFired = 0;
  if ($(window).width() <= 1024) {
      $("#wrapper").toggleClass("active");
  } else {
      //console.log('More than 1024');
      //$("#wrapper").toggleClass("active");
      eventFired = 1;
  }
  $(window).on('resize', function() {
      if (!eventFired) {
          if ($(window).width() <= 1024) {
              //console.log('Less than 1024 resize');
              //$("#wrapper").toggleClass("active");
          } else {
              //console.log('More than 1024 resize');
              $("#wrapper").toggleClass("active");
          }
      }
  });


//menu to change the current person

  $('#change-person').on('click', function(){
    var modal = $('#personModal');
    $(modal).modal('show', {backdrop: 'static'});
  });

  window.reloadPersons = function(){
    var modal = $('#personModal');
    var title1 = "<span>Cambio de Empresa</span>";
    title1 += '<input type="text" id="filter-person" class="form-control search-bar"'+
    ' placeholder="Filtar Empresa">';
    $('#personModal .modal-content .modal-header .modal-title').html(title1);
    $.ajax({
      type : 'GET',
      url : $('#route-company-sons').val(),
    })
    .done(function(response){ // What to do if we succeed
      //console.log(response);
      $('#personModal .modal-content .modal-body').empty();
      var elemento = {}; var html = ''; var temp = ''; var currentCompany ='';
      $.each(response.companies, function(){
        temp=this.id; currentCompany=this.field_name1;
        elemento = $('<div/>', { 'class' :'panel panel-info',
          'data-id' : temp, 'data-name' : currentCompany });
        elemento.on('click', function(e) {
          //console.log('llamada ajax para cambiar la empresa en la session y retornar el nuevo nombre de la empresa, el listado queda igual.');
          $.ajax({
            type : 'GET',
            url : $("#route-set-company").val().trim()
                    .replace('&id', this.getAttribute('data-id')),
            beforeSend: function () {
              $(".se-pre-con").fadeIn("fast");
              //console.log(this.url);
              //$("#send-button").prop("disabled", true);
            },
            data : {
             //"id" : $('#loginUser').val(),
             //"emailUser" : $('#emailUser').val()
           }
          })
          .done($.proxy(function(response){ // What to do if we succeed
            $('#change-person > span').text( this.getAttribute('data-name') );
            $('#current-person-id').val( this.getAttribute('data-id') );
            $('#personModal').modal('toggle');

            if(window.callback_module){
              window.callback_module();
            }

            $(".se-pre-con").fadeOut("fast");
            $('#alertsModal .modal-content .modal-body')
              .text('Empresa cambiada Exitosamente');
            $('#alertsModal').modal('toggle');
          }, this));
        });

          html = '<div class="panel-footer">';
          html += '<span class="pull-left">';
          html += '<i class="fa fa-building-o fa-fw"></i>';
          html += this.field_name1+'</span>';
          html += '<span class="pull-right">';
          html += '<i class="fa fa-arrow-circle-right"></i>';
          html += '</span>';
          html += '<div class="clearfix"></div></div>';

          $(elemento).html(html);

          $(elemento).appendTo($('#personModal .modal-content .modal-body') );

       });
       //tod un exxitoo, super sencillo filtro.
       $('#filter-person').on('keyup', function(ev){
         var valor = this.value;
         //console.log('debo filtar los elementos abajo, puedo usar el atributo dataset de jquery');
         $('#personModal .panel').each( function(){
          ($(this)[0].getAttribute('data-name').indexOf(valor) != -1 ) ? $(this).show() : $(this).hide();
         });
       });

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
  };

  window.reloadPersons();


  //
  $('#pruebaZ').on('click', function(){
    $(".se-pre-con").fadeIn("slow");
    setTimeout(function(){
      $(".se-pre-con").fadeOut("slow");
    }, 1000);
  });


});
