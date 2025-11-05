<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
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

    if ($item->delete()) {
        echo json_encode(["message" => "Usuario eliminado correctamente."]);
    } else {
        echo json_encode(["message" => "No se pudo eliminar el usuario."]);
    }
} else {
    echo json_encode(["message" => "Falta el ID del usuario."]);
}
?>
