<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reservas".
 *
 * @property int $id_reserva
 * @property int|null $id_usuario
 * @property int|null $id_vehiculo
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property float|null $coste_total
 * @property string|null $estado_reserva
 * @property int|null $km_entrega
 * @property int|null $km_devolucion
 * @property string|null $observaciones_contrato
 *
 * @property MultasInformes[] $multasInformes
 * @property Usuarios $usuario
 * @property Vehiculos $vehiculo
 */
class Reservas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_vehiculo', 'km_entrega', 'km_devolucion'], 'integer'],
            [['fecha_inicio', 'fecha_fin'], 'required'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['coste_total'], 'number'],
            [['estado_reserva', 'observaciones_contrato'], 'string'],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['id_usuario' => 'id_usuario']],
            [['id_vehiculo'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculos::class, 'targetAttribute' => ['id_vehiculo' => 'id_vehiculo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_reserva' => 'Id Reserva',
            'id_usuario' => 'Id Usuario',
            'id_vehiculo' => 'Id Vehiculo',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'coste_total' => 'Coste Total',
            'estado_reserva' => 'Estado Reserva',
            'km_entrega' => 'Km Entrega',
            'km_devolucion' => 'Km Devolucion',
            'observaciones_contrato' => 'Observaciones Contrato',
        ];
    }

    /**
     * Gets query for [[MultasInformes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMultasInformes()
    {
        return $this->hasMany(MultasInformes::class, ['id_reserva' => 'id_reserva']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id_usuario' => 'id_usuario']);
    }

    /**
     * Gets query for [[Vehiculo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculo()
    {
        return $this->hasOne(Vehiculos::class, ['id_vehiculo' => 'id_vehiculo']);
    }
}
