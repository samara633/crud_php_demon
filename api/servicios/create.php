<?php
// Encabezados HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir archivos de configuración y clase
include_once '../../config/database.php';
include_once '../../class/servicio.php';

// Instancia de base de datos y conexión
$database = new Database();
$db = $database->getConnection();

// Instanciar objeto Servicio
$servicio = new Servicio($db);

// Obtener datos recibidos en formato JSON
$data = json_decode(file_get_contents("php://input"));

// Validar que existan los campos requeridos
if (
    !empty($data->nombre) &&
    !empty($data->descripcion) &&
    !empty($data->precio) &&
    !empty($data->duracion_estimada) &&
    !empty($data->tecnico_encargado)
) {
    // Asignar valores
    $servicio->nombre = $data->nombre;
    $servicio->descripcion = $data->descripcion;
    $servicio->precio = $data->precio;
    $servicio->duracion_estimada = $data->duracion_estimada;
    $servicio->tecnico_encargado = $data->tecnico_encargado;
    $servicio->fecha_creacion = date('Y-m-d H:i:s');

    // Crear servicio
    if ($servicio->create()) {
        http_response_code(201);
        echo json_encode(["message" => "✅ Servicio creado correctamente."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "❌ No se pudo crear el servicio."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "⚠️ Datos incompletos."]);
}
?>
