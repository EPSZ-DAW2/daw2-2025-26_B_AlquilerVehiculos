<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "promociones".
 *
 * @property int $id_promocion
 * @property string $nombre_promo
 * @property string|null $codigo_descuento
 * @property float $porcentaje_descuento
 * @property int|null $es_para_estudiantes
 * @property string|null $fecha_limite
 *
 * @property Reservas[] $reservas
 */
class Promociones extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'promociones';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['nombre_promo', 'porcentaje_descuento'], 'required'],
			[['porcentaje_descuento'], 'number'],
			[['es_para_estudiantes'], 'integer'],
			[['fecha_limite'], 'safe'],
			[['nombre_promo'], 'string', 'max' => 100],
			[['codigo_descuento'], 'string', 'max' => 20],
			[['codigo_descuento'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id_promocion' => 'Id Promocion',
			'nombre_promo' => 'Nombre Promo',
			'codigo_descuento' => 'Codigo Descuento',
			'porcentaje_descuento' => 'Porcentaje Descuento',
			'es_para_estudiantes' => 'Es Para Estudiantes',
			'fecha_limite' => 'Fecha Limite',
		];
	}

	/**
	 * Gets query for [[Reservas]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getReservas()
	{
		return $this->hasMany(Reservas::class, ['id_promocion' => 'id_promocion']);
	}
}
