<?php
function obtenerConexion($nombreBD, $host = "192.168.100.58", $puerto = "1433", $usuario = "programacion", $contrasena = "080502") {
    try {
        // Crear la conexión PDO
        $conexion = new PDO("sqlsrv:Server=$host,$puerto;Database=$nombreBD", $usuario, $contrasena);

        // Habilita excepciones para errores
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conexion;
    } catch (PDOException $e) {
        die("Error al conectar con la base de datos '$nombreBD': " . $e->getMessage());
    }
}
?>