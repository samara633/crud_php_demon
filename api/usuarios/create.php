<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../class/usuario.php';

$database = new Database();
$db = $database->getConnection();

$item = new Usuario($db);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->nombre) &&
    !empty($data->correo) &&
    !empty($data->contrasena)
) {
    $item->nombre = $data->nombre;
    $item->correo = $data->correo;
    $item->telefono = $data->telefono ?? null;
    $item->rol = $data->rol ?? 'cliente';
    $item->contrasena = $data->contrasena;

    if ($item->create()) {
        echo json_encode(["message" => "Usuario creado correctamente."]);
    } else {
        echo json_encode(["message" => "Error al crear el usuario."]);
    }
} else {
    echo json_encode(["message" => "Datos incompletos."]);
}
?>

