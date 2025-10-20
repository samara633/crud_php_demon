<?php
// Cabeceras para permitir peticiones desde Postman o navegadores
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir la conexión y la clase del modelo
include_once '../config/Database.php';
include_once '../class/Items.php';

// Crear conexión con la base de datos
$database = new Database();
$db = $database->getConnection();

// Crear instancia del objeto producto
$producto = new Items($db);

// Recibir los datos enviados en formato JSON
$data = json_decode(file_get_contents("php://input"));

// Validar que todos los campos obligatorios vengan en el JSON
if(
    !empty($data->nombre) &&
    !empty($data->descripcion) &&
    !empty($data->precio) &&
    !empty($data->categoria_id) &&
    !empty($data->fecha_creacion)
){
    // Asignar los valores al objeto
    $producto->nombre = $data->nombre;
    $producto->descripcion = $data->descripcion;
    $producto->precio = $data->precio;
    $producto->categoria_id = $data->categoria_id;
    $producto->fecha_creacion = $data->fecha_creacion;

    // Intentar crear el registro en la base de datos
    if($producto->create()){
        http_response_code(201);
        echo json_encode(array("message" => "✅ Producto creado exitosamente."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "❌ Error: no se pudo crear el producto."));
    }
}
else {
    // Si falta algún dato, devolver error
    http_response_code(400);
    echo json_encode(array("message" => "⚠️ No se pudo crear el producto. Datos incompletos."));
}
?>
