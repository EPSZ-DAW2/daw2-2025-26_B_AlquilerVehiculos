--eso es para que mis companeros Héctor y Kailun puedan ver cómo quedan sus diseños con datos reales
-- Datos para que Diseño y Frontend visualicen la flota 
INSERT INTO categorias (nombre_grupo, precio_dia) VALUES ('Económico', 35.00), ('SUV', 60.00), ('Lujo', 150.00);

INSERT INTO vehiculos (matricula, marca, modelo, id_categoria, estado) VALUES 
('ABC-1234', 'Toyota', 'Yaris', 1, 'Activo'),
('DEF-5678', 'BMW', 'X5', 3, 'Activo'),
('GHI-9012', 'Seat', 'Arona', 2, 'Taller');

INSERT INTO usuarios (nombre, email, password, rol, num_carnet_conducir) VALUES 
('Admin Sistema', 'admin@cars.com', 'admin_hash', 'Admin', 'ESP-000'),
('Cliente Prueba', 'cliente@test.com', 'user_hash', 'Cliente', 'B-12345678');