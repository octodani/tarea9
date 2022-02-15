<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario - Tarea 9</title>
    
    <style>
        @import url('style.css');
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="script.js"></script>
</head>
<body>
    <h1>Buscador de autores y libros</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>">
        <label for="cuadroTexto"></label><input type="text" name="cuadroTexto" id="cuadroTexto">
        <br>
        <p class="correcto" id="mensajeError">Sólo se pueden introducir letras</p>
        <div id="sugerencias"></div>
    </form>
</body>
</html>