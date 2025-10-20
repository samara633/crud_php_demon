<?php
// Cabeceras para permitir el acceso desde Postman u otros clientes
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir la conexión a la base de datos y la clase del modelo
include_once '../config/Database.php';
include_once '../class/Items.php';

// Conexión con la base de datos
$database = new Database();
$db = $database->getConnection();

// Crear objeto producto
$producto = new Items($db);

// Obtener los datos enviados por método PUT en formato JSON
$data = json_decode(file_get_contents("php://input"));

// Validar que los campos requeridos estén presentes
if(
    !empty($data->id) &&
    !empty($data->nombre) &&
    !empty($data->descripcion) &&
    !empty($data->precio) &&
    !empty($data->categoria_id) &&
    !empty($data->fecha_creacion)
){
    // Asignar los valores al objeto producto
    $producto->id = $data->id;
    $producto->nombre = $data->nombre;
    $producto->descripcion = $data->descripcion;
    $producto->precio = $data->precio;
    $producto->categoria_id = $data->categoria_id;
    $producto->fecha_creacion = $data->fecha_creacion;

    // Ejecutar la actualización
    if($producto->update()){
        http_response_code(200);
        echo json_encode(array("message" => "✅ Producto actualizado correctamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "❌ Error: no se pudo actualizar el producto."));
    }
}
else {
    // Faltan datos
    http_response_code(400);
    echo json_encode(array("message" => "⚠️ No se pudo actualizar el producto. Datos incompletos."));
}
?>
