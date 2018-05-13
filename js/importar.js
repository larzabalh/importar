$(document).on("submit",".formarchivo",function(e){

        e.preventDefault();
        var formu=$(this);
        var nombreform=$(this).attr("id");
        var importar = $('#importar').val();
        if(importar=="persons"){ var url = $("#route-importar-persons").val().trim(); }
        
        //información del formulario
        var formData = new FormData($("#"+nombreform+"")[0]);
        console.log(formData)
        console.log(importar)
        //hacemos la petición ajax   
        $.ajax({
            url: url,  
            type: 'POST',
     
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //una vez finalizado correctamente
            success: function(data){
              console.log('success ajax DATA:', data) 
                    $('#OK').html('CORRECTAMENTE')           
            },
            //si ha ocurrido un error
            error: function(data){
               $('#OK').html('ERROR');	
                
            }
        });
        });