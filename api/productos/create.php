<?php
// Encabezados HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir archivos necesarios
include_once '../../config/database.php';
include_once '../../class/producto.php';

// Crear conexión con la base de datos
$database = new Database();
$db = $database->getConnection();

// Instanciar el objeto producto
$producto = new Producto($db);

// Obtener los datos enviados (JSON)
$data = json_decode(file_get_contents("php://input"));

// Validar que existan todos los campos obligatorios
if (
    !empty($data->nombre) &&
    !empty($data->descripcion) &&
    !empty($data->precio) &&
    !empty($data->stock) &&
    !empty($data->categoria_id)
) {
    // Asignar valores al objeto producto
    $producto->nombre = htmlspecialchars(strip_tags($data->nombre));
    $producto->descripcion = htmlspecialchars(strip_tags($data->descripcion));
    $producto->precio = $data->precio;
    $producto->stock = $data->stock;
    $producto->imagen_url = !empty($data->imagen_url) ? htmlspecialchars(strip_tags($data->imagen_url)) : null;
    $producto->categoria_id = $data->categoria_id;
    $producto->fecha_creacion = date('Y-m-d H:i:s');

    // Intentar crear el producto
    if ($producto->create()) {
        http_response_code(201);
        echo json_encode(["message" => "✅ Producto creado correctamente."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "❌ Error al crear el producto."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "⚠️ Datos incompletos."]);
}
?>
