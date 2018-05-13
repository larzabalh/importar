 window.recalculateFields = function(el){
  //console.log('cooo->',el.id)
  var temp = el.id.replace('amount_', '');
  var value = parseFloat($(el).val().replace(',', '.'));
  var calculate = 0; var calculate_total=0;
  if(value>0){
    calculate = ((value * parseFloat($('#percent_iva_'+temp).val()))/100);
  }
  $('#iva_amount_'+temp).val(calculate.toFixed(2));
  $.each( $("input[id^='amount_'"), function(index, item){
    calculate = 0;
    var temp2 = item.id.replace('amount_', '');
    if(document.getElementById('iva_amount_'+temp2)){
      if(  parseFloat($('#iva_amount_'+temp2).val())>0 ){
        calculate = parseFloat($('#iva_amount_'+temp2).val());
      }
    } else { calculate = 0 }
    var value_i = parseFloat(item.value.replace(',', '.'));
    if(!isNaN(value_i) && value_i>0){
      calculate_total += parseFloat(value_i.toFixed(2)) + calculate ;
    }
    //console.log('item->'+item.id+', valor->'+value_i+', calculate->'+calculate+
    //', total->'+calculate_total);
  });
  //console.log('total->'+calculate_total);
  $('#total-amount').val(calculate_total);
  $('#total-amount-mask').html('$ '+calculate_total.toFixed(2).replace('.', ','));

};

window.type_receipt_fields = function(el){
  // console.log('trf->',el)
  var type_id = el.data.type_id;
  var data_nt = type_id.options[type_id.selectedIndex].getAttribute('data-nt');
  $.each( $("input[name^='amount['") , function(index, item){
    var data_nt_item = $(item)[0].getAttribute("data-nt");
    $(item).prop('readonly', false);
    //console.log($(item)[0].parentNode.parentNode.parentNode.style);
    $(item)[0].parentNode.parentNode.parentNode.style.display='block';
    //console.log('select->',data_nt,', input->',item.id,',data-nt:',data_nt_item);
    if(data_nt==1 && data_nt_item==1){
      $(item).prop('readonly', true);
      //console.log('debo poner en 0 estos campos y recalcular todo');
      //console.log(ev)
      $(item).val(0);
       window.recalculateFields(item);
      $(item)[0].parentNode.parentNode.parentNode.style.display='none';
    }
  });

}

