<?php
namespace app\models;
use Yii;

class ReservaExtras extends \yii\db\ActiveRecord
{
	public static function tableName()
	{
		return 'reserva_extras';
	}

	public function rules()
	{
		return [
			[['id_reserva', 'id_extra', 'cantidad', 'precio_unitario_aplicado', 'total_linea'], 'required'],
			[['id_reserva', 'id_extra', 'cantidad'], 'integer'],
			[['precio_unitario_aplicado', 'total_linea'], 'number'],
		];
	}
}