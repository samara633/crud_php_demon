<?php
class Producto {
    private $conn;
    private $table_name = "productos";

    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $stock;
    public $imagen_url;
    public $categoria_id;
    public $fecha_creacion;
    public $fecha_modificacion;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear producto
    public function create() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET nombre=:nombre, descripcion=:descripcion, precio=:precio,
                      stock=:stock, imagen_url=:imagen_url, categoria_id=:categoria_id,
                      fecha_creacion=:fecha_creacion";

        $stmt = $this->conn->prepare($query);

        // Limpiar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        $this->imagen_url = htmlspecialchars(strip_tags($this->imagen_url));
        $this->categoria_id = htmlspecialchars(strip_tags($this->categoria_id));
        $this->fecha_creacion = htmlspecialchars(strip_tags($this->fecha_creacion));

        // Asignar valores
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":precio", $this->precio);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":imagen_url", $this->imagen_url);
        $stmt->bindParam(":categoria_id", $this->categoria_id);
        $stmt->bindParam(":fecha_creacion", $this->fecha_creacion);

        // Ejecutar
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Eliminar producto
public function delete() {
    $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    // Limpiar y vincular ID
    $this->id = htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(":id", $this->id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

// Leer todos los productos
public function read() {
    $query = "SELECT 
                p.id, 
                p.nombre, 
                p.descripcion, 
                p.precio, 
                p.stock, 
                p.imagen_url, 
                c.nombre AS categoria_nombre, 
                p.fecha_creacion, 
                p.fecha_modificacion
              FROM " . $this->table_name . " p
              LEFT JOIN categorias c ON p.categoria_id = c.id
              ORDER BY p.fecha_creacion DESC";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}


// Actualizar producto
public function update() {
    $query = "UPDATE " . $this->table_name . "
              SET 
                nombre = :nombre,
                descripcion = :descripcion,
                precio = :precio,
                stock = :stock,
                imagen_url = :imagen_url,
                categoria_id = :categoria_id
              WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    // Limpiar datos
    $this->nombre = htmlspecialchars(strip_tags($this->nombre));
    $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
    $this->precio = htmlspecialchars(strip_tags($this->precio));
    $this->stock = htmlspecialchars(strip_tags($this->stock));
    $this->imagen_url = htmlspecialchars(strip_tags($this->imagen_url));
    $this->categoria_id = htmlspecialchars(strip_tags($this->categoria_id));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Asignar parámetros
    $stmt->bindParam(":nombre", $this->nombre);
    $stmt->bindParam(":descripcion", $this->descripcion);
    $stmt->bindParam(":precio", $this->precio);
    $stmt->bindParam(":stock", $this->stock);
    $stmt->bindParam(":imagen_url", $this->imagen_url);
    $stmt->bindParam(":categoria_id", $this->categoria_id);
    $stmt->bindParam(":id", $this->id);

    // Ejecutar
    if ($stmt->execute()) {
        return true;
    }
    return false;
}


}
?>
