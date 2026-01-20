<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Promocion extends ActiveRecord
{
    // Conecta con la tabla nueva de tu compañero
    public static function tableName()
    {
        return 'promociones'; // [cite: 732]
    }

    public function rules()
    {
        return [
            [['nombre_promo', 'porcentaje_descuento'], 'required'],
            [['porcentaje_descuento'], 'number'],
            [['es_para_estudiantes'], 'boolean'], // O integer, dependiendo de cómo lo trate Yii con MySQL
            [['fecha_limite'], 'safe'], // 'safe' permite fechas
            [['codigo_descuento'], 'string', 'max' => 20],
            [['codigo_descuento'], 'unique'], // El código no puede repetirse
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_promocion' => 'ID',
            'nombre_promo' => 'Nombre Promoción',
            'codigo_descuento' => 'Código',
            'porcentaje_descuento' => 'Descuento (%)',
            'es_para_estudiantes' => 'Solo Estudiantes',
            'fecha_limite' => 'Válido hasta',
        ];
    }
}