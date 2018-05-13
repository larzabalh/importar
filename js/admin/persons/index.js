$( document ).ready(function() {

if(!window.dataTable){
  window.dataTable = [];
}

//retrieve list
  window.callback_module = function(status_show, table, route){

    if(!table){ table = '#principal-data'; }
    if(!route){
      route = $("#route-refresh-list").val().trim();
    }
    window.module = {};
    window.module.type_id = 1;

    if(window.dataTable[table]){
      $(table).empty();
    }
    var dataTable = $(table).DataTable( );
    //console.log(route);
      dataTable = $(table).DataTable({
       //"dom": 'T<"clear">lfrtip',
         "dom": 'Bfrtip',
         buttons: [
            {
          text: '<span class="fa fa-plus fa-fw"></span>Alta de Cliente o Prov.</a>',
                action: function ( e, dt, node, config ) {
                  var route1 = $("#create-route").val().trim();
                  //console.log(title1);
                  var add_on1 = '';
                  $.ajax({
                    type : 'GET',
                    url : route1,
                    beforeSend: function () {
                      $(".se-pre-con").fadeIn("fast");
                      $('#generalModal .modal-content .modal-body').empty();
                    }
                  })
                  .done(function(response){
                    $.ajax({
                      url: "/js/admin/persons/form.js",
                      dataType: "script"
                    });

                    var modal = $('#generalModal');
                    $('#generalModal .modal-content .modal-body').html(response);
                    //console.log($('#change-person span')[0].innerHTML);
                    $('#generalModal .modal-content .modal-title')
                      .html('Formulario de Empresa');
                    $('#generalModal .modal-content .modal-footer #modal-add-place')
                      .html(add_on1);
                    $(modal).modal('show', {backdrop: 'static'});
                    $(".se-pre-con").fadeOut("fast");

                  })
                  .fail(function(jqXHR, textStatus, errorThrown) {
                    if(jqXHR.status==422){
                      var errores = JSON.parse(jqXHR.responseText);
                    }else{
                     console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                   }
                 });
                },
                className : "btn btn-info"
            }
        ],
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
      return (
       "<button id='show-persons-"+full.id+"' type='button'"+
        "class='persons-show btn btn-primary' data-value='"+full.document+
        "' data-id='"+full.id+"' ><i class='fa fa-eye'></i></button>"+
        ( (full.status==1) ?
        "<button id='delete-liq-"+full.period_liquidation_id+"' type='button'"+
         "class='persons-delete btn btn-danger' data-code='"+full.code+
         "' data-id='"+full.period_liquidation_id+"' data-status='"+full.status+
         "' data-apply_to='"+full.apply_to+"'"+"><i class='fa fa-trash'></i></button>"
         : "")
       );
     },
       1 :
     [
    { data: 'field_name1',"targets": 0, 'title':'Nombre', visible:true},
    { data: 'document_type',"targets": 1, 'title':'Tipo Doc', visible:true},
    { data: 'document',"targets": 2, 'title':'Documento', visible:true},
    { data: 'state_name',"targets": 3, 'title':'Provincia', visible:true},
    {
     'targets' : 4, 'title':'Ops', visible:true,
     'searchable' : true, 'orderable' : true, 'className' : 'dt-body-center',
     'data' : ['type_name', 'type_id'],
     'render': function(data, type, full, meta){
       return   window.columnsDef.buttons(data, type, full, meta)
     }
   },
    { "targets":5, "title":'', 'defaultContent':'',  visible:false},
    { "targets":7, "title":'', 'defaultContent':'',  visible:false},
    { "targets":8, "title":'', 'defaultContent':'',  visible:false},
    { "targets":9, "title":'', 'defaultContent':'',  visible:false},
    { "targets":10, "title":'', 'defaultContent':'',  visible:false}
    ]

  };



window.openModalModule = function(data_id, period, status, apply_to){
  $('#generalModal .modal-content .modal-body').empty();
  var route1 = $('#show-route').val().trim();
  route1 = route1.replace('&id', data_id );
  var title1 = ''; var add_on1;

  /*if(status=='1'){
    add_on1 = '<button class="btn btn-danger" id="btn-prev-lock-persons">'+
      '<span class="fa fa-lock fa-fw"></span>Cerrar</a></button>';
    add_on1 += '<button class="btn btn-warning" id="btn-recalculate">'+
      '<span class="fa fa-refresh fa-fw"></span>Recalcular</a></button>';
      $("#general-button-save").show();
    }
  if(status=='2'){
    add_on1 = '<button class="btn btn-primary" id="btn-unlock-persons">'+
      '<span class="fa fa-unlock fa-fw"></span>Abrir</a></button>';
      $("#general-button-save").hide();
  }*/

  title1 = 'Formulario de Cliente/Proveedor';

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
    $('#generalModal .modal-content .modal-title').html(title1);
    $('#generalModal .modal-content .modal-footer #modal-add-place').html(add_on1);
    $(modal).modal('show', {backdrop: 'static'});
    $(".se-pre-con").fadeOut("fast");

    $.ajaxSetup({ cache: false });
    $.ajax({
      url: "/js/admin/persons/form.js",
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
        url: "/js/admin/persons/delete.js",
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
       .attr('class',
       'alert alert-danger alert-dismissable animate-alert-top fade in');
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

  window.dataTable['#principal-data'].on( 'draw', function (e) {
    $(this).find('.persons-show').off();
    //show element persons
    $(this).find('.persons-show').on('click', function(){
      window.openModalModule(this.getAttribute('data-id')
      , this.getAttribute('data-value'), this.getAttribute('data-status')
      , this.getAttribute('data-apply-to'));
    });

    /*
    $(this).find('.persons-delete').off();
    $(this).find('.persons-delete').on('click', function(){

      window.openModalDelete(this.getAttribute('data-id')
      , this.getAttribute('data-apply_to'), this.getAttribute('data-code') );
    });*/

  });



});
