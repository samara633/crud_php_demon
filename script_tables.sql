use php_demo;

-- 🧱 TABLA DE CATEGORÍAS
CREATE TABLE categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  tipo ENUM('producto', 'servicio') NOT NULL,
  descripcion TEXT
);

-- 💻 TABLA DE PRODUCTOS
CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  descripcion TEXT NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  stock INT DEFAULT 0,
  imagen_url VARCHAR(255),
  categoria_id INT,
  fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
  fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- 🧰 TABLA DE SERVICIOS
CREATE TABLE servicios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  descripcion TEXT NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  duracion_estimada VARCHAR(50), -- Ejemplo: "2 horas"
  categoria_id INT,
  imagen_url VARCHAR(255),
  fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
  fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

CREATE TABLE servicios (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL,
  descripcion TEXT NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  duracion_estimada VARCHAR(100) NOT NULL,
  tecnico_encargado VARCHAR(255) DEFAULT NULL,
  fecha_creacion DATETIME NOT NULL,
  fecha_modificacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);


-- 👤 TABLA DE USUARIOS
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(150) UNIQUE NOT NULL,
  contrasena VARCHAR(255) NOT NULL,
  rol ENUM('cliente', 'admin') DEFAULT 'cliente',
  fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 🛒 TABLA DE PEDIDOS
CREATE TABLE pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT,
  tipo ENUM('producto', 'servicio') NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  estado ENUM('pendiente', 'pagado', 'cancelado') DEFAULT 'pendiente',
  fecha_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- 🔗 DETALLES DE LOS PEDIDOS
CREATE TABLE detalle_pedido (
  id INT AUTO_INCREMENT PRIMARY KEY,
  pedido_id INT,
  producto_id INT NULL,
  servicio_id INT NULL,
  cantidad INT DEFAULT 1,
  subtotal DECIMAL(10,2),
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
  FOREIGN KEY (producto_id) REFERENCES productos(id),
  FOREIGN KEY (servicio_id) REFERENCES servicios(id)
);

select * from productos;


