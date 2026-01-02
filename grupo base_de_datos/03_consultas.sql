-- Consultar vehículos disponibles por fecha 
-- Esta consulta ayuda a Adrián con el algoritmo de disponibilidad
-- Filtrado de flota disponible por fechas para la app 
SELECT v.id_vehiculo, v.marca, v.modelo, c.nombre_grupo, c.precio_dia
FROM vehiculos v
JOIN categorias c ON v.id_categoria = c.id_categoria
WHERE v.estado = 'Activo' 
AND v.id_vehiculo NOT IN (
    SELECT id_vehiculo FROM reservas 
    WHERE estado_reserva = 'Confirmada' 
    AND ('2026-06-01' BETWEEN fecha_inicio AND fecha_fin) -- Ejemplo 
);

-- Reporte de actividad para administración 
SELECT v.marca, v.modelo, COUNT(r.id_reserva) as total_alquileres
FROM vehiculos v
JOIN reservas r ON v.id_vehiculo = r.id_vehiculo
GROUP BY v.id_vehiculo;