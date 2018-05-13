$( document ).ready(function() {

  $('#back-item').tooltipster({
    theme: ['tooltipster-light'],   animation: 'fade',  delay: 300,
    trigger: 'hover', position: ['bottom'], 'content': 'Volver'});


  //configure the validation
  /*$('#modules-form').validate({
	   debug: true,
		rules: {
			"loginUser": {	required: true },
			"emailUser": { required: true, email: true	},
      "claveUser": { required: true, minlength: 6 },
      "claveUser_confirmation": { minlength: 6, equalTo: "#claveUser" },
      "avatar": { extension: "jpg|png|gif" }
		},
		messages: {
			"loginUser": "Ingresa el login."	,
			"emailUser": "Email invalido." ,
      "claveUser": { required :"Password requerido",
        minlength: jQuery.validator.format("Al menos {0} caracteres requiere!")
     },
      "claveUser_confirmation": {
        minlength: jQuery.validator.format("Al menos {0} caracteres requiere!"),
        equalTo: "Password no coinciden." },
      "avatar": { extension: "Solo puede subir archivos de tipo imagen (jpg, png, gif)" }
		},

    submitHandler: function(form){
      var validator = this;
      console.log('ejecutando...');
      $.ajax({
        type : 'GET',
        url : '/Logistica/security/users/validateNewDuplicated',
        beforeSend: function () {
          $("#send-button").prop("disabled", true);
        },
        data : {
         "loginUser" : $('#loginUser').val(),
         "emailUser" : $('#emailUser').val()
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
  });*/

});
