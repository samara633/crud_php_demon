<?php
class Servicio {
    private $conn;
    private $table_name = "servicios";

    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $duracion_estimada;
    public $tecnico_encargado;
    public $fecha_creacion;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear servicio
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET nombre=:nombre, descripcion=:descripcion, precio=:precio,
                      duracion_estimada=:duracion_estimada, tecnico_encargado=:tecnico_encargado,
                      fecha_creacion=:fecha_creacion";

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->duracion_estimada = htmlspecialchars(strip_tags($this->duracion_estimada));
        $this->tecnico_encargado = htmlspecialchars(strip_tags($this->tecnico_encargado));
        $this->fecha_creacion = htmlspecialchars(strip_tags($this->fecha_creacion));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":duracion_estimada", $this->duracion_estimada);
        $stmt->bindParam(":tecnico_encargado", $this->tecnico_encargado);
        $stmt->bindParam(":fecha_creacion", $this->fecha_creacion);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Leer servicios
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY fecha_creacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Actualizar servicio
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET nombre = :nombre, descripcion = :descripcion, precio = :precio,
                      duracion_estimada = :duracion_estimada, tecnico_encargado = :tecnico_encargado
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->duracion_estimada = htmlspecialchars(strip_tags($this->duracion_estimada));
        $this->tecnico_encargado = htmlspecialchars(strip_tags($this->tecnico_encargado));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":duracion_estimada", $this->duracion_estimada);
        $stmt->bindParam(":tecnico_encargado", $this->tecnico_encargado);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar servicio
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
