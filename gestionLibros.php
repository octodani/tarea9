<?php

    class gestionLibros { // si los datos son incorrectos el test no entra en la bd, si son correctos da un fallo
        
        /**
         * Crea una conexión con una base de datos
         *
         * @param  string $servidor Nombre del servidor donde se aloja la base de datos
         * @param  string $usuario Nombre de usuario de acceso a la base de datos
         * @param  string $contrasena Contraseña de acceso a la base de datos
         * @param  string $baseDeDatos Nombre de la base de datos
         * @return mysqli|null Devuelve un objeto mysqli o null si la conexión ha fallado.
         */
        function conexion($servidor, $usuario, $contrasena, $baseDeDatos) {
            $conexion = @new mysqli($servidor, $usuario, $contrasena, $baseDeDatos);
            if ($conexion->connect_error) {
                return null;
            }
            return $conexion;
        }
        
        /**
         * Hace una consulta sobre los datos de los autores existentes en la base de datos. Si se incluye
         * el ID del autor sólo se consultan los datos de dicho autor.
         *
         * @param  mysqli $conexion Objeto con la conexión a la base de datos
         * @param  int $idAutor Opcional. Número de ID del autor.
         * @return Array|null Devuelve un array con los datos de los autores consultados o null si la consulta ha fallado
         */
        function consultarAutores($conexion, $idAutor=null) {
            $conexion->set_charset("utf8");
            $query = isset($idAutor) ? "SELECT * FROM autor WHERE id={$idAutor}" : "SELECT * FROM autor";
            $result = $conexion->query($query);
            if($result->num_rows > 0) {
                $row = $result->fetch_all(MYSQLI_ASSOC);
                $result->free();
                return $row;
            }
            return null;
        }

        /**
         * Hace una consulta sobre los id, nombre y apellidos de los autores existentes en la base de datos que 
         * coinciden con el string pasado
         *
         * @param  mysqli $conexion Objeto con la conexión a la base de datos
         * @param  int $nombre Cadena con el nombre de los autores que queremos consultar.
         * @return Array|null Devuelve un array con los ID, nombres y apellidos de los autores consultados o null si la consulta ha fallado
         */
        function consultarNombreAutores($conexion, $nombre) {
            $conexion->set_charset("utf8");
            $query = "SELECT id, nombre, apellidos FROM autor WHERE (nombre LIKE '%$nombre%' OR apellidos LIKE '%$nombre%')";
            $result = $conexion->query($query);
            if($result->num_rows > 0) {
                $row = $result->fetch_all(MYSQLI_ASSOC);
                $result->free();
                return $row;
            }
            return null;
        }

                
        /**
         * Hace una consulta sobre los libros existentes en la base de datos. Si se incluye
         * el ID del autor sólo se consultan los libros de dicho autor.
         *
         * @param  mysqli $conexion Objeto con la conexión a la base de datos
         * @param  int $idAutor Opcional. Número de ID del autor
         * @return Array|null Devuelve un array con los datos de los libros consultados o null si la consulta ha fallado
         */
        function consultarLibros($conexion, $idAutor=null) {
            $conexion->set_charset("utf8");
            $query = isset($idAutor) ? "SELECT * FROM libro WHERE id_autor={$idAutor}" : "SELECT * FROM libro";
            $result = $conexion->query($query);
            if($result->num_rows > 0) {
                $row = $result->fetch_all(MYSQLI_ASSOC);
                $result->free();
                return $row;
            }
            return null;
        }

        /**
         * Hace una consulta sobre los titulos de los libros existentes en la base de datos. Si se incluye
         * el titulo sólo se consultan los libros con el título coincidente.
         *
         * @param  mysqli $conexion Objeto con la conexión a la base de datos
         * @param  int $titulo Opcional. Titulo del libro
         * @return Array|null Devuelve un array con los titulos de los libros consultados o null si la consulta ha fallado
         */
        function consultarTitulosLibros($conexion, $titulo=null) {
            $conexion->set_charset("utf8");
            $query = isset($titulo) ? "SELECT titulo FROM libro WHERE titulo LIKE '%$titulo%'" : "SELECT titulo FROM libro";
            $result = $conexion->query($query);
            if($result->num_rows > 0) {
                $row = $result->fetch_all(MYSQLI_ASSOC);
                $result->free();
                return $row;
            }
            return null;
        }
        
        /**
         * Hace una consulta sobre los datos de un libro de la base de datos.
         *
         * @param  mysqli $conexion Objeto con la conexión a la base de datos
         * @param  int $idLibro Número de ID del libro que queremos consultar
         * @return Array|null Devuelve un array con los datos del libro consultado o null si la consulta ha fallado.
         */
        function consultarDatosLibro($conexion, $idLibro) {
            $conexion->set_charset("utf8");
            $query = "SELECT * FROM libro WHERE id={$idLibro}";
            if($result = $conexion->query($query)) {
                $row = $result->fetch_assoc();
                $result->free();
                return $row;
            }
            return null;
        }
        
        /**
         * Borra el autor al que pertene el id introducido y todos sus libros en la base de datos.
         *
         * @param  mysqli $conexion Objeto con la conexión a la base de datos
         * @param  int $idAutor Número de ID del autor que queremos borrar
         * @return true|false Devuelve true si el borrado se ha realizado correctamente, false en caso contrario
         */
        function borrarAutor($conexion, $idAutor) {
            $conexion->set_charset("utf8");
            $conexion->autocommit(FALSE);
            $conexion->begin_transaction();
            $query = "DELETE FROM libro WHERE id_autor={$idAutor}";
            $conexion->query($query);
            $query = "DELETE FROM autor WHERE id={$idAutor}";
            $conexion->query($query);
            if ($conexion->error) {
                $conexion->rollback();
                $mysqli->autocommit(TRUE);
                return false;
            }
            $conexion->commit();
            $mysqli->autocommit(TRUE);
            return true;
        }
        
        /**
         * Borra el libro  de la base de datos al que pertene el id introducido
         *
         * @param  mysqli $conexion Objeto con la conexión a la base de datos
         * @param  int $idLibro Número de ID del libro que queremos borrar
         * @return true|false Devuelve true si el libro se ha borrado correctamente, false en caso contrario
         */
        function borrarLibro($conexion, $idLibro) {
            $conexion->set_charset("utf8");
            $query = "DELETE FROM libro WHERE id={$idLibro}";
            $conexion->query($query);
            if ($conexion->error) {
                return false;
            }
            return true;
        }

}

?>