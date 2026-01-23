<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehiculos".
 *
 * @property int $id_vehiculo
 * @property string $matricula
 * @property string $marca
 * @property string $modelo
 * @property int|null $id_categoria
 * @property string|null $estado
 * @property string|null $fecha_baja_logica
 * @property string|null $imagen_url
 *
 * @property Categorias $categoria
 * @property Reservas[] $reservas
 */
class Vehiculos extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return 'vehiculos';
	}

	public function rules()
	{
		return [
			[['matricula', 'marca', 'modelo'], 'required'],
			[['id_categoria'], 'integer'],
			[['estado'], 'string'],
			[['fecha_baja_logica'], 'safe'],
			[['matricula'], 'string', 'max' => 15],
			[['marca', 'modelo'], 'string', 'max' => 50],
			[['imagen_url'], 'string', 'max' => 255], 
			[['matricula'], 'unique'],
			[['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::class, 'targetAttribute' => ['id_categoria' => 'id_categoria']],
		];
	}

	public function attributeLabels()
	{
		return [
			'id_vehiculo' => 'Id Vehiculo',
			'matricula' => 'Matricula',
			'marca' => 'Marca',
			'modelo' => 'Modelo',
			'id_categoria' => 'Categoría',
			'estado' => 'Estado',
			'fecha_baja_logica' => 'Fecha Baja Lógica',
			'imagen_url' => 'Imagen URL',
		];
	}

	public function getCategoria()
	{
		return $this->hasOne(Categorias::class, ['id_categoria' => 'id_categoria']);
	}

	public function getReservas()
	{
		return $this->hasMany(Reservas::class, ['id_vehiculo' => 'id_vehiculo']);
	}
	public function getEstaReservado()
	{
		$hoy = date('Y-m-d');

		return $this->getReservas()
			->where(['and',
				['id_vehiculo' => $this->id_vehiculo],
				['<=', 'fecha_inicio', $hoy],
				['>=', 'fecha_fin', $hoy],
				['estado_reserva' => 'Confirmada'] 
			])
			->exists();
	}
}