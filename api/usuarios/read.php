<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../class/usuario.php';

$database = new Database();
$db = $database->getConnection();

$items = new Usuario($db);
$stmt = $items->read();
$itemCount = $stmt->rowCount();

if ($itemCount > 0) {
    $usuariosArr = [];
    $usuariosArr["body"] = [];
    $usuariosArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = [
            "id" => $id,
            "nombre" => $nombre,
            "correo" => $correo,
            "telefono" => $telefono,
            "direccion" => $direccion,
            "rol" => $rol,
            "fecha_creacion" => $fecha_creacion,
            "fecha_modificacion" => $fecha_modificacion
        ];
        array_push($usuariosArr["body"], $e);
    }

    echo json_encode($usuariosArr);
} else {
    echo json_encode(["message" => "No se encontraron usuarios."]);
}
?>
