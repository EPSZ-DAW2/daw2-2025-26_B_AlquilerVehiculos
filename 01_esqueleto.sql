CREATE DATABASE IF NOT EXISTS gestion_alquiler;
USE gestion_alquiler;

-- Categorías: Define el precio por día de cada grupo de vehículos 
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre_grupo VARCHAR(50) NOT NULL, -- Económico, SUV, Lujo
    precio_dia DECIMAL(10,2) NOT NULL
);

-- Vehículos: Incluye soporte para "Baja Lógica" y estados 
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

-- Usuarios: Gestión de perfiles con Carnet de Conducir 
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('Admin', 'Cliente') DEFAULT 'Cliente',
    num_carnet_conducir VARCHAR(50) 
);

-- Reservas: Contratos vinculados a clientes y vehículos 
CREATE TABLE reservas (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_vehiculo INT,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    coste_total DECIMAL(10,2),
    estado_reserva ENUM('Confirmada', 'Finalizada', 'Cancelada') DEFAULT 'Confirmada',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo)
);

-- Módulo de Incidencias: Multas vinculadas a contratos 
CREATE TABLE multas_informes (
    id_informe INT AUTO_INCREMENT PRIMARY KEY,
    id_reserva INT,
    descripcion TEXT NOT NULL,
    fecha_incidencia DATE NOT NULL,
    importe_multa DECIMAL(10,2) DEFAULT 0.00,
    FOREIGN KEY (id_reserva) REFERENCES reservas(id_reserva)
);