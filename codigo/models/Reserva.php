<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Reserva extends ActiveRecord
{
    // Conecta con la tabla 'reservas'
    public static function tableName()
    {
        return 'reservas';
    }

    public function rules()
    {
        return [
            [['id_usuario', 'id_vehiculo', 'fecha_inicio', 'fecha_fin'], 'required'],
            [['id_usuario', 'id_vehiculo', 'id_promocion'], 'integer'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['coste_total'], 'number'],
            [['estado_reserva'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_reserva' => 'ID',
            'id_usuario' => 'Cliente',
            'id_vehiculo' => 'Vehículo',
            'id_promocion' => 'Promoción',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'coste_total' => 'Coste Total',
            'estado_reserva' => 'Estado',
        ];
    }

    // --- RELACIONES (Para poder acceder a los datos relacionados) ---

    // Acceder al Contrato asociado: $reserva->contrato
    public function getContrato()
    {
        return $this->hasOne(Contrato::class, ['id_reserva' => 'id_reserva']);
    }

    // Acceder a la Promoción aplicada: $reserva->promocion
    public function getPromocion()
    {
        return $this->hasOne(Promocion::class, ['id_promocion' => 'id_promocion']);
    }

    // Acceder al Usuario/Cliente: $reserva->usuario
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id_usuario' => 'id_usuario']);
    }
    
    // En models/Reserva.php
    public function getVehiculo()
    {
        return $this->hasOne(Vehiculo::class, ['id_vehiculo' => 'id_vehiculo']);
    }
    

}
