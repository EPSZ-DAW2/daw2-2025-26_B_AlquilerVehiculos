DELIMITER //

-- Procedimiento: Registra reserva, valida fechas y calcula coste automáticamente 
CREATE PROCEDURE sp_RegistrarReserva(
    IN p_id_usuario INT,
    IN p_id_vehiculo INT,
    IN p_f_inicio DATE,
    IN p_f_fin DATE
)
BEGIN
    DECLARE v_precio DECIMAL(10,2);
    DECLARE v_solapado INT;
    
    --  CORREGIDO:  detecta solapamientos totales y parciales
    SELECT COUNT(*) INTO v_solapado FROM reservas 
    WHERE id_vehiculo = p_id_vehiculo 
      AND estado_reserva = 'Confirmada'
      AND (p_f_inicio <= fecha_fin AND p_f_fin >= fecha_inicio);

    IF v_solapado > 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Vehículo no disponible en esas fechas.';
    ELSE
        -- Obtener precio por categoría
        SELECT c.precio_dia INTO v_precio 
        FROM vehiculos v JOIN categorias c ON v.id_categoria = c.id_categoria 
        WHERE v.id_vehiculo = p_id_vehiculo;

        -- Insertar reserva con cálculo automático 
        INSERT INTO reservas (id_usuario, id_vehiculo, fecha_inicio, fecha_fin, coste_total)
        VALUES (p_id_usuario, p_id_vehiculo, p_f_inicio, p_f_fin, (DATEDIFF(p_f_fin, p_f_inicio) * v_precio));
        
        -- Actualizar estado del vehículo 
        UPDATE vehiculos SET estado = 'Alquilado' WHERE id_vehiculo = p_id_vehiculo;
    END IF;
END //

-- Lógica de Baja Lógica: Mantenemos este procedimiento igual
CREATE PROCEDURE sp_BajaVehiculo(IN p_id INT)
BEGIN
    UPDATE vehiculos 
    SET estado = 'Baja', fecha_baja_logica = NOW() 
    WHERE id_vehiculo = p_id;
END //

DELIMITER ;