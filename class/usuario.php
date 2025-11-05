<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nombre;
    public $correo;
    public $telefono;
    public $direccion;
    public $rol;
    public $contraseña;
    public $fecha_creacion;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear usuario
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET nombre=:nombre, correo=:correo, telefono=:telefono,
                      direccion=:direccion, rol=:rol, contraseña=:contraseña, fecha_creacion=:fecha_creacion";

        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->rol = htmlspecialchars(strip_tags($this->rol));
        $this->contraseña = password_hash($this->contraseña, PASSWORD_BCRYPT);
        $this->fecha_creacion = htmlspecialchars(strip_tags($this->fecha_creacion));

        // Enlazar parámetros
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":direccion", $this->direccion);
        $stmt->bindParam(":rol", $this->rol);
        $stmt->bindParam(":contraseña", $this->contraseña);
        $stmt->bindParam(":fecha_creacion", $this->fecha_creacion);

        return $stmt->execute();
    }

    // Leer todos los usuarios
    public function read() {
        $query = "SELECT id, nombre, correo, telefono, direccion, rol, fecha_creacion, fecha_modificacion
                  FROM " . $this->table_name . "
                  ORDER BY fecha_creacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Actualizar usuario
    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET nombre=:nombre, correo=:correo, telefono=:telefono, direccion=:direccion, rol=:rol
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->rol = htmlspecialchars(strip_tags($this->rol));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":direccion", $this->direccion);
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
