<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nombre;
    public $correo;
    public $contrasena;
    public $rol;
    public $fecha_registro;
    public $telefono;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear usuario
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET nombre = :nombre,
                      correo = :correo,
                      contrasena = :contrasena,
                      rol = :rol,
                      telefono = :telefono";

        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->rol = htmlspecialchars(strip_tags($this->rol));

        // Encriptar contraseña
        $this->contrasena = password_hash($this->contrasena, PASSWORD_BCRYPT);

        // Enlazar parámetros
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":contrasena", $this->contrasena);
        $stmt->bindParam(":rol", $this->rol);
        $stmt->bindParam(":telefono", $this->telefono);

        return $stmt->execute();
    }

    // Leer todos los usuarios
    public function read() {
    $query = "SELECT id, nombre, correo, rol, fecha_registro, telefono
              FROM " . $this->table_name . "
              ORDER BY fecha_registro DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}

    // Actualizar usuario
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET nombre = :nombre,
                      correo = :correo,
                      telefono = :telefono,
                      rol = :rol
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->rol = htmlspecialchars(strip_tags($this->rol));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":rol", $this->rol);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    // Eliminar usuario
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        return $stmt->execute();
    }
}
?>

