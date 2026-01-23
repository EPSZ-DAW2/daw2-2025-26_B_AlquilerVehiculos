DROP DATABASE IF EXISTS gestion_alquiler;
CREATE DATABASE gestion_alquiler CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gestion_alquiler;

CREATE TABLE categorias (
	id_categoria INT AUTO_INCREMENT PRIMARY KEY,
	nombre_grupo VARCHAR(50) NOT NULL,
	precio_dia DECIMAL(10,2) NOT NULL
);

CREATE TABLE vehiculos (
	id_vehiculo INT AUTO_INCREMENT PRIMARY KEY,
	matricula VARCHAR(15) UNIQUE NOT NULL,
	marca VARCHAR(50) NOT NULL,
	modelo VARCHAR(50) NOT NULL,
	id_categoria INT,
	estado ENUM('Activo', 'Taller', 'Alquilado', 'Baja') DEFAULT 'Activo',
	fecha_baja_logica DATETIME DEFAULT NULL,
	imagen_url VARCHAR(255) DEFAULT NULL,
	FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
);

CREATE TABLE usuarios (
	id_usuario INT AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(100) NOT NULL,
	email VARCHAR(100) UNIQUE NOT NULL,
	password VARCHAR(255) NOT NULL,
	edad INT(3) NOT NULL,
	rol ENUM('Admin', 'Cliente') DEFAULT 'Cliente',
	dni VARCHAR(50),
	menor_25 BOOLEAN DEFAULT FALSE,
	auth_key VARCHAR(32) DEFAULT NULL
);

CREATE TABLE promociones (
	id_promocion INT AUTO_INCREMENT PRIMARY KEY,
	nombre_promo VARCHAR(100) NOT NULL,
	codigo_descuento VARCHAR(20) UNIQUE,
	porcentaje_descuento DECIMAL(5,2) NOT NULL, 
	es_para_estudiantes BOOLEAN DEFAULT FALSE,
	fecha_limite DATE
);

CREATE TABLE extras (
	id_extra INT AUTO_INCREMENT PRIMARY KEY,
	concepto VARCHAR(100) NOT NULL,
	precio DECIMAL(10,2) NOT NULL,
	tipo_calculo ENUM('Por Dia', 'Fijo') DEFAULT 'Por Dia' 
);

CREATE TABLE reservas (
	id_reserva INT AUTO_INCREMENT PRIMARY KEY,
	id_usuario INT,
	id_vehiculo INT,
	id_promocion INT NULL,
	fecha_inicio DATE NOT NULL,
	fecha_fin DATE NOT NULL,
	coste_total DECIMAL(10,2) DEFAULT 0.00, 
	
	estado_reserva ENUM('Confirmada', 'Finalizada', 'Cancelada') DEFAULT 'Confirmada',
	fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
	
	FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
	FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo),
	FOREIGN KEY (id_promocion) REFERENCES promociones(id_promocion)
);

CREATE TABLE reserva_extras (
	id_res_extra INT AUTO_INCREMENT PRIMARY KEY,
	id_reserva INT NOT NULL,
	id_extra INT NOT NULL,
	cantidad INT DEFAULT 1,
	precio_unitario_aplicado DECIMAL(10,2) NOT NULL,
	total_linea DECIMAL(10,2) NOT NULL,
	FOREIGN KEY (id_reserva) REFERENCES reservas(id_reserva) ON DELETE CASCADE,
	FOREIGN KEY (id_extra) REFERENCES extras(id_extra)
);

CREATE TABLE contratos (
	id_contrato INT AUTO_INCREMENT PRIMARY KEY,
	id_reserva INT UNIQUE,
	fecha_firma DATETIME DEFAULT CURRENT_TIMESTAMP,
	estado_contrato ENUM('Vigente', 'Finalizado', 'Cancelado', 'Prorrogado') DEFAULT 'Vigente',
	fecha_devolucion_real DATETIME DEFAULT NULL,
	km_entrega INT DEFAULT 0,
	km_devolucion INT DEFAULT 0,
	FOREIGN KEY (id_reserva) REFERENCES reservas(id_reserva)
);

CREATE TABLE multas_informes (
	id_informe INT AUTO_INCREMENT PRIMARY KEY,
	id_reserva INT,
	descripcion TEXT NOT NULL,
	fecha_incidencia DATE NOT NULL,
	importe_multa DECIMAL(10,2) DEFAULT 0.00,
	pagado BOOLEAN DEFAULT FALSE,
	FOREIGN KEY (id_reserva) REFERENCES reservas(id_reserva)
);

DELIMITER //

