<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Vehiculos;

class VehiculosPublicSearch extends Vehiculos
{
	public $precio_max;

	public function rules()
	{
		return [
			[['id_categoria'], 'integer'],
			[['precio_max'], 'number'],
			[['estado'], 'safe'],
		];
	}

	public function search($params)
	{
		$query = Vehiculos::find()->joinWith('categoria'); 
		$query->where(['estado' => 'Activo']);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => ['pageSize' => 9],
		]);

		$dataProvider->sort->attributes['precio_max'] = [
			'asc' => ['categorias.precio_dia' => SORT_ASC],
			'desc' => ['categorias.precio_dia' => SORT_DESC],
		];

		$this->load($params);

		if (!$this->validate()) {
			return $dataProvider;
		}

		$query->andFilterWhere(['vehiculos.id_categoria' => $this->id_categoria]);

		if ($this->precio_max) {
			$query->andWhere(['<=', 'categorias.precio_dia', $this->precio_max]);
		}
		
		return $dataProvider;
	}
}