<?php
// Solo permitir peticiones POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Método no permitido
    echo json_encode(["error" => "Método no permitido. Usa POST."]);
    exit;
}

// Incluir el modelo
require_once __DIR__ . '/../modelo/modelo.php';

// Crear instancia del modelo
$modelo = new ModeloPeliculas();

try {
    // Obtener lista de películas activas
    $peliculas = $modelo->listarPeliculas();

    // Retornar los datos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($peliculas, JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error al listar películas: " . $e->getMessage()]);
}
?>