CREATE PROCEDURE sp_RegistrarReserva(
	IN p_id_usuario INT,
	IN p_id_vehiculo INT,
	IN p_f_inicio DATE,
	IN p_f_fin DATE,
	IN p_codigo_promo VARCHAR(20)
)
BEGIN
	DECLARE v_precio_dia DECIMAL(10,2);
	DECLARE v_solapado INT;
	DECLARE v_id_promo INT DEFAULT NULL;
	DECLARE v_dto DECIMAL(5,2) DEFAULT 0;
	DECLARE v_dias INT;
	SELECT COUNT(*) INTO v_solapado FROM reservas 
	WHERE id_vehiculo = p_id_vehiculo 
	AND estado_reserva = 'Confirmada'
	AND (p_f_inicio <= fecha_fin AND p_f_fin >= fecha_inicio);

	IF v_solapado > 0 THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Vehículo no disponible en esas fechas.';
	ELSE
		SET v_dias = DATEDIFF(p_f_fin, p_f_inicio);
		IF v_dias < 1 THEN SET v_dias = 1; END IF;
		IF p_codigo_promo IS NOT NULL AND p_codigo_promo != '' THEN
			SELECT id_promocion, porcentaje_descuento INTO v_id_promo, v_dto 
			FROM promociones WHERE codigo_descuento = p_codigo_promo AND fecha_limite >= CURDATE();
		END IF;
		SELECT c.precio_dia INTO v_precio_dia 
		FROM vehiculos v JOIN categorias c ON v.id_categoria = c.id_categoria 
		WHERE v.id_vehiculo = p_id_vehiculo;
		INSERT INTO reservas (id_usuario, id_vehiculo, id_promocion, fecha_inicio, fecha_fin, coste_total)
		VALUES (p_id_usuario, p_id_vehiculo, v_id_promo, p_f_inicio, p_f_fin, 
			   (v_dias * v_precio_dia) * (1 - v_dto/100));
	END IF;
END //

CREATE TRIGGER trg_actualizar_total_reserva AFTER INSERT ON reserva_extras
FOR EACH ROW
BEGIN
	UPDATE reservas 
	SET coste_total = coste_total + NEW.total_linea
	WHERE id_reserva = NEW.id_reserva;
END //

DELIMITER ;

INSERT INTO categorias (nombre_grupo, precio_dia) VALUES 
('Económico', 30.00), ('Compacto', 45.00), ('SUV Familiar', 70.00), ('Lujo Sport', 150.00);

INSERT INTO vehiculos (matricula, marca, modelo, id_categoria, estado, imagen_url)VALUES 
('1234-BBB', 'Toyota', 'Yaris Hybrid', 1, 'Activo', 'recursos/img/yaris.png'),
('3765-JUG', 'Citroen', 'C15', 3, 'Activo', 'recursos/img/c15.png'),
('5678-JJK', 'Seat', 'León', 2, 'Activo', 'recursos/img/seat.avif'),
('9988-LMN', 'BMW', 'X3', 3, 'Activo', 'recursos/img/bmw.png'),
('8754-MAD', 'Toyota', 'Previa', 3, 'Activo', 'recursos/img/previa.png'),
('1936-NFD', 'Mclaren', '750S', 4, 'Activo', 'recursos/img/750s.avif');

INSERT INTO promociones (nombre_promo, codigo_descuento, porcentaje_descuento, es_para_estudiantes, fecha_limite) VALUES 
('Descuento Estudiante', 'ESTUDIANTE20', 20.00, TRUE, '2030-12-31'),
('Promo Verano', 'SUMMER10', 10.00, FALSE, '2026-08-31');

INSERT INTO extras (concepto, precio, tipo_calculo) VALUES 
('Seguro Todo Riesgo (Sin Franquicia)', 15.00, 'Por Dia'),
('Suplemento Conductor Joven (<25 años)', 10.00, 'Por Dia'),
('GPS Navegador', 5.00, 'Por Dia'),
('Silla Bebé Homologada', 8.00, 'Por Dia'),
('Cadenas Nieve', 20.00, 'Fijo'),
('Limpieza Especial (Mascotas)', 30.00, 'Fijo');

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `edad`, `rol`, `dni`, `menor_25`, `auth_key`) VALUES
(1, 'admin', 'admin@alquilercars.com', 'admin123', 40, 'Admin', '00000000T', 0, 'clave_admin_segura_xyz'), (2, 'cliente', 'cliente@alquilercars.com', 'cliente123', 22, 'Cliente', '12345678Z', 1, 'clave_cliente_demo_xyz');

INSERT INTO reservas (id_usuario, id_vehiculo, fecha_inicio, fecha_fin, coste_total) 
VALUES (2, 1, '2025-05-01', '2025-05-05', 120.00);

INSERT INTO reserva_extras (id_reserva, id_extra, cantidad, precio_unitario_aplicado, total_linea) 
VALUES (1, 1, 1, 15.00, 60.00);

INSERT INTO reserva_extras (id_reserva, id_extra, cantidad, precio_unitario_aplicado, total_linea) 
VALUES (1, 3, 1, 5.00, 20.00);