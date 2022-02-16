$(document).ready(function(){
    $("#cuadroTexto").keyup(function(){
        var cT = $('#cuadroTexto').val();
        if (validarTexto(cT)) {
            extraerDatos();
        } else {
            $("#sugerencias").html('');
        }
       
    });
});

function extraerDatos() {
    $.getJSON("api.php?action=get_autores_con_libros&nombre=" + $("#cuadroTexto").val(), function(data) {
        var datos = '';
        for(var a of data) {
            datos += '<h4>'+ a['nombre'] + ' ' + a['apellidos'] + '</h4><ul>';
            for(var l of a["libros"]) {
                datos += '<li>' + l["titulo"] + '</li>';
            }
        datos += '</ul>'    
        }
    $("#sugerencias").html(datos);
    });
}

function validarTexto(texto) {
    if (!/^[a-zA-Z\s]+?$/.test(texto) || texto.length == 0) {
        $('#mensajeError').removeClass('correcto');
        $('#mensajeError').addClass('error');
        return false;
    } else {
        $('#mensajeError').removeClass('error');
        $('#mensajeError').addClass('correcto');
        return true;
    }
}