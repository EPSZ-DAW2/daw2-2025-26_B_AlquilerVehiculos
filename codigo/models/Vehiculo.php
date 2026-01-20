<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Vehiculo extends ActiveRecord
{
    // Conecta con la tabla 'vehiculos'
    public static function tableName()
    {
        return 'vehiculos';
    }

    public function rules()
    {
        return [
            [['marca', 'modelo', 'matricula', 'precio_dia'], 'required'],
            [['anio', 'plazas', 'baja_logica'], 'integer'],
            [['precio_dia'], 'number'],
            [['descripcion', 'estado'], 'string'],
            [['marca', 'modelo', 'categoria', 'combustible', 'caja'], 'string', 'max' => 50],
            [['matricula'], 'string', 'max' => 10],
            [['matricula'], 'unique'], // La matrícula no se puede repetir
            [['img'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_vehiculo' => 'ID',
            'marca' => 'Marca',
            'modelo' => 'Modelo',
            'matricula' => 'Matrícula',
            'precio_dia' => 'Precio/Día',
            'estado' => 'Estado Actual', // disponible, reservado, mantenimiento
            'baja_logica' => 'Dado de Baja',
        ];
    }
    
    // --- MÉTODOS ÚTILES ---

    // Relación: Un vehículo puede tener muchas reservas a lo largo del tiempo
    public function getReservas()
    {
        return $this->hasMany(Reserva::class, ['id_vehiculo' => 'id_vehiculo']);
    }

    // Para obtener solo los vehículos activos (no dados de baja)
    public static function findActivos()
    {
        return static::find()->where(['baja_logica' => 0]);
    }
}