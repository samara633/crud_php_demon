<?php
// Encabezados HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Incluir archivos necesarios
include_once '../../config/database.php';
include_once '../../class/producto.php';

// Crear conexión con la base de datos
$database = new Database();
$db = $database->getConnection();

// Instanciar objeto producto
$producto = new Producto($db);

// Obtener productos
$stmt = $producto->read();
$num = $stmt->rowCount();

// Verificar si hay productos
if ($num > 0) {
    $productos_arr = [];
    $productos_arr["records"] = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $producto_item = [
            "id" => $id,
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "precio" => $precio,
            "stock" => $stock,
            "imagen_url" => $imagen_url,
            "categoria" => $categoria_nombre,
            "fecha_creacion" => $fecha_creacion,
            "fecha_modificacion" => $fecha_modificacion
        ];

        array_push($productos_arr["records"], $producto_item);
    }

    // Código 200 OK
    http_response_code(200);
    echo json_encode($productos_arr);
} else {
    http_response_code(404);
    echo json_encode(["message" => "⚠️ No hay productos disponibles."]);
}
?>
