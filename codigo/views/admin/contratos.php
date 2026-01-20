<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  SEGURIDAD (OBLIGATORIO EN BACKEND)
  ================================
  En Yii2:
  - Proteger la ruta en AdminController
  - Validar rol=admin
*/

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  Listado recomendado (JOIN):
    SELECT c.id, cli.nombre, v.marca, v.modelo, c.fecha_inicio, c.fecha_fin, c.total, c.estado
    FROM contratos c
    JOIN clientes cli ON cli.id = c.id_cliente
    JOIN vehiculos v ON v.id = c.id_vehiculo
    ORDER BY c.id DESC;

  Estados típicos:
    - pendiente
    - activa
    - finalizada
    - cancelada

  Acciones posibles:
    - Cambiar estado (UPDATE)
    - Cancelar (UPDATE estado='cancelada')
*/

$this->title = 'Admin - Contratos';

$contratos = $contratos ?? [
  ['id'=>'C-0001','cliente'=>'Juan Pérez','vehiculo'=>'Toyota Yaris','inicio'=>'2026-01-06','fin'=>'2026-01-08','total'=>84.70,'estado'=>'activa'],
  ['id'=>'C-0000','cliente'=>'María López','vehiculo'=>'BMW Serie 1','inicio'=>'2025-12-10','fin'=>'2025-12-12','total'=>191.18,'estado'=>'pendiente'],
  ['id'=>'C-0998','cliente'=>'Carlos Ruiz','vehiculo'=>'Nissan Qashqai','inicio'=>'2025-09-01','fin'=>'2025-09-06','total'=>332.75,'estado'=>'finalizada'],
];
?>

<section class="hero">
  <h1 class="h-title">Contratos / Reservas</h1>
  <p class="h-sub">Gestión de reservas y contratos (datos desde BD).</p>
</section>

<section class="card">
  <div class="card-h">
    <h3>Listado</h3>
    <span class="small"><?= count($contratos) ?> registros</span>
  </div>

  <div class="card-b" style="padding:0">
    <table class="table">
      <thead>
        <tr>
          <th>#Contrato</th>
          <th>Cliente</th>
          <th>Vehículo</th>
          <th>Inicio</th>
          <th>Fin</th>
          <th>Total</th>
          <th>Estado</th>
          <th>Acción</th>
        </tr>
      </thead>

      <tbody>
        <?php if (empty($contratos) || is_array($contratos[0] ?? null)): ?>
           <tr>
               <td colspan="8" style="text-align:center; padding:20px">
                   <?php if(empty($contratos)): ?>
                       No hay contratos registrados en la Base de Datos.
                   <?php else: ?>
                       <em>Cargando datos de demostración... (Conecta el controlador para ver datos reales)</em>
                   <?php endif; ?>
               </td>
           </tr>
        <?php else: ?>
           <?php foreach ($contratos as $c): ?>
             <?php
               // 1. Recuperamos relaciones con seguridad (por si se borró el usuario/coche)
               $reserva = $c->reserva;
               $usuario = $reserva ? $reserva->usuario : null;
               $vehiculo = $reserva ? $reserva->vehiculo : null;

               // 2. Definimos estilos según el estado (Vigente=Verde/ok, Finalizado=Gris/off)
               $estado = $c->estado_contrato;
               $pillClass = match($estado) {
                   'Vigente' => 'ok',
                   'Finalizado' => 'off',
                   'Cancelado' => 'busy', // Usamos 'busy' para rojo/alerta
                   default => 'off'
               };
             ?>
             <tr>
               <td><?= Html::encode($c->id_contrato) ?></td>

               <td>
                   <?php if ($usuario): ?>
                       <?= Html::encode($usuario->nombre . ' ' . $usuario->apellidos) ?>
                   <?php else: ?>
                       <span style="opacity:0.5">Usuario desconocido</span>
                   <?php endif; ?>
               </td>

               <td>
                   <?php if ($vehiculo): ?>
                       <?= Html::encode($vehiculo->marca . ' ' . $vehiculo->modelo) ?>
                   <?php else: ?>
                       <span style="opacity:0.5">Vehículo borrado</span>
                   <?php endif; ?>
               </td>

               <td><?= $reserva ? Yii::$app->formatter->asDate($reserva->fecha_inicio, 'php:Y-m-d') : '-' ?></td>
               <td><?= $reserva ? Yii::$app->formatter->asDate($reserva->fecha_fin, 'php:Y-m-d') : '-' ?></td>

               <td><?= $reserva ? number_format($reserva->coste_total, 2) : '0.00' ?>€</td>

               <td>
                 <span class="pill <?= $pillClass ?>" style="position:static">
                   <?= Html::encode($estado) ?>
                 </span>
               </td>

               <td>
                 <?php if ($estado === 'Vigente'): ?>
                     <a href="<?= Url::to(['admin/finalizar-contrato', 'id' => $c->id_contrato]) ?>" 
                        class="btn danger"
                        onclick="return confirm('¿Confirmar devolución del vehículo y finalizar contrato?')">
                        Finalizar
                     </a>
                 <?php else: ?>
                     <span style="color:#999">-</span>
                 <?php endif; ?>
               </td>
             </tr>
           <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <div style="padding:16px">
      <p class="small">
        En BD: este listado se obtiene con JOIN (contratos + clientes + vehículos).
      </p>

      <div class="actions">
        <a class="btn" href="<?= Html::encode(Url::to(['admin/dashboard'])) ?>">Volver al dashboard</a>
      </div>
    </div>
  </div>
</section>

