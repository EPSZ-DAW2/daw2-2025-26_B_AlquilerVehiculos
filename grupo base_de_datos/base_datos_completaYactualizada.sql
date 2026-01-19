-- ======================================================
-- 1. CREACIÓN DE LA BASE DE DATOS Y TABLAS MAESTRAS
-- ======================================================
CREATE DATABASE IF NOT EXISTS gestion_alquiler;
USE gestion_alquiler;

-- Tabla de Categorías
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre_grupo VARCHAR(50) NOT NULL, -- Económico, SUV, Lujo
    precio_dia DECIMAL(10,2) NOT NULL
);

-- Tabla de Vehículos con soporte para Baja Lógica
CREATE TABLE vehiculos (
    id_vehiculo INT AUTO_INCREMENT PRIMARY KEY,
    matricula VARCHAR(15) UNIQUE NOT NULL,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    id_categoria INT,
    estado ENUM('Activo', 'Taller', 'Alquilado', 'Baja') DEFAULT 'Activo',
    fecha_baja_logica DATETIME DEFAULT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
);

-- Tabla de Usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('Admin', 'Cliente') DEFAULT 'Cliente',
    num_carnet_conducir VARCHAR(50),
    es_estudiante BOOLEAN DEFAULT FALSE -- Campo nuevo para descuentos
);

-- NUEVA TABLA: Promociones y Descuentos
CREATE TABLE promociones (
    id_promocion INT AUTO_INCREMENT PRIMARY KEY,
    nombre_promo VARCHAR(100) NOT NULL,
    codigo_descuento VARCHAR(20) UNIQUE,
    porcentaje_descuento DECIMAL(5,2) NOT NULL, -- Ej: 15.00 (15%)
    es_para_estudiantes BOOLEAN DEFAULT FALSE,
    fecha_limite DATE
);

-- Tabla de Reservas Actualizada
CREATE TABLE reservas (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_vehiculo INT,
    id_promocion INT NULL, -- Relación con descuentos
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    coste_total DECIMAL(10,2),
    estado_reserva ENUM('Confirmada', 'Finalizada', 'Cancelada') DEFAULT 'Confirmada',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo),
    FOREIGN KEY (id_promocion) REFERENCES promociones(id_promocion)
);

-- NUEVA TABLA: Contratos (Gestión legal y cambios en el alquiler)
CREATE TABLE contratos (
    id_contrato INT AUTO_INCREMENT PRIMARY KEY,
    id_reserva INT UNIQUE,
    fecha_firma DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado_contrato ENUM('Vigente', 'Finalizado', 'Cancelado', 'Prorrogado') DEFAULT 'Vigente',
    fecha_devolucion_real DATETIME DEFAULT NULL,
    km_entrega INT,
    km_devolucion INT,
    FOREIGN KEY (id_reserva) REFERENCES reservas(id_reserva)
);

-- Tabla de Incidencias/Multas
CREATE TABLE multas_informes (
    id_informe INT AUTO_INCREMENT PRIMARY KEY,
    id_reserva INT,
    descripcion TEXT NOT NULL,
    fecha_incidencia DATE NOT NULL,
    importe_multa DECIMAL(10,2) DEFAULT 0.00,
    FOREIGN KEY (id_reserva) REFERENCES reservas(id_reserva)
);

-- ======================================================
-- 2. PROCEDIMIENTOS ALMACENADOS (LÓGICA DE NEGOCIO)
-- ======================================================
DELIMITER //

