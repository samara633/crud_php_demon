<?php
// Encabezados HTTP
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Incluir archivos necesarios
include_once '../../config/database.php';
include_once '../../class/servicio.php';

// Crear conexión con la base de datos
$database = new Database();
$db = $database->getConnection();

// Instanciar objeto Servicio
$servicio = new Servicio($db);

// Obtener servicios
$stmt = $servicio->read();
$num = $stmt->rowCount();

// Verificar si hay registros
if ($num > 0) {
    $servicios_arr = [];
    $servicios_arr["records"] = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $servicio_item = [
            "id" => $id,
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "precio" => $precio,
            "duracion_estimada" => $duracion_estimada,
            "tecnico_encargado" => $tecnico_encargado,
            "fecha_creacion" => $fecha_creacion,
            "fecha_modificacion" => $fecha_modificacion
        ];

        array_push($servicios_arr["records"], $servicio_item);
    }

    // Código 200 OK
    http_response_code(200);
    echo json_encode($servicios_arr);
} else {
    http_response_code(404);
    echo json_encode(["message" => "⚠️ No hay servicios registrados."]);
}
?>
