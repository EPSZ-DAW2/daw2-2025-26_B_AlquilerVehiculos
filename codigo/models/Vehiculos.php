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
 *
 * @property Categorias $categoria
 * @property Reservas[] $reservas
 */
class Vehiculos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehiculos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['matricula', 'marca', 'modelo'], 'required'],
            [['id_categoria'], 'integer'],
            [['estado'], 'string'],
            [['fecha_baja_logica'], 'safe'],
            [['matricula'], 'string', 'max' => 15],
            [['marca', 'modelo'], 'string', 'max' => 50],
            [['matricula'], 'unique'],
            [['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::class, 'targetAttribute' => ['id_categoria' => 'id_categoria']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_vehiculo' => 'Id Vehiculo',
            'matricula' => 'Matricula',
            'marca' => 'Marca',
            'modelo' => 'Modelo',
            'id_categoria' => 'Id Categoria',
            'estado' => 'Estado',
            'fecha_baja_logica' => 'Fecha Baja Logica',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categorias::class, ['id_categoria' => 'id_categoria']);
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reservas::class, ['id_vehiculo' => 'id_vehiculo']);
    }
}
