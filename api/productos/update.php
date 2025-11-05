<?php
// Encabezados HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir archivos necesarios
include_once '../../config/database.php';
include_once '../../class/producto.php';

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Instanciar objeto producto
$producto = new Producto($db);

// Obtener los datos del cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"));

// Verificar que haya un ID y los campos necesarios
if (
    !empty($data->id) &&
    !empty($data->nombre) &&
    !empty($data->descripcion) &&
    !empty($data->precio) &&
    isset($data->stock) &&
    !empty($data->categoria_id)
) {
    // Asignar valores al objeto
    $producto->id = $data->id;
    $producto->nombre = htmlspecialchars(strip_tags($data->nombre));
    $producto->descripcion = htmlspecialchars(strip_tags($data->descripcion));
    $producto->precio = $data->precio;
    $producto->stock = $data->stock;
    $producto->imagen_url = !empty($data->imagen_url) ? htmlspecialchars(strip_tags($data->imagen_url)) : null;
    $producto->categoria_id = $data->categoria_id;

    // Intentar actualizar
    if ($producto->update()) {
        http_response_code(200);
        echo json_encode(["message" => "✅ Producto actualizado correctamente."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "❌ No se pudo actualizar el producto."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "⚠️ Datos incompletos para la actualización."]);
}
?>
