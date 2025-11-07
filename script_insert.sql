INSERT INTO categorias (nombre, tipo, descripcion) VALUES
('Componentes', 'producto', 'Partes internas de computadoras'),
('Periféricos', 'producto', 'Dispositivos externos de entrada/salida'),
('Mantenimiento', 'servicio', 'Servicios técnicos de reparación y optimización'),
('Software', 'servicio', 'Instalación y configuración de programas');

INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen_url) VALUES
('Memoria RAM DDR4 8GB', 'RAM DDR4 para laptop o PC', 120000, 25, 1, 'img/ram8gb.jpg'),
('Disco SSD 480GB', 'Disco sólido rápido y confiable', 230000, 15, 1, 'img/ssd480.jpg'),
('Mouse inalámbrico Logitech', 'Mouse ergonómico con receptor USB', 65000, 30, 2, 'img/mouse.jpg');


INSERT INTO servicios (nombre, descripcion, precio, duracion_estimada, categoria_id, imagen_url) VALUES
('Mantenimiento correctivo', 'Limpieza, reparación de fallas físicas o de software', 80000, '2 horas', 3, 'img/mant_correctivo.jpg'),
('Cambio de software', 'Instalación o actualización del sistema operativo', 90000, '1 hora', 4, 'img/software.jpg'),
('Implementación de Office 365', 'Configuración de cuentas y licencias de Office', 100000, '1 hora y 30 min', 4, 'img/office365.jpg');


ALTER TABLE usuarios
ADD COLUMN telefono VARCHAR(255) DEFAULT NULL AFTER fecha_registro;


DESCRIBE detalle_pedido;

INSERT INTO detalle_pedido (pedido_id, producto_id, servicio_id, cantidad, subtotal)
VALUES
(1, 1, NULL, 2, 240000.00); 


INSERT INTO usuarios (nombre, correo, contrasena, rol, fecha_registro, telefono) VALUES
('Juan Pérez', 'juan.perez@example.com', '123456', 'admin',   '2025-01-15 09:15:00', '3156954123'),
('María Rodríguez', 'maria.rod@example.com', '123456', 'admin', '2025-02-10 11:45:20', '3156954123'),
('Carlos Gómez', 'carlos.gomez@example.com', '123456', 'cliente', '2025-03-05 18:32:10', '3156954123'),
('Laura Sánchez', 'laura.san@example.com', '123456', 'cliente', '2025-04-01 07:25:55', '3156954123');

UPDATE pedidos p
JOIN (
  SELECT pedido_id, SUM(subtotal) AS total
  FROM detalle_pedido
  GROUP BY pedido_id
) dp ON p.id = dp.pedido_id
SET p.total = dp.total;

INSERT INTO detalle_pedido (pedido_id, producto_id, servicio_id, cantidad, subtotal) VALUES
(4, 1, NULL, 2, 240000.00),
(5, NULL, 1, 1, 80000.00),
(6, 2, NULL, 1, 230000.00);

select * from pedidos;

INSERT INTO pedidos (usuario_id, tipo, total, estado, fecha_pedido)
VALUES
(5, 'producto', 240000.00, 'pagado',   '2025-01-16 10:45:00'),
(6, 'servicio', 80000.00, 'pendiente', '2025-02-12 14:20:00'),
(7, 'producto', 230000.00, 'pagado',   '2025-03-01 09:32:00');

INSERT INTO usuarios (id, nombre, email, telefono, direccion, rol, fecha_registro)
VALUES
(1, 'Carlos Pérez', 'carlos@example.com', '3001234567', 'Calle 1 #12-34', 'cliente', NOW()),
(3, 'Laura Ríos', 'laura@example.com', '3115672345', 'Carrera 8 #45-22', 'cliente', NOW()),
(4, 'Andrés Gómez', 'andres@example.com', '3209987744', 'Cra 15 #92-15', 'cliente', NOW());



describe usuarios;

select * from usuarios;


