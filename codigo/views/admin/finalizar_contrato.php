<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $contrato app\models\Contrato */

$this->title = 'Finalizar Contrato #' . $contrato->id_contrato;
$reserva = $contrato->reserva;
$vehiculo = $reserva->vehiculo;
$usuario = $reserva->usuario;
?>

<div class="card" style="max-width: 600px; margin: 20px auto;">
    <div class="card-h">
        <h3>🚗 Devolución de Vehículo</h3>
    </div>

    <div class="card-b">
        <div class="alert alert-info" style="background:#e3f2fd; padding:10px; border-radius:5px; margin-bottom:15px; color:#0d47a1;">
            Estás a punto de finalizar el contrato y liberar el vehículo.
        </div>

        <table class="table" style="margin-bottom: 20px;">
            <tr>
                <th>Vehículo:</th>
                <td><?= Html::encode($vehiculo->marca . ' ' . $vehiculo->modelo) ?> <br> <small><?= Html::encode($vehiculo->matricula) ?></small></td>
            </tr>
            <tr>
                <th>Cliente:</th>
                <td><?= Html::encode($usuario->nombre . ' ' . $usuario->apellidos) ?></td>
            </tr>
            <tr>
                <th>Km Salida:</th>
                <td><strong><?= $contrato->km_entrega ?> km</strong></td>
            </tr>
        </table>

        <?= Html::beginForm() ?>
            
            <div class="field">
                <label style="display:block; margin-bottom:5px; font-weight:bold;">Kilómetros Actuales (Entrada):</label>
                <input type="number" name="km_final" 
                       class="form-control" 
                       required 
                       min="<?= $contrato->km_entrega ?>" 
                       placeholder="Ej. <?= $contrato->km_entrega + 100 ?>"
                       style="width:100%; padding:10px; font-size:16px;">
                
                <small style="color:red; display:block; margin-top:5px;">
                    * Debe ser mayor o igual a <?= $contrato->km_entrega ?> km
                </small>
            </div>

            <div class="actions" style="margin-top: 20px; text-align:right;">
                <a href="<?= Url::to(['admin/contratos']) ?>" class="btn" style="background:#ccc; color:#333; text-decoration:none; padding:10px 20px; margin-right:10px;">Cancelar</a>
                
                <button type="submit" class="btn good" style="background:green; color:white; padding:10px 20px; border:none; cursor:pointer;">
                    ✅ Confirmar Devolución
                </button>
            </div>

        <?= Html::endForm() ?>
    </div>
</div>