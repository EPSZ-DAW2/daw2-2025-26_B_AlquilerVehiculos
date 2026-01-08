<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "multas_informes".
 *
 * @property int $id_informe
 * @property int|null $id_reserva
 * @property string $descripcion
 * @property string $fecha_incidencia
 * @property float|null $importe_multa
 *
 * @property Reservas $reserva
 */
class MultasInformes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'multas_informes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_reserva'], 'integer'],
            [['descripcion', 'fecha_incidencia'], 'required'],
            [['descripcion'], 'string'],
            [['fecha_incidencia'], 'safe'],
            [['importe_multa'], 'number'],
            [['id_reserva'], 'exist', 'skipOnError' => true, 'targetClass' => Reservas::class, 'targetAttribute' => ['id_reserva' => 'id_reserva']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_informe' => 'Id Informe',
            'id_reserva' => 'Id Reserva',
            'descripcion' => 'Descripcion',
            'fecha_incidencia' => 'Fecha Incidencia',
            'importe_multa' => 'Importe Multa',
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
