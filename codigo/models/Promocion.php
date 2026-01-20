<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Promocion extends ActiveRecord
{
    // Conecta con la tabla nueva 'promociones'
    public static function tableName()
    {
        return 'promociones';
    }

    public function rules()
    {
        return [
            [['nombre_promo', 'porcentaje_descuento'], 'required'],
            [['porcentaje_descuento'], 'number'],
            [['es_para_estudiantes'], 'integer'], 
            [['fecha_limite'], 'safe'],
            [['codigo_descuento'], 'string', 'max' => 20],
            [['codigo_descuento'], 'unique'], 
            [['nombre_promo'], 'string', 'max' => 100],
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
