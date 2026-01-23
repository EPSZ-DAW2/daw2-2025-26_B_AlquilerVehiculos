<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "extras".
 *
 * @property int $id_extra
 * @property string $concepto
 * @property float $precio
 * @property string|null $tipo_calculo
 *
 * @property ReservaExtras[] $reservaExtras
 */
class Extras extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'extras';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['concepto', 'precio'], 'required'],
			[['precio'], 'number'],
			[['tipo_calculo'], 'string'],
			[['concepto'], 'string', 'max' => 100],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id_extra' => 'Id Extra',
			'concepto' => 'Concepto',
			'precio' => 'Precio',
			'tipo_calculo' => 'Tipo Calculo',
		];
	}

	/**
	 * Gets query for [[ReservaExtras]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getReservaExtras()
	{
		return $this->hasMany(ReservaExtras::class, ['id_extra' => 'id_extra']);
	}
}