-- Registrar Reserva con validación de solapamiento
CREATE PROCEDURE sp_RegistrarReserva(
    IN p_id_usuario INT,
    IN p_id_vehiculo INT,
    IN p_f_inicio DATE,
    IN p_f_fin DATE,
    IN p_codigo_promo VARCHAR(20)
)
BEGIN
    DECLARE v_precio DECIMAL(10,2);
    DECLARE v_solapado INT;
    DECLARE v_id_promo INT DEFAULT NULL;
    DECLARE v_dto DECIMAL(5,2) DEFAULT 0;
    
    -- Validar disponibilidad
    SELECT COUNT(*) INTO v_solapado FROM reservas 
    WHERE id_vehiculo = p_id_vehiculo 
      AND estado_reserva = 'Confirmada'
      AND (p_f_inicio <= fecha_fin AND p_f_fin >= fecha_inicio);

    IF v_solapado > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Vehículo no disponible.';
    ELSE
        -- Buscar descuento si existe código
        SELECT id_promocion, porcentaje_descuento INTO v_id_promo, v_dto 
        FROM promociones WHERE codigo_descuento = p_codigo_promo AND fecha_limite >= CURDATE();

        -- Obtener precio base
        SELECT c.precio_dia INTO v_precio 
        FROM vehiculos v JOIN categorias c ON v.id_categoria = c.id_categoria 
        WHERE v.id_vehiculo = p_id_vehiculo;

        -- Insertar con el descuento aplicado
        INSERT INTO reservas (id_usuario, id_vehiculo, id_promocion, fecha_inicio, fecha_fin, coste_total)
        VALUES (p_id_usuario, p_id_vehiculo, v_id_promo, p_f_inicio, p_f_fin, 
               (DATEDIFF(p_f_fin, p_f_inicio) * v_precio) * (1 - v_dto/100));
        
        UPDATE vehiculos SET estado = 'Alquilado' WHERE id_vehiculo = p_id_vehiculo;
    END IF;
END //

-- NUEVO: Procedimiento para Prolongar Contrato
CREATE PROCEDURE sp_ProlongarContrato(
    IN p_id_contrato INT,
    IN p_nueva_fecha_fin DATE
)
BEGIN
    DECLARE v_reserva INT;
    SELECT id_reserva INTO v_reserva FROM contratos WHERE id_contrato = p_id_contrato;
    
    UPDATE reservas SET fecha_fin = p_nueva_fecha_fin WHERE id_reserva = v_reserva;
    UPDATE contratos SET estado_contrato = 'Prorrogado' WHERE id_contrato = p_id_contrato;
END //

-- NUEVO: Finalizar Contrato (Devolución)
CREATE PROCEDURE sp_FinalizarContrato(
    IN p_id_contrato INT,
    IN p_km_final INT
)
BEGIN
    DECLARE v_reserva INT;
    DECLARE v_coche INT;
    
    SELECT id_reserva INTO v_reserva FROM contratos WHERE id_contrato = p_id_contrato;
    SELECT id_vehiculo INTO v_coche FROM reservas WHERE id_reserva = v_reserva;

    UPDATE contratos SET estado_contrato = 'Finalizado', fecha_devolucion_real = NOW(), km_devolucion = p_km_final 
    WHERE id_contrato = p_id_contrato;
    
    UPDATE vehiculos SET estado = 'Activo' WHERE id_vehiculo = v_coche;
    UPDATE reservas SET estado_reserva = 'Finalizada' WHERE id_reserva = v_reserva;
END //

DELIMITER ;

-- ======================================================
-- 3. DATOS DE PRUEBA
-- ======================================================
INSERT INTO categorias (nombre_grupo, precio_dia) VALUES ('Económico', 35.00), ('SUV', 60.00), ('Lujo', 150.00);

INSERT INTO vehiculos (matricula, marca, modelo, id_categoria, estado) VALUES 
('ABC-1234', 'Toyota', 'Yaris', 1, 'Activo'),
('DEF-5678', 'BMW', 'X5', 3, 'Activo');

INSERT INTO promociones (nombre_promo, codigo_descuento, porcentaje_descuento, es_para_estudiantes, fecha_limite) 
VALUES ('Descuento Estudiante', 'ESTUDIANTE20', 20.00, TRUE, '2026-12-31');

INSERT INTO usuarios (nombre, email, password, rol, num_carnet_conducir, es_estudiante) VALUES 
('Admin Sistema', 'admin@cars.com', 'hash', 'Admin', 'ESP-000', FALSE),
('Juan Estudiante', 'juan@test.com', 'hash', 'Cliente', 'B-999', TRUE);