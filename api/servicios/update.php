<?php
// Encabezados HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir archivos
include_once '../../config/database.php';
include_once '../../class/servicio.php';

// Crear conexión
$database = new Database();
$db = $database->getConnection();

// Instanciar objeto
$servicio = new Servicio($db);

// Obtener datos JSON
$data = json_decode(file_get_contents("php://input"));

// Validar datos
if (
    !empty($data->id) &&
    !empty($data->nombre) &&
    !empty($data->descripcion) &&
    !empty($data->precio) &&
    !empty($data->duracion_estimada) &&
    !empty($data->tecnico_encargado)
) {
    // Asignar valores
    $servicio->id = $data->id;
    $servicio->nombre = $data->nombre;
    $servicio->descripcion = $data->descripcion;
    $servicio->precio = $data->precio;
    $servicio->duracion_estimada = $data->duracion_estimada;
    $servicio->tecnico_encargado = $data->tecnico_encargado;

    // Actualizar registro
    if ($servicio->update()) {
        http_response_code(200);
        echo json_encode(["message" => "✅ Servicio actualizado correctamente."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "❌ No se pudo actualizar el servicio."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "⚠️ Datos incompletos."]);
}
?>
