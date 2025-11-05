<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../class/usuario.php';

$database = new Database();
$db = $database->getConnection();

$item = new Usuario($db);
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $item->id = $data->id;
    $item->nombre = $data->nombre ?? null;
    $item->correo = $data->correo ?? null;
    $item->telefono = $data->telefono ?? null;
    $item->direccion = $data->direccion ?? null;
    $item->rol = $data->rol ?? 'cliente';

    if ($item->update()) {
        echo json_encode(["message" => "Usuario actualizado correctamente."]);
    } else {
        echo json_encode(["message" => "No se pudo actualizar el usuario."]);
    }
} else {
    echo json_encode(["message" => "Falta el ID del usuario."]);
}
?>
