$( document ).ready(function() {

if(!window.dataTable){
  window.dataTable = [];
}
  $('#tax-run #period_query').on( 'keyup', function(e) {
    $('#tax-run #period_id').val('');
    //console.log(e.key);
    //console.log(this.value);
    var phrase = this.value;
    $.ajax({
      type : 'GET',
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
       $("#tax-run #period_query ~ ul").empty();

       $.each(response.data, function(){
         elemento = $('<li/>', { 'class' :'btn btn-default list-items' });
         elemento.text(this.code);
         elemento.attr('data-id', this.id);
         elemento.attr('data-name', this.code);
         elemento.on('click', function(e) {
           //console.log(this);
          $('#tax-run #period_id').val(this.getAttribute('data-id'));
          $('#tax-run #period_query').val(this.getAttribute('data-name'));
          $("#tax-run #period_query ~ ul").empty();
        });
        $("#tax-run #period_query ~ ul").append(elemento);
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
  $('#tax-run #period_query ~ ul').on( 'mouseleave', function(e) {
   setTimeout( function(){
     $("#tax-run #period_query ~ ul").empty(); $('#period_query').val('');
   }, 3000);
  });
  $('#tax-run #period_query').mask('9999-99').attr({ maxLength : 10 });

  //  initialize tooltipster on text input elements
    $('#tax-run input[name],input[type="text"],select,input[type="checkbox"],input[type=email]').tooltipster(
      window.objectValidator);

  //configure the validation
  $('#run-tax').off();
  $('#run-tax').on('click', function(){
    //console.log('clic en el boton');
    $('#tax-run').submit();
  });

  $('#generalModal').on('hide.bs.modal', function (e) {
    //console.log('cerrando modal');
    $("[class='tooltipster-box']").remove();

  });

  //for settle
  $( "#tax-run" ).validate({
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
          //console.log($(element));
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
      "apply_to" : { required: true, }
		},
		messages: {
			"period_code" : "Seleccione el periodo",
      "apply_to" : "Seleccione el Tipo"
    },

    submitHandler: function(form, e){
      var validator = this;
      //console.log('registrando...');
      //console.log(form);
      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();
      $.ajax({
        type : 'POST',
        url : form.action ,
        beforeSend: function (xhr, opts) {
          //console.log($.active);
          if($.active>1){
            xhr.abort();
            return false;
          }
          $("#run-tax").prop("disabled", true);
        },
        data : $(form).serialize(),
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      })
      .done(function(response, textStatus, jqXHR){ // What to do if we succeed
        console.log(response);
        //console.log('Abro el modal');
        if(jqXHR.status==200){
          $('#show-liq-'+response[0].id).click();
        }else if(jqXHR.status==201){
          //console.log('nuevo generado');
          //abro el modal a mano
          window.openModalSettle(response.respuesta.id
            , response.respuesta.period_code, 1, $('#tax-run #apply_to').val());

          window.callback_module(1, '#principal-data');
          window.callback_module(2, '#closed-data');
        }
        $("#run-tax").prop("disabled", false);
        $(form)[0].reset();

      })
      .fail(function(jqXHR, textStatus, errorThrown) { // What to do if we fail
        var errores = JSON.parse(jqXHR.responseText);
        console.log(errores);
        //capturo el error de las validaciones de Laravel
        if(jqXHR.status==422){
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

          }

          //console.log(errores.errors[0]);
          $('#'+Object.keys( errores.errors )[0]).focus()
          $("#run-tax").prop('disabled', false);
        }else if(jqXHR.status==412){
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
           $('#tax-run-tabs0 #alertsFlag').empty();
           $('#tax-run-tabs0 #alertsFlag').append( $(divln) );
           $('#tax-run-tabs0').scrollTop($("#tax-run-tabs0 #alertsFlag").offset().top);
           $('#tax-run-tabs0 #alertsFlag').focus();

          $("#run-tax").prop('disabled', false);
        }else{
         //otros errores;
         //console.log(JSON.stringify(jqXHR));
         console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
       }
      });
    }

  });








  window.callback_module = function(status_show, table, route){

    if(!table){ table = '#principal-data'; }
    if(!route){
      route = $("#route-refresh-list").val().trim()
              .replace('&person_id', $('#current-person-id').val());
    }
    window.module = {};
    window.module.type_id = 1;

    if(window.dataTable[table]){
      $(table).empty();
    }
    var dataTable = $(table).DataTable( );

      dataTable = $(table).DataTable({
       //"dom": 'T<"clear">lfrtip',
         "dom": 'frtip',
        "search": {
          "search": ""
        },
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        ajax: { "url": route+'?status_show='+status_show,
          "data": { "type_id":1 } },
        aoColumns : window.columnsDef[1],

        select: {
            style: 'os',
            selector: 'td:not(:last-child)' // no row selection on last column
        },
          "bDestroy": true,
          "iDisplayLength": 10,//Paginación
          "order": [[ 1, "desc" ], [2, 'desc']]//Ordenar (columna,orden)
    });
    window.dataTable[table] = dataTable;
  }


  window.columnsDef = {
    buttons : function(data, type, full, meta){
      return ('<input type="hidden" name="type_id['+full.period_liquidation_id
       +']" value="'+full.period_liquidation_id+'">'
       +'<input type="hidden" name="id['+full.period_liquidation_id
       +']" value="'+full.period_liquidation_id+'">'+
       "<button id='show-liq-"+full.period_liquidation_id+"' type='button'"+
        "class='settle-show btn btn-primary' data-value='"+full.code+
        "' data-id='"+full.period_liquidation_id+"' data-status='"+full.status+
        "'"+"data-apply-to='"+full.apply_to+"'" +"><i class='fa fa-eye'></i></button>"+
        ( (full.status==1) ?
        "<button id='delete-liq-"+full.period_liquidation_id+"' type='button'"+
         "class='settle-delete btn btn-danger' data-code='"+full.code+
         "' data-id='"+full.period_liquidation_id+"' data-status='"+full.status+
         "' data-apply_to='"+full.apply_to+"'"+"><i class='fa fa-trash'></i></button>"
         : "")
       );
     },
       1 :
   [{ data: 'code',"targets": 0, 'title':'Periodo', visible:true },
  { data: 'year',"targets": 1, 'title':'Año', visible:true},
  { data: 'period_number',"targets": 2, 'title':'Mes', visible:true},
  { data: 'type',"targets": 3, 'title':'Tipo', visible:true},
  { data: 'updated_at',"targets": 4, 'title':'Ult. Mod.', visible:true},
  {
     'targets' : 5, 'title':'Ops', visible:true,
     'searchable' : true, 'orderable' : true, 'className' : 'dt-body-center',
     'data' : ['type_name', 'type_id'],
     'render': function(data, type, full, meta){
       return   window.columnsDef.buttons(data, type, full, meta)
     }
   },
    //{ "targets":5, "title":'', 'defaultContent':'',  visible:false},
    { "targets":6, "title":'', 'defaultContent':'',  visible:false},
    { "targets":7, "title":'', 'defaultContent':'',  visible:false},
    { "targets":8, "title":'', 'defaultContent':'',  visible:false},
    { "targets":9, "title":'', 'defaultContent':'',  visible:false}
    ]

  };



window.openModalSettle = function(data_id, period, status, apply_to){
  $('#generalModal .modal-content .modal-body').empty();
  var route1 = $('#show-route').val().trim();
  route1 = route1.replace('&id', data_id );
  var title1 = ''; var add_on1;

  if(status=='1'){
    add_on1 = '<button class="btn btn-danger" id="btn-prev-lock-settle">'+
      '<span class="fa fa-lock fa-fw"></span>Cerrar</a></button>';
    add_on1 += '<button class="btn btn-warning" id="btn-recalculate">'+
      '<span class="fa fa-refresh fa-fw"></span>Recalcular</a></button>';
      $("#general-button-save").show();
    }
  if(status=='2'){
    add_on1 = '<button class="btn btn-primary" id="btn-unlock-settle">'+
      '<span class="fa fa-unlock fa-fw"></span>Abrir</a></button>';
      $("#general-button-save").hide();
  }


  if(apply_to=='iibb'){
    title1 = 'Liquidación II.BB.';
  }else if(apply_to=='iva'){
    title1 = 'Liquidación IVA';

  }

  $.ajax({
    type : 'GET',
    url : route1,
    beforeSend: function () {
      $(".se-pre-con").fadeIn("fast");
    }
  })
  .done(function(response){
    var modal = $('#generalModal');

    $('#generalModal .modal-content .modal-body').html(response);
    $('#generalModal .modal-content .modal-title')
      .html(title1+' Periodo: '+period+' ('+
      $('#change-person span')[0].innerHTML + ')');
    $('#generalModal .modal-content .modal-footer #modal-add-place').html(add_on1);
    $(modal).modal('show', {backdrop: 'static'});
    $(".se-pre-con").fadeOut("fast");

    $.ajaxSetup({ cache: false });

    $.ajax({
      url: "/js/admin/settle/form_"+apply_to+".js",
      dataType: "script"
    });
  })
  .fail(function(jqXHR, textStatus, errorThrown) {
    if(jqXHR.status==422){
      var errores = JSON.parse(jqXHR.responseText);
    }else{
     console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
    }
  });

}


window.openModalDelete = function(data_id, data_apply_to, data_code){

  var route1 = $('#showDelete-route').val().trim().replace('&id', data_id );
  //console.log(data_id);
  //peticion ajax
  //hacer la validacion del lado del servidor status==1 **Listo
  //  retornar status de error que ya manejo
  //
  $.ajax({
    type : 'GET',
    url : route1,
    beforeSend: function (xhr, opts) {
      //console.log($.active);
      if($.active>1){
        xhr.abort();
        return false;
      }
      $(".se-pre-con").fadeIn("fast");
    },
    data : { 'delete':true },
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  })
  .done(function(response, textStatus, jqXHR){ // What to do if we succeed
    //console.log(response);
    if(jqXHR.status==200){
      var modal = $('#dangerModal');
      $('#dangerModal .modal-content .modal-body').empty();
      $('#dangerModal .modal-content .modal-body').html(response);

      $('#dangerModal .modal-content .modal-title')
        .html(' Realmente deseas Eliminar la Liquidacion '+
        data_apply_to.toUpperCase()+' '+data_code+
        ' de : '+$('#change-person span')[0].innerHTML + '');

      $(modal).modal('show', {backdrop: 'static'});
      $(".se-pre-con").fadeOut("fast");

      $.ajax({
        url: "/js/admin/settle/delete.js",
        dataType: "script"
      });

    }

  })
  .fail(function(jqXHR, textStatus, errorThrown) { // What to do if we fail
    var errores = JSON.parse(jqXHR.responseText);
    $(".se-pre-con").fadeOut("fast");
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
       $('#alertsPeriods').empty();
       $('#alertsPeriods').append( $(divln) );
       $('#tax-run-tabs0').scrollTop(10);
       $('#alertsPeriods').focus();

       window.callback_module(1, '#principal-data');
       window.callback_module(2, '#closed-data');

    }else{
     //otros errores;
     //console.log(JSON.stringify(jqXHR));
     console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
   }
  });
}


window.callback_module(1, '#principal-data');
window.callback_module(2, '#closed-data');

  window.dataTable['#principal-data'].on( 'draw', function (e) {
    //show element settle
    $(this).find('.settle-show').off();
    $(this).find('.settle-show').on('click', function(){
      window.openModalSettle(this.getAttribute('data-id')
      , this.getAttribute('data-value'), this.getAttribute('data-status')
      , this.getAttribute('data-apply-to'));
    });

    $(this).find('.settle-delete').off();
    $(this).find('.settle-delete').on('click', function(){

      window.openModalDelete(this.getAttribute('data-id')
      , this.getAttribute('data-apply_to'), this.getAttribute('data-code') );
    });

  });

  window.dataTable['#closed-data'].on( 'draw', function (e) {
    //show element settle
    $(this).find('.settle-show').on('click', function(){
      window.openModalSettle(this.getAttribute('data-id')
      , this.getAttribute('data-value'), this.getAttribute('data-status')
      , this.getAttribute('data-apply-to'));
    });

    $(this).find('.settle-delete').on('click', function(){
      /*window.openModalSettle(this.getAttribute('data-id')
      , this.getAttribute('data-value'), this.getAttribute('data-status'));*/
    });

  });





});
