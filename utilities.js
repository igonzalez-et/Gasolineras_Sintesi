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

            if (boton.hasClass('favorito')) {
                boton.removeClass('favorito');
                llamarFuncionPHP(id);
            } else {
                boton.addClass('favorito');
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