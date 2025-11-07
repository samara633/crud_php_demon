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

if($itemCount > 0){
    
    $userArr = array();
    $userArr["body"] = array();
    $userArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $e = array(
            "id" => $id,
            "nombre" => $nombre,
            "correo" => $correo,
            "rol" => $rol,
            "fecha_registro" => $fecha_registro,
            "telefono" => $telefono
        );

        array_push($userArr["body"], $e);
    }

    echo json_encode($userArr);
}
else{
    echo json_encode(
        array("message" => "No se encontraron usuarios.")
    );
}

