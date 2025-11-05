<?php
// Encabezados HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir archivos
include_once '../../config/database.php';
include_once '../../class/servicio.php';

// Conexión
$database = new Database();
$db = $database->getConnection();

// Instanciar objeto
$servicio = new Servicio($db);

// Obtener datos JSON
$data = json_decode(file_get_contents("php://input"));

// Validar que tenga id
if (!empty($data->id)) {
    $servicio->id = $data->id;

    if ($servicio->delete()) {
        http_response_code(200);
        echo json_encode(["message" => "🗑️ Servicio eliminado correctamente."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "❌ No se pudo eliminar el servicio."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "⚠️ Falta el ID del servicio."]);
}
?>
