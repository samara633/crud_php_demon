<?php
// pedido.php - CRUD básico para pedidos

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $query = "SELECT * FROM pedidos";
        $stmt = $db->prepare($query);
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $query = "INSERT INTO pedidos (usuario_id, tipo, total) VALUES (:cliente, :producto, :cantidad)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':cliente', $data->cliente);
        $stmt->bindParam(':producto', $data->producto);
        $stmt->bindParam(':cantidad', $data->cantidad);
        if ($stmt->execute()) {
            echo json_encode(["message" => "Pedido creado correctamente"]);
        } else {
            echo json_encode(["message" => "Error al crear el pedido"]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $query = "UPDATE pedidos SET cliente=:cliente, producto=:producto, cantidad=:cantidad WHERE id=:id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $data->id);
        $stmt->bindParam(':cliente', $data->cliente);
        $stmt->bindParam(':producto', $data->producto);
        $stmt->bindParam(':cantidad', $data->cantidad);
        if ($stmt->execute()) {
            echo json_encode(["message" => "Pedido actualizado"]);
        } else {
            echo json_encode(["message" => "Error al actualizar"]);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $query = "DELETE FROM pedidos WHERE id=:id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $data->id);
        if ($stmt->execute()) {
            echo json_encode(["message" => "Pedido eliminado"]);
        } else {
            echo json_encode(["message" => "Error al eliminar"]);
        }
        break;

    default:
        echo json_encode(["message" => "Método no permitido"]);
        break;
}
?>