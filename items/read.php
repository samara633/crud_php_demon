<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../class/items.php';

$database = new Database();
$db = $database->getConnection();
$item = new Items($db);

$item->id = isset($_GET['id']) ? $_GET['id'] : null;
$result = $item->read();

if($result->num_rows > 0){
    $items = ["records" => []];
    while($row = $result->fetch_assoc()){
        array_push($items["records"], $row);
    }
    echo json_encode($items);
} else {
    echo json_encode(["message" => "No se encontraron registros"]);
}
?>
