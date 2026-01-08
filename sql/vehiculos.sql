-- -----------------------------------------------------
-- 1. ESTRUCTURA (Basado en 01_esqueleto.sql)
-- -----------------------------------------------------
DROP DATABASE IF EXISTS gestion_vehiculos;
CREATE DATABASE gestion_vehiculos;
USE gestion_vehiculos;

-- Categorías: Define el precio por día
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre_grupo VARCHAR(50) NOT NULL, -- Económico, SUV, Lujo
    precio_dia DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB;

-- Vehículos: Con soporte para Baja Lógica
CREATE TABLE vehiculos (
    id_vehiculo INT AUTO_INCREMENT PRIMARY KEY,
    matricula VARCHAR(15) UNIQUE NOT NULL,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    id_categoria INT,
    estado ENUM('Activo', 'Taller', 'Alquilado', 'Baja') DEFAULT 'Activo',
    fecha_baja_logica DATETIME DEFAULT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
) ENGINE=InnoDB;

-- Usuarios: Unifica Clientes y Admins (Requisito: Carnet)
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('Admin', 'Cliente') DEFAULT 'Cliente',
    num_carnet_conducir VARCHAR(50) -- Solo los clientes tendrán esto lleno
) ENGINE=InnoDB;

-- Reservas Y Contratos (Unificados para simplificar)
CREATE TABLE reservas (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_vehiculo INT,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    coste_total DECIMAL(10,2),
    estado_reserva ENUM('Confirmada', 'Finalizada', 'Cancelada') DEFAULT 'Confirmada',
    
    -- AGREGADO: Campos para cumplir el requisito de "Contrato"
    km_entrega INT DEFAULT 0,  -- Km cuando se lleva el coche
    km_devolucion INT DEFAULT NULL, -- Km cuando lo devuelve
    observaciones_contrato TEXT,
    
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo)
) ENGINE=InnoDB;

-- Multas e Informes Policiales
CREATE TABLE multas_informes (
    id_informe INT AUTO_INCREMENT PRIMARY KEY,
    id_reserva INT,
    descripcion TEXT NOT NULL,
    fecha_incidencia DATE NOT NULL,
    importe_multa DECIMAL(10,2) DEFAULT 0.00,
    FOREIGN KEY (id_reserva) REFERENCES reservas(id_reserva)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- 2. PROCEDIMIENTOS (Usando la versión MEJORADA)
-- -----------------------------------------------------
DELIMITER //

CREATE PROCEDURE sp_RegistrarReserva(
    IN p_id_usuario INT,
    IN p_id_vehiculo INT,
    IN p_f_inicio DATE,
    IN p_f_fin DATE
)
BEGIN
    DECLARE v_precio DECIMAL(10,2);
    DECLARE v_solapado INT;
    
    -- Detecta si el coche ya está ocupado en esas fechas
    SELECT COUNT(*) INTO v_solapado FROM reservas 
    WHERE id_vehiculo = p_id_vehiculo 
      AND estado_reserva = 'Confirmada'
      AND (p_f_inicio <= fecha_fin AND p_f_fin >= fecha_inicio);

    IF v_solapado > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Vehículo no disponible en esas fechas.';
    ELSE
        -- Obtener precio
        SELECT c.precio_dia INTO v_precio 
        FROM vehiculos v JOIN categorias c ON v.id_categoria = c.id_categoria 
        WHERE v.id_vehiculo = p_id_vehiculo;

        -- Crear la reserva
        INSERT INTO reservas (id_usuario, id_vehiculo, fecha_inicio, fecha_fin, coste_total)
        VALUES (p_id_usuario, p_id_vehiculo, p_f_inicio, p_f_fin, (DATEDIFF(p_f_fin, p_f_inicio) * v_precio));
        
        -- Marcar coche como alquilado
        UPDATE vehiculos SET estado = 'Alquilado' WHERE id_vehiculo = p_id_vehiculo;
    END IF;
END //

CREATE PROCEDURE sp_BajaVehiculo(IN p_id INT)
BEGIN
    UPDATE vehiculos 
    SET estado = 'Baja', fecha_baja_logica = NOW() 
    WHERE id_vehiculo = p_id;
END //

DELIMITER ;

-- -----------------------------------------------------
-- 3. DATOS DE PRUEBA (04_datos_prueba.sql)
-- -----------------------------------------------------
INSERT INTO categorias (nombre_grupo, precio_dia) VALUES 
('Económico', 35.00), ('SUV', 60.00), ('Lujo', 150.00);

INSERT INTO vehiculos (matricula, marca, modelo, id_categoria, estado) VALUES 
('ABC-1234', 'Toyota', 'Yaris', 1, 'Activo'),
('DEF-5678', 'BMW', 'X5', 3, 'Activo'),
('GHI-9012', 'Seat', 'Arona', 2, 'Taller');

INSERT INTO usuarios (nombre, email, password, rol, num_carnet_conducir) VALUES 
('Admin Sistema', 'admin@cars.com', 'admin_hash', 'Admin', 'ESP-000'),
('Cliente Prueba', 'cliente@test.com', 'user_hash', 'Cliente', 'B-12345678');