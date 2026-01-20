<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Contrato extends ActiveRecord
{
    // Conecta con la tabla nueva 'contratos'
    public static function tableName()
    {
        return 'contratos'; 
    }

    public function rules()
    {
        return [
            [['id_reserva'], 'required'],
            [['id_reserva', 'km_entrega', 'km_devolucion'], 'integer'],
            [['fecha_firma', 'fecha_devolucion_real'], 'safe'],
            [['estado_contrato'], 'string'], 
            [['id_reserva'], 'unique'], 
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_contrato' => 'Nº Contrato',
            'id_reserva' => 'Reserva Asociada',
            'fecha_firma' => 'Fecha de Firma',
            'estado_contrato' => 'Estado',
            'fecha_devolucion_real' => 'Devolución Real',
            'km_entrega' => 'Km Salida',
            'km_devolucion' => 'Km Entrada',
        ];
    }

    // Relación opcional: Para poder acceder a los datos de la reserva desde el contrato
    // Uso: $contrato->reserva->coste_total
    public function getReserva()
    {
        // Nota: Esto asume que tienes un modelo Reserva.php. 
        // Si no lo tienes, Yii2 usará la tabla directa si haces queries manuales, 
        // pero para relaciones necesitas el modelo 'app\models\Reserva'.
        return $this->hasOne(Reserva::class, ['id_reserva' => 'id_reserva']);
    }
}
