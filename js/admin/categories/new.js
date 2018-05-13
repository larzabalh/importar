$( document ).ready(function() {

  //configure the validation
  $('#add-form').validate({
	   debug: true,
		rules: {
			"nameCategorie": {	required: true }
		},
		messages: {
			"nameCategorie": "Ingresa el Nombre."
		},

    submitHandler: function(form){
      var validator = this;
      console.log('ejecutando...');
      $.ajax({
        type : 'GET',
        url : '/Logistica/masters/categories/validateNewDuplicated',
        beforeSend: function () {
          $("#send-button").prop("disabled", true);
        },
        data : {
         "nameCategorie" : $('#nameCategorie').val()
       }
      })
      .done(function(response){ // What to do if we succeed
        //console.log(response);
        console.log('registrando');
        form.submit();
        $("#send-button").prop("disabled", false);
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
      }
  });

});
