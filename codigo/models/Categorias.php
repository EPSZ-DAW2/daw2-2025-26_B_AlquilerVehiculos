<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categorias".
 *
 * @property int $id_categoria
 * @property string $nombre_grupo
 * @property float $precio_dia
 *
 * @property Vehiculos[] $vehiculos
 */
class Categorias extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'categorias';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['nombre_grupo', 'precio_dia'], 'required'],
			[['precio_dia'], 'number'],
			[['nombre_grupo'], 'string', 'max' => 50],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id_categoria' => 'Id Categoria',
			'nombre_grupo' => 'Nombre Grupo',
			'precio_dia' => 'Precio Dia',
		];
	}

	/**
	 * Gets query for [[Vehiculos]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getVehiculos()
	{
		return $this->hasMany(Vehiculos::class, ['id_categoria' => 'id_categoria']);
	}
}
