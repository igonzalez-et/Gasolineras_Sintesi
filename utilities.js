function submitFormFavorito(id) {
    event.preventDefault();
    var form = document.getElementById('form_favorito_' + id);
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', form.action, true);
    xhr.onload = function () {
        if (xhr.status === 200 && xhr.responseText) {
            // console.log(xhr.responseText);
            console.log(id);
            var boton = $("#botonMarcar" + id);
            var icono = $("#botonMarcar" + id + " i");
            if (boton.hasClass('favorito')) {
                boton.removeClass('favorito');
                icono.removeClass('fa fa-star');
                icono.addClass('fa fa-star-o');
                llamarFuncionPHP(id);
            } else {
                icono.removeClass('fa fa-star-o');
                boton.addClass('favorito');
                icono.addClass('fa fa-star');
                llamarFuncionPHP(id);
            }
        } else {
            console.error('Error en la petición');
        }
    };
    xhr.send(formData);
    return false;
}

function llamarFuncionPHP(id_gasolinera) {
    $.ajax({
        url: "listado_gasolinera.php",
        type: "POST",
        data: { funcion: "marcarFavorito", id_gasolinera: id_gasolinera },
        success: function(respuesta) {
        console.log("Se ha añadido a favoritos correctamente");
        },
        error: function() {
        console.log("Error en la petición");
        }
    });
}

function submitFormMensaje(mensajeUsuario) {
    event.preventDefault();
    var form = document.getElementById('form_mensaje_');
    var formData = new FormData(form);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', form.action, true);
    xhr.onload = function () {
        if (xhr.status === 200 && xhr.responseText) {
                llamarFuncionPHPmensaje(mensajeUsuario);
        } else {
            console.error('Error en la petición');
        }
    };
    xhr.send(formData);
    return false;
}

function llamarFuncionPHPmensaje(mensajeUsuario) {
    $.ajax({
        url: "detalle_gasolinera.php",
        type: "POST",
        data: { funcion: "guardarMensaje" , mensajeUsuario: mensajeUsuario},
        success: function(respuesta) {
        console.log("El mensaje se ha guardado correctamente");
        },
        error: function() {
        console.log("Error en la petición");
        }
    });
}