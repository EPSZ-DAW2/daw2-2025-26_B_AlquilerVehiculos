<?php
namespace app\models;
use Yii;

class Reservas extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return 'reservas';
	}

	public function rules()
	{
		return [
			[['id_usuario', 'id_vehiculo', 'fecha_inicio', 'fecha_fin'], 'required'],
			[['id_usuario', 'id_vehiculo', 'id_promocion'], 'integer'],
			[['fecha_inicio', 'fecha_fin', 'fecha_creacion'], 'safe'],
			[['coste_total'], 'number'], 
			[['estado_reserva'], 'string'], 
			['fecha_fin', 'compare', 'compareAttribute' => 'fecha_inicio', 'operator' => '>', 'message' => 'La fecha fin debe ser posterior.'],
		];
	}
	
	public function getVehiculo()
	{
		return $this->hasOne(Vehiculos::class, ['id_vehiculo' => 'id_vehiculo']);
	}

	public function getUsuario()
	{
		return $this->hasOne(Usuarios::class, ['id_usuario' => 'id_usuario']);
	}
	public function getContrato()
	{
		return $this->hasOne(Contratos::class, ['id_reserva' => 'id_reserva']);
	}
}