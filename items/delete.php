<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");

include_once '../config/database.php';
include_once '../class/items.php';

$database = new Database();
$db = $database->getConnection();
$item = new Items($db);

$data = json_decode(file_get_contents("php://input"));
if(!empty($data->id)){
    $item->id = $data->id;
    if($item->delete()){
        echo json_encode(["message" => "Item eliminado correctamente"]);
    } else {
        echo json_encode(["message" => "No se pudo eliminar el item"]);
    }
} else {
    echo json_encode(["message" => "Falta el ID"]);
}
?>