$( document ).ready(function() {



  window.callback_module = function(type_id){
    window.module = {};
    window.module.type_id = type_id;
    window.contador=0;
    if(window.dataTable){
      $('#principal-data').empty();
      //window.dataTable.destroy();
    }

    var dataTable = $('#principal-data').DataTable( );
      dataTable = $('#principal-data').DataTable({
       //"dom": 'T<"clear">lfrtip',
         "dom": 'Bfrtip',
         buttons: [
            {
          text: '<span class="fa fa-plus fa-fw"></span>Nuevo Comprobante</a>',
                action: function ( e, dt, node, config ) {
                  var route1 = $("#create-route").val().trim()
                    .replace('&type_id', type_id);
                  var title1 = $('#type_id_'+type_id)[0].innerHTML;
                  //console.log(title1);
                  var add_on1 = '<span>Monto Total: </span>';
                  add_on1 += '<span id="total-amount-mask" class="total-amount">$ 0,00</span>';
                  add_on1 += '<input type="hidden" name="no-use" value="0" id="total-amount"/>';
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
                      url: "/js/admin/receipt/form"+type_id+".js",
                      dataType: "script"
                    });

                    var modal = $('#generalModal');
                    $('#generalModal .modal-content .modal-body').html(response);
                    //console.log($('#change-person span')[0].innerHTML);
                    $('#generalModal .modal-content .modal-title')
                      .html('Comprobante: '+title1+' ('+
                      $('#change-person span')[0].innerHTML + ')');
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
        ajax: { "url": $("#route-refresh-list").val().trim()
                .replace('&person_id', $('#current-person-id').val()),
              "data": {
                  "type_id": type_id
              } },
        aoColumns : window.columnsDef[type_id],
        /*columnDefs:
          window.columnsDef[type_id]
        ,*/
        select: {
            style: 'os',
            selector: 'td:not(:last-child)' // no row selection on last column
        },
          "bDestroy": true,
          "iDisplayLength": 10,//Paginación
          "order": [[ 1, "asc" ]]//Ordenar (columna,orden)
    });
    window.dataTable = dataTable;
  }


  window.columnsDef = {
    buttons : function(data, type, full, meta){
      return ('<input type="hidden" name="type_id['+full.id
       +']" value="'+full.type_id+'">'
       +'<input type="hidden" name="id['+full.id
       +']" value="'+full.id+'">'+
       "<button type='button' class='receipt-edit btn btn-primary'"+
        "data-value='"+full.amount+"' data-id='"+full.id+"'"+
        "><i class='fa fa-eye'></i></button>"+
      ( (full.period_liquidation_close==null) ?
        "<button type='button'class='receipt-delete btn btn-danger'" +
         "data-status='"+full.status_id+"' data-id='"+full.id+"' "+
         "data-value='"+full.amount+"' > "+
         "<i class='fa fa-trash-o'></i></button>"
         : "")
       );
     }
    ,  1 :
   [{ data: 'period_code',"targets": 0, 'title':'Periodo', visible:true },
  { data: 'receipt_date',"targets": 1, 'title':'Fecha', visible:true},
  { data: 'person_field_name1',"targets": 2, 'title':'Cliente', visible:true},
  { data: 'receipt_type_name',"targets": 3, 'title':'Tipo', visible:true},
  { data: 'code_ticket',"targets": 4, 'title':'Punto de Venta', visible:true},
  { data: 'number',"targets": 5, 'title':'Numero', visible:true},
  { data: 'amount',"targets": 6, 'title':'Monto', visible:true},
  {
     'targets' : 7, 'title':'Ops', visible:true,
     'searchable' : true, 'orderable' : true, 'className' : 'dt-body-center',
     'data' : ['type_name', 'type_id'],
     'render': function(data, type, full, meta){
       return   window.columnsDef.buttons(data, type, full, meta)
     }
    },
    { "targets":8, "title":'', 'defaultContent':'',  visible:false},
    { "targets":9, "title":'', 'defaultContent':'',  visible:false}
    ],

    2 :
     [{ data: 'period_code',"targets": 0, 'title':'Periodo', visible:true },
    { data: 'receipt_date',"targets": 1, 'title':'Fecha', visible:true},
    { data: 'person_field_name1',"targets": 2, 'title':'Proveedor', visible:true},
    { data: 'receipt_type_name',"targets": 3, 'title':'Tipo', visible:true},
    { data: 'code_ticket',"targets": 4, 'title':'Punto de Venta', visible:true},
    { data: 'number',"targets": 5, 'title':'Numero', visible:true},
    { data: 'amount',"targets": 6, 'title':'Monto', visible:true },
    {
       'targets' : 7, 'title':'Ops', visible:true,
       'searchable' : true,
       'orderable' : true,
       'className' : 'dt-body-center',
       'data' : ['type_name', 'type_id'],
       'render': function(data, type, full, meta){
         return   window.columnsDef.buttons(data, type, full, meta)
       }
      },
      { "targets":8, "title":'', 'defaultContent':'',  visible:false},
      { "targets":9, "title":'', 'defaultContent':'',  visible:false}
     ],

      3 :
       [{ data: 'period_code',"targets": 0, 'title':'Periodo', visible:true },
      { data: 'receipt_date',"targets": 1, 'title':'Fecha', visible:true},
      { data: 'person_field_name1',"targets": 2, 'title':'Cliente', visible:true},
      { data: 'retention_type_name',"targets": 3, 'title':'Retencion', visible:true},
      { data: 'reference',"targets": 4, 'title':'Referencia', visible:true},
      { data: 'receipt_type_name',"targets": 5, 'title':'Tipo', visible:true},
      { data: 'code_ticket',"targets": 6, 'title':'Punto de Venta', visible:true},
      { data: 'number',"targets": 7, 'title':'Numero', visible:true},
      { data: 'amount',"targets": 8, 'title':'Monto', visible:true },
      {
         'targets' : 9, 'title':'Ops', visible:true,
         'searchable' : true,
         'orderable' : true,
         'className' : 'dt-body-center',
         'data' : ['type_name', 'type_id'],
         'render': function(data, type, full, meta){
           return   window.columnsDef.buttons(data, type, full, meta)
         }
        } ],

       4 :
        [{ data: 'period_code',"targets": 0, 'title':'Periodo', visible:true },
       { data: 'zone_name',"targets": 1, 'title':'Zona', visible:true},
       { data: 'amount',"targets": 2, 'title':'Monto', visible:true },
       {
          'targets' : 3, 'title':'Ops', visible:true,
          'searchable' : true,
          'orderable' : true,
          'className' : 'dt-body-center',
          'data' : ['type_name', 'type_id'],
          'render': function(data, type, full, meta){
            return   window.columnsDef.buttons(data, type, full, meta)
          }
         },
         { "targets":4, "title":'', 'defaultContent':'',  visible:false},
         { "targets":5, "title":'', 'defaultContent':'',  visible:false},
         { "targets":6, "title":'', 'defaultContent':'',  visible:false},
         { "targets":7, "title":'', 'defaultContent':'',  visible:false},
        { "targets":8, "title":'', 'defaultContent':'',  visible:false},
        { "targets":9, "title":'', 'defaultContent':'',  visible:false}
      ],

     5 :
      [{ data: 'period_code',"targets": 0, 'title':'Periodo', visible:true },
     { data: 'receipt_date',"targets": 1, 'title':'Fecha', visible:true},
     { data: 'reference',"targets": 2, 'title':'Referencia', visible:true},
     { data: 'amount',"targets": 3, 'title':'Monto', visible:true },
     {
        'targets' : 4, 'title':'Ops', visible:true,
        'searchable' : true,
        'orderable' : true,
        'className' : 'dt-body-center',
        'data' : ['type_name', 'type_id'],
        'render': function(data, type, full, meta){
          return   window.columnsDef.buttons(data, type, full, meta)
        }
       },
       { "targets":5, "title":'', 'defaultContent':'',  visible:false},
       { "targets":6, "title":'', 'defaultContent':'',  visible:false},
       { "targets":7, "title":'', 'defaultContent':'',  visible:false},
       { "targets":8, "title":'', 'defaultContent':'',  visible:false},
       { "targets":9, "title":'', 'defaultContent':'',  visible:false}
    ],

   6 :
    [{ data: 'period_code',"targets": 0, 'title':'Periodo', visible:true },
   { data: 'receipt_date',"targets": 1, 'title':'Fecha', visible:true},
   { data: 'reference',"targets": 2, 'title':'Referencia', visible:true},
   { data: 'amount',"targets": 3, 'title':'Monto', visible:true },
   {
      'targets' : 4, 'title':'Ops', visible:true,
      'searchable' : true,
      'orderable' : true,
      'className' : 'dt-body-center' ,
      'data' : ['type_name', 'type_id'],
      'render': function(data, type, full, meta){
        return   window.columnsDef.buttons(data, type, full, meta)
      }
     },
     { "targets":5, "title":'', 'defaultContent':'',  visible:false},
     { "targets":6, "title":'', 'defaultContent':'',  visible:false},
     { "targets":7, "title":'', 'defaultContent':'',  visible:false},
     { "targets":8, "title":'', 'defaultContent':'',  visible:false},
     { "targets":9, "title":'', 'defaultContent':'',  visible:false}
  ]

  };


  window.callback_module(1);

  $('.dataTables_filter').addClass('pull-right');

  // $('#principal-data').DataTable({
  //    iDisplayLength: 10,
  //    order: [[ 1, 'asc' ], [2, 'asc']]
  //
  //   });

  // $('.btn-group .btn.btn-primary').each(function(index) {
  //   $(this).on("click", function(){
  //       // For the boolean value
  //       var boolKey = $(this).data('selected');
  //       // For the mammal value
  //       var mammalKey = $(this).attr('id');
  //   });


  $('.btn-group .btn.btn-primary').on( 'click', function(event) {
    event.preventDefault();
    //console.log(this.children[0].value);
    var currenT = this.children[0];
    var arr = $(this).context.parentNode.children;
    //console.log(arr);
     $.each( arr, function( key, value){
       if(currenT.value==value.children[0].value){
         $(value).addClass('btn-active');
       }else{
         $(value).removeClass('btn-active');
       }
     });
    window.callback_module($(this).context.children[0].value);
    //var temp = $(this).context.children[0].value;
  //  console.log($(this));
    /*$('.form-control.input-sm,input[type="search"]')
      .val($(this).context.children[0].innerHTML);
    window.dataTable.column(7)
    .search($(this).context.children[0].innerHTML).draw();*/
    //console.log(window.dataTable);
    //window.dataTable.ajax.data.type_id = temp ;
    //window.dataTable.ajax.reload();
  });
/*
  $('#button-new-receipt').on( 'click', function() {
    var modal = $('#alertsModal');
    var html = '<div class="alert alert-danger" role="alert">';
      html+='<span class="glyphicon glyphicon-exclamation-sign"';
      html+=' aria-hidden="true"></span>Formulario</div>';
    $('#alertsModal .modal-content .modal-body').html(html);
    $(modal).modal('show', {backdrop: 'static'});
  });*/

/*
  $('#button-new-receipt').on( 'click', function(e) {
    e.preventDefault();
    var route1 = this.getAttribute('data-route');
    var title1 = this.getAttribute('data-type');
    var add_on1 = '<span>Monto Total: </span>';
  add_on1 += '<span id="total-amount-mask" class="total-amount">$ 0,00</span>';
  add_on1 += '<input type="hidden" name="no-use" value="0" id="total-amount"/>';
    $.ajax({
      type : 'GET',
      url : route1,
      beforeSend: function () {
        $(".se-pre-con").fadeIn("fast");
      }
    })
    .done(function(response){
      var modal = $('#generalModal');
      $('#generalModal .modal-content .modal-body').empty();
      $('#generalModal .modal-content .modal-body').html(response);
      $('#generalModal .modal-content .modal-title').html('Comprobante: '+title1);
      $('#generalModal .modal-content .modal-footer #modal-add-place').html(add_on1);
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
  });
*/

  window.dataTable.on( 'draw', function () {
    //edit element receipt
    $(this).find('.receipt-edit').off();
    $(this).find('.receipt-edit').on('click', function(){
      var route1 = $('#edit-route').val().trim();
      route1 = route1.replace('&id', this.getAttribute('data-id') );
      var title1 = $('#type_id_'+window.module.type_id)[0].innerHTML;
      var add_on1 = '<span>Monto Total: </span>';
      add_on1 += '<span id="total-amount-mask" class="total-amount">$ '+
      this.getAttribute('data-value').replace('.', ',')+' </span>';
      add_on1 += '<input type="hidden" name="no-use" value="0" id="total-amount"/>';
      $.ajax({
        type : 'GET',
        url : route1,
        beforeSend: function () {
          $(".se-pre-con").fadeIn("fast");
        }
      })
      .done(function(response){
        var modal = $('#generalModal');
        $('#generalModal .modal-content .modal-body').empty();
        $('#generalModal .modal-content .modal-body').html(response);
        $('#generalModal .modal-content .modal-title')
          .html('Editar Comprobante: '+title1+' ('+
          $('#change-person span')[0].innerHTML + ')');
        $('#generalModal .modal-content .modal-footer #modal-add-place').html(add_on1);
        $(modal).modal('show', {backdrop: 'static'});
        $(".se-pre-con").fadeOut("fast");

        $.ajax({
          url: "/js/admin/receipt/form"+window.module.type_id+".js",
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
    });

    //console.log($(this[0]));

//delete element receipt

    $(this).find('.receipt-delete').off();
    $(this).find('.receipt-delete').on('click', function(){
      /*var route1 = $('#edit-route').val().trim();
      route1 = route1.replace('&id', this.getAttribute('data-id') );
      var status_id = this.getAttribute('data-status');
    //  console.log($(this));
      var receipt_data = $(this)[0].parentNode.parentNode.innerHTML;
    console.log('eliminando el comprobante :'+receipt_data);

    var modal = $('#dangerModal');
    $('#dangerModal .modal-content .modal-body').empty();
    $('#dangerModal .modal-content .modal-body').html(receipt_data);
    $('#dangerModal .modal-content .modal-header .modal-title')
      .html('Eliminando comprobante!!!');
    //$('#dangerModal .modal-content .modal-footer #modal-add-place').html(add_on1);
    $(modal).modal('show', {backdrop: 'static'});
    return false;*/

    var route1 = $('#edit-route').val().trim();
    route1 = route1.replace('&id', this.getAttribute('data-id') );
    var title1 = $('#type_id_'+window.module.type_id)[0].innerHTML;
    var add_on1 = '<span>Monto Total: </span>';
  add_on1 += '<span id="total-amount-mask" class="total-amount">$ '+
  this.getAttribute('data-value').replace('.', ',')+' </span>';
  add_on1 += '<input type="hidden" name="no-use" value="0" id="total-amount"/>';
    $.ajax({
      type : 'GET',
      url : route1,
      beforeSend: function () {
        $(".se-pre-con").fadeIn("fast");
      }
    })
    .done(function(response){
      var modal = $('#dangerModal');
      $('#dangerModal .modal-content .modal-body').empty();
      $('#dangerModal .modal-content .modal-body').html(response);
      $('#dangerModal .modal-content .modal-title')
        .html('Eliminar Comprobante: '+title1+' ('+
        $('#change-person span')[0].innerHTML + ')');
      $('#dangerModal .modal-content .modal-footer #modal-add-place').html(add_on1);
      $(modal).modal('show', {backdrop: 'static'});
      $(".se-pre-con").fadeOut("fast");

      $.ajax({
        url: "/js/admin/receipt/delete.js",
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
/*
      //var title1 = this.getAttribute('data-type');
      var add_on1 = '<span>Monto Total: </span>';
    add_on1 += '<span id="total-amount-mask" class="total-amount">$ '+
    this.getAttribute('data-value').replace('.', ',')+' </span>';
    add_on1 += '<input type="hidden" name="no-use" value="0" id="total-amount"/>';
      $.ajax({
        type : 'GET',
        url : route1,
        beforeSend: function () {
          $(".se-pre-con").fadeIn("fast");
        }
      })
      .done(function(response){
        var modal = $('#dangerModal');
        $('#generalModal .modal-content .modal-body').empty();
        $('#generalModal .modal-content .modal-body').html(response);
        //$('#generalModal .modal-content .modal-title').html('Comprobante: '+title1);
        $('#generalModal .modal-content .modal-title')
          .html('EliminarComprobante: '+title1+' ('+
          $('#change-person span')[0].innerHTML + ')');
        $('#generalModal .modal-content .modal-footer #modal-add-place').html(add_on1);
        $(modal).modal('show', {backdrop: 'static'});
        $(".se-pre-con").fadeOut("fast");
      })
      .fail(function(jqXHR, textStatus, errorThrown) {
        if(jqXHR.status==422){
          var errores = JSON.parse(jqXHR.responseText);
        }else{
         console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
       }
     });*/
    });
  } );

});
