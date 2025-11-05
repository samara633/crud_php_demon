<?php
// Encabezados HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir archivos necesarios
include_once '../../config/database.php';
include_once '../../class/producto.php';

// Crear conexión con la base de datos
$database = new Database();
$db = $database->getConnection();

// Instanciar objeto producto
$producto = new Producto($db);

// Obtener los datos del cuerpo de la solicitud (JSON)
$data = json_decode(file_get_contents("php://input"));

// Verificar que se haya enviado el ID
if (!empty($data->id)) {
    $producto->id = $data->id;

    // Intentar eliminar
    if ($producto->delete()) {
        http_response_code(200);
        echo json_encode(["message" => "✅ Producto eliminado correctamente."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "❌ No se pudo eliminar el producto."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "⚠️ ID del producto no proporcionado."]);
}
?>
