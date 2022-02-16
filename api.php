<?php

require_once 'gestionLibros.php';

/**
 * Extrae los datos de los autores existentes en la base de datos.
 *
 * @return Array Devuelve un array con los datos de los autores consultados.
 */
function get_lista_autores(){
    $gestion = new gestionLibros();
    $conexion = $gestion->conexion('localhost', 'dani', '1234', 'libros');
    $lista_autores = $gestion->consultarAutores($conexion);
    
    return $lista_autores;
}

/**
 * Extrae los datos de un autor de la base de datos y los datos de los libros que ha escrito.
 * 
 * @param int $id Número de ID del autor.
 * @return Array Devuelve un array con los datos del autor consultado y de los libros que ha escrito.
 */
function get_datos_autor($id){
    $info_autor = array();
    $gestion = new gestionLibros();
    $conexion = $gestion->conexion('localhost', 'dani', '1234', 'libros');
    $info_autor["datos"] = $gestion->consultarAutores($conexion, $id);
    $info_autor["libros"] = $gestion->consultarLibros($conexion, $id);
    
    return $info_autor;
}

/**
 * Extrae los datos de los libros existentes en la base de datos.
 *
 * @return Array Devuelve un array con los datos de los libros consultados.
 */
function get_lista_libros() {
  $gestion = new gestionLibros();
  $conexion = $gestion->conexion('localhost', 'dani', '1234', 'libros');
  $lista_libros = $gestion->consultarLibros($conexion);

  return $lista_libros;
}

/**
 * Extrae los titulos de los libros existentes en la base de datos.
 *
 * @return Array Devuelve un array con los titulos de los libros.
 */
function get_titulos_libros($titulo) {
  $gestion = new gestionLibros();
  $conexion = $gestion->conexion('localhost', 'dani', '1234', 'libros');
  $lista_libros = $gestion->consultarTitulosLibros($conexion, $titulo);

  return $lista_libros;
}

/**
 * Extrae los datos de un libro de la base de datos y los datos del autor que lo ha escrito.
 * 
 * @param int $id Número de ID del libro.
 * @return Array Devuelve un array con los datos del libro consultado y del autor que lo ha escrito.
 */
function get_datos_libro($id) {
  $gestion = new gestionLibros();
  $conexion = $gestion->conexion('localhost', 'dani', '1234', 'libros');
  $info_libro["datos"] = $gestion->consultarDatosLibro($conexion, $id);
  $info_libro["autor"] = $gestion->consultarAutores($conexion, $info_libro["datos"]["id_autor"]);

  return $info_libro;
}

/**
 * Extrae los nombres de los autores y los titulos de los libros que ha escrito.
 * 
 * @param int $str Cadena del autor que se quiere consultar.
 * @return Array Devuelve un array con los nombres de autores y los titulos de los libros.
 */
function get_autores_con_libros($str) {
  $gestion = new gestionLibros();
  $conexion = $gestion->conexion('localhost', 'dani', '1234', 'libros');
  $info = $gestion->consultarNombreAutores($conexion, $str);
  foreach($info as $i=>$autor){
      $info[$i]["libros"] = $gestion->consultarLibros($conexion, $autor["id"]);
  }

  return $info;
}

$posibles_URL = array("get_lista_autores", "get_datos_autor", "get_lista_libros", "get_datos_libro", "get_titulos_libros", "get_autores_con_libros");

$valor = "Ha ocurrido un error";

if (isset($_GET["action"]) && in_array($_GET["action"], $posibles_URL))
{
  switch ($_GET["action"])
    {
      case "get_lista_autores":
        $valor = get_lista_autores();
        break;
      case "get_datos_autor":
        if (isset($_GET["id"]))
            $valor = get_datos_autor($_GET["id"]);
        else
            $valor = "Argumento no encontrado";
        break;
      case "get_lista_libros":
        $valor = get_lista_libros();
        break;
      case "get_datos_libro":
        if (isset($_GET["id"]))
            $valor = get_datos_libro($_GET["id"]);
        else
            $valor = "Argumento no encontrado";
        break;
      case "get_titulos_libros":
        if (isset($_GET["titulo"]))
            $valor = get_titulos_libros($_GET["titulo"]);
        else
            $valor = "Argumento no encontrado";
        break;
      case "get_autores_con_libros":
        if (isset($_GET["nombre"]))
            $valor = get_autores_con_libros($_GET["nombre"]);
        else
            $valor = "Argumento no encontrado";
        break;

    }
}

exit(json_encode($valor));
?>
