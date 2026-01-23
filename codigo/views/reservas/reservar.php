<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Reservas $model */
/** @var app\models\Vehiculos $vehiculo */
/** @var app\models\Extras[] $listaExtras */
/** @var app\models\Promociones[] $listaPromos */ 

$this->title = 'Reservar ' . $vehiculo->marca;
$catPrecio = $vehiculo->categoria ? $vehiculo->categoria->precio_dia : 0;
$imgUrl = $vehiculo->imagen_url ? Url::to('@web/' . $vehiculo->imagen_url) : Url::to('@web/recursos/img/coche_default.png');
?>

<section class="hero">
	<h1 class="h-title">Reservar <?= Html::encode($vehiculo->marca . ' ' . $vehiculo->modelo) ?></h1>
</section>

<section class="split">
	<section class="card">
	<div class="card-b">
		<img src="<?= $imgUrl ?>" style="width:100%; border-radius:12px; margin-bottom:15px">
		<div class="kv">
			<div class="box"><div class="k">Precio Base</div><div class="v"><?= $catPrecio ?>€ / día</div></div>
			<div class="box"><div class="k">Descuento</div><div class="v" id="display-descuento" style="color:var(--ok)">0%</div></div>
			<div class="box"><div class="k">Total Final</div><div class="v" style="color:var(--brand); font-size:1.4em" id="display-total">0.00€</div></div>
		</div>
	</div>
	</section>

	<aside class="card">
	<div class="card-h"><h3>Configura tu reserva</h3></div>
	<div class="card-b">
		<?php $form = ActiveForm::begin(['id' => 'reserva-form']); ?>

		<h4 style="margin:0 0 10px; font-size:14px; color:var(--brand)">📅 Fechas</h4>
		<div class="row2">
			<?= $form->field($model, 'fecha_inicio')->input('date', ['id' => 'fecha-inicio']) ?>
			<?= $form->field($model, 'fecha_fin')->input('date', ['id' => 'fecha-fin']) ?>
		</div>

		<hr class="sep">

		<h4 style="margin:0 0 10px; font-size:14px; color:var(--brand)">➕ Extras</h4>
		<div class="list" style="grid-template-columns: 1fr; gap: 8px;">
			<?php foreach ($listaExtras as $extra): ?>
				<?php 
					$isJoven = Yii::$app->user->identity->menor_25 == 1;
					$esSuplementoJoven = (stripos($extra->concepto, 'Joven') !== false);
					$checked = ($esSuplementoJoven && $isJoven);
				?>
				<label style="display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.03); padding:10px; border-radius:8px; border:1px solid var(--border); cursor:pointer">
					<div style="display:flex; align-items:center; gap:10px;">
						<input type="checkbox" name="extras_seleccionados[]" value="<?= $extra->id_extra ?>" 
									class="extra-checkbox"
									data-precio="<?= $extra->precio ?>"
									data-tipo="<?= $extra->tipo_calculo ?>" 
									<?= $checked ? 'checked' : '' ?>>
						<span><?= Html::encode($extra->concepto) ?></span>
					</div>
					<strong><?= $extra->precio ?>€ <small style="color:var(--muted)"><?= $extra->tipo_calculo == 'Por Dia' ? '/día' : '' ?></small></strong>
				</label>
			<?php endforeach; ?>
		</div>
		
		<hr class="sep">

		<h4 style="margin:0 0 10px; font-size:14px; color:var(--brand)">🏷️ Código Promocional</h4>
		<div class="field">
			<label class="label">Selecciona un descuento</label>
			<select name="Reservas[id_promocion]" id="promo-select">
				<option value="" data-percent="0">Sin descuento</option>
				<?php foreach ($listaPromos as $promo): ?>
					<option value="<?= $promo->id_promocion ?>" data-percent="<?= $promo->porcentaje_descuento ?>">
						<?= Html::encode($promo->nombre_promo) ?> (<?= Html::encode($promo->codigo_descuento) ?>) - <?= $promo->porcentaje_descuento ?>%
					</option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="actions" style="margin-top:20px">
			<button type="submit" class="btn good" style="width:100%" id="btn-submit">
				Confirmar Reserva (<span id="btn-total">0.00€</span>)
			</button>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
	</aside>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
	const precioDiaCoche = <?= $catPrecio ?>;
	const inputInicio = document.getElementById('fecha-inicio');
	const inputFin = document.getElementById('fecha-fin');
	const checkboxes = document.querySelectorAll('.extra-checkbox');
	const promoSelect = document.getElementById('promo-select');
	
	const displayTotal = document.getElementById('display-total');
	const displayDescuento = document.getElementById('display-descuento');
	const btnTotal = document.getElementById('btn-total');

	function calcular() {
		if(!inputInicio.value || !inputFin.value) return;

		const f1 = new Date(inputInicio.value);
		const f2 = new Date(inputFin.value);
		let dias = (f2 - f1) / (1000 * 60 * 60 * 24);
		if (dias < 1) dias = 1;

		let subtotal = dias * precioDiaCoche;

		checkboxes.forEach(cb => {
			if(cb.checked) {
				let precio = parseFloat(cb.getAttribute('data-precio'));
				let tipo = cb.getAttribute('data-tipo');
				if(tipo === 'Por Dia') {
					subtotal += (precio * dias);
				} else {
					subtotal += precio;
				}
			}
		});

		const selectedOption = promoSelect.options[promoSelect.selectedIndex];
		const porcentaje = parseFloat(selectedOption.getAttribute('data-percent')) || 0;
		
		let descuento = 0;
		if (porcentaje > 0) {
			descuento = subtotal * (porcentaje / 100);
		}
		
		let totalFinal = subtotal - descuento;

		displayDescuento.innerText = '-' + porcentaje + '% (' + descuento.toFixed(2) + '€)';
		displayTotal.innerText = totalFinal.toFixed(2) + '€';
		btnTotal.innerText = totalFinal.toFixed(2) + '€';
	}

	inputInicio.addEventListener('change', calcular);
	inputFin.addEventListener('change', calcular);
	checkboxes.forEach(cb => cb.addEventListener('change', calcular));
	promoSelect.addEventListener('change', calcular);
});
</script>