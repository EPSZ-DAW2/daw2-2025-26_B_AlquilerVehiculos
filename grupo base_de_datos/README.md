Responsables: DHIAEDDINE JEBABLI y AHMED METTITI 


Este módulo constituye la base de persistencia del proyecto, siguiendo un patrón MVC (Modelo-Vista-Controlador) adaptado. 
Se encarga de la integridad de la información, el almacenamiento lógico y la ejecución de reglas de negocio directamente en el motor de base de datos MySQL

Estructura de Scripts (Orden de Ejecución)
Para garantizar la integridad referencial, los archivos deben ejecutarse en el siguiente orden:

01_esqueleto.sql: Creación de tablas y relaciones (DDL).

02_procedimientos.sql: Lógica programada y reglas de negocio.

03_consultas.sql: Consultas de filtrado y reportes optimizados.

04_datos_prueba.sql: Inserción de registros iniciales para pruebas (DML).



Arquitectura de la Base de Datos
La base de datos se compone de las siguientes entidades clave

Tabla                            Descripción                                                      Campos Clave
Categorías              Define los grupos de coches y su precio por día.                        "nombre_grupo, precio_dia"
Vehículos               Gestiona la flota, su estado y la baja lógica.                          "matricula, estado, fecha_baja_logica"
Usuarios                Almacena clientes y administradores.                                    "rol, num_carnet_conducir"
Reservas                Motor central que vincula usuarios con vehículos.                       "fecha_inicio, fecha_fin, coste_total"
Multas_Informes         Registro de incidencias vinculado a contratos.                          "id_reserva, importe_multa"



Lógica de Negocio Implementada
Siguiendo los requerimientos técnicos del proyecto, hemos programado procedimientos almacenados para automatizar tareas críticas:

1. Gestión de "Baja Lógica" (Soft Delete)
Tal como se solicita, los vehículos vendidos o retirados no se eliminan físicamente para mantener el histórico de alquileres y multas.
El procedimiento sp_BajaVehiculo cambia el estado a 'Baja' y registra la fecha exacta de salida.


2. Algoritmo de Disponibilidad y Costes
El procedimiento sp_RegistrarReserva incluye dos capas de control:

Prevención de Solapamiento: Antes de confirmar, verifica si el vehículo ya tiene una reserva activa en ese rango de fechas.

Cálculo Automático de Precio: Implementa la fórmula oficial: (Fecha Fin - Fecha Inicio) * Precio Categoría.

3. Consultas de Filtrado
Se incluye un sistema de filtrado dinámico para que la Capa de Presentación pueda mostrar solo los vehículos Activos que no tengan conflictos 
de reserva en las fechas seleccionadas.


Utilidad para el Equipo
Para Adrián (Backend): Solo necesitas llamar a los procedimientos sp_RegistrarReserva o sp_BajaVehiculo desde PHP.
La base de datos se encarga de las validaciones y cálculos de coste.


Para Héctor y Kailun (Frontend): Podéis usar los datos de 04_datos_prueba.sql para ver cómo lucen vuestras 
tablas y formularios con información real (Económicos, SUVs, Lujo).
