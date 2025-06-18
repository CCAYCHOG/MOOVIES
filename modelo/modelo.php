<?php
// Incluir archivo de configuración
require_once __DIR__ . '/../configuracion/conexion.php';

class ModeloPeliculas {
    private $conexion;

    public function __construct() {
        // Establecer conexión a la base de datos
        $this->conexion = obtenerConexion("RegistroPeliculas");
    }

    // Insertar nueva película
    public function registrarPelicula($titulo, $anio, $duracionMin, $idGenero, $idDirector) {
        $sql = "EXEC sp_RegistrarPelicula :titulo, :anio, :duracionMin, :idGenero, :idDirector";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':anio', $anio);
        $stmt->bindParam(':duracionMin', $duracionMin);
        $stmt->bindParam(':idGenero', $idGenero);
        $stmt->bindParam(':idDirector', $idDirector);
        return $stmt->execute();
    }

    // Actualizar película
    public function actualizarPelicula($id, $titulo, $anio, $duracionMin, $idGenero, $idDirector) {
        $sql = "EXEC sp_ActualizarPelicula :id, :titulo, :anio, :duracionMin, :idGenero, :idDirector";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':anio', $anio);
        $stmt->bindParam(':duracionMin', $duracionMin);
        $stmt->bindParam(':idGenero', $idGenero);
        $stmt->bindParam(':idDirector', $idDirector);
        return $stmt->execute();
    }

    // Eliminar lógicamente
    public function eliminarPelicula($id) {
        $sql = "EXEC sp_EliminarPelicula :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Listar todas las películas activas
    public function listarPeliculas() {
        $sql = "EXEC sp_ListarPeliculas";
        $stmt = $this->conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener película por ID
    public function obtenerPeliculaPorId($id) {
        $sql = "EXEC sp_ObtenerPeliculaPorId :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
