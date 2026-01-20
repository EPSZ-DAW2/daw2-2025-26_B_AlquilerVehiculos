<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Contrato extends ActiveRecord
{
    // Conecta con la tabla contratos
    public static function tableName()
    {
        return 'contratos'; // [cite: 734]
    }

    public function rules()
    {
        return [
            [['id_reserva'], 'required'],
            [['id_reserva', 'km_entrega', 'km_devolucion'], 'integer'],
            [['fecha_firma', 'fecha_devolucion_real'], 'safe'],
            [['estado_contrato'], 'string'],
            [['id_reserva'], 'unique'], // Una reserva solo puede tener un contrato
        ];
    }

    // Relación: Un contrato pertenece a una Reserva
    public function getReserva()
    {
        // Nota: Asumimos que existirá el modelo Reserva (lo necesitaremos luego)
        return $this->hasOne(Reserva::class, ['id_reserva' => 'id_reserva']);
    }

    public function attributeLabels()
    {
        return [
            'id_contrato' => 'Nº Contrato',
            'id_reserva' => 'Reserva Asociada',
            'estado_contrato' => 'Estado',
            'km_entrega' => 'Km Salida',
            'km_devolucion' => 'Km Entrada',
        ];
    }
}