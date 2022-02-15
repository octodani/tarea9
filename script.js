$(document).ready(function(){
    $("#cuadroTexto").keyup(function(){
        var cT = $('#cuadroTexto').val();
        if (validarTexto(cT)) {
            mostrar_sugerencias(cT);
        } else {
            mostrar_sugerencias('');
        }
    });
});

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

function mostrar_sugerencias(str) {
    if (str == '') {
        document.getElementById("sugerencias").innerHTML = "";
        return;
    } else {
        var asyncRequest = new XMLHttpRequest();
        asyncRequest.onreadystatechange = stateChange;
        asyncRequest.open("GET", 'api.php?action=get_autores_con_libros&nombre='+str, true);
        asyncRequest.send(null);
        function stateChange(){
            if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
                var result = formatear(JSON.parse(asyncRequest.responseText));
                document.getElementById('sugerencias').innerHTML = 'Sugerencias:<br>' + result;
            }
        }
    }
}

function formatear(arr) {
    console.log(arr);
    var datos = '';
    for(var a of arr) {
        datos += '<h4>'+ a['nombre'] + ' ' + a['apellidos'] + '</h4><ul>';
        for(var l of a["libros"]) {
            datos += '<li>' + l["titulo"] + '</li>';
        }
        datos += '</ul>'
    }
    return datos;
}
