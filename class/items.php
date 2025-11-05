<?php
class Items {
    // Conexión y nombre de la tabla
    private $conn;
    private $itemsTable = "productos";

    // Propiedades del producto
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $categoria_id;
    public $fecha_creacion;

    // Constructor con la conexión a la base de datos
    public function __construct($db){
        $this->conn = $db;
    }

    // 🟢 CREAR PRODUCTO
    function create(){
        $stmt = $this->conn->prepare("
            INSERT INTO ".$this->itemsTable."(`nombre`, `descripcion`, `precio`, `categoria_id`, `fecha_creacion`)
            VALUES(?,?,?,?,?)");

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->categoria_id = htmlspecialchars(strip_tags($this->categoria_id));
        $this->fecha_creacion = htmlspecialchars(strip_tags($this->fecha_creacion));

        $stmt->bind_param("ssiis", 
            $this->nombre, 
            $this->descripcion, 
            $this->precio, 
            $this->categoria_id, 
            $this->fecha_creacion
        );

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // 🔵 LEER PRODUCTOS (todos o uno por ID)
    function read(){
        if($this->id){
            $stmt = $this->conn->prepare("SELECT * FROM ".$this->itemsTable." WHERE id = ?");
            $stmt->bind_param("i", $this->id);
        } else {
            $stmt = $this->conn->prepare("SELECT * FROM ".$this->itemsTable);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    // 🟠 ACTUALIZAR PRODUCTO
    function update(){
        $stmt = $this->conn->prepare("
            UPDATE ".$this->itemsTable." 
            SET nombre = ?, descripcion = ?, precio = ?, categoria_id = ?, fecha_creacion = ?
            WHERE id = ?");

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->categoria_id = htmlspecialchars(strip_tags($this->categoria_id));
        $this->fecha_creacion = htmlspecialchars(strip_tags($this->fecha_creacion));

        $stmt->bind_param("ssiisi", 
            $this->nombre, 
            $this->descripcion, 
            $this->precio, 
            $this->categoria_id, 
            $this->fecha_creacion, 
            $this->id
        );

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // 🔴 ELIMINAR PRODUCTO
    function delete(){
        $stmt = $this->conn->prepare("DELETE FROM ".$this->itemsTable." WHERE id = ?");
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bind_param("i", $this->id);
        
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
?>
