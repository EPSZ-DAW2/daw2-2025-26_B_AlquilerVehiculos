<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contratos".
 *
 * @property int $id_contrato
 * @property int|null $id_reserva
 * @property string|null $fecha_firma
 * @property string|null $estado_contrato
 * @property string|null $fecha_devolucion_real
 * @property int|null $km_entrega
 * @property int|null $km_devolucion
 *
 * @property Reservas $reserva
 */
class Contratos extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'contratos';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['id_reserva', 'km_entrega', 'km_devolucion'], 'integer'],
			[['fecha_firma', 'fecha_devolucion_real'], 'safe'],
			[['estado_contrato'], 'string'],
			[['id_reserva'], 'unique'],
			[['id_reserva'], 'exist', 'skipOnError' => true, 'targetClass' => Reservas::class, 'targetAttribute' => ['id_reserva' => 'id_reserva']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id_contrato' => 'Id Contrato',
			'id_reserva' => 'Id Reserva',
			'fecha_firma' => 'Fecha Firma',
			'estado_contrato' => 'Estado Contrato',
			'fecha_devolucion_real' => 'Fecha Devolucion Real',
			'km_entrega' => 'Km Entrega',
			'km_devolucion' => 'Km Devolucion',
		];
	}

	/**
	 * Gets query for [[Reserva]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getReserva()
	{
		return $this->hasOne(Reservas::class, ['id_reserva' => 'id_reserva']);
	}
}
