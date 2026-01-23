<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Promociones;

/**
 * PrmocionesSearch represents the model behind the search form of `app\models\Promociones`.
 */
class PrmocionesSearch extends Promociones
{
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['id_promocion', 'es_para_estudiantes'], 'integer'],
			[['nombre_promo', 'codigo_descuento', 'fecha_limite'], 'safe'],
			[['porcentaje_descuento'], 'number'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = Promociones::find();

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			'id_promocion' => $this->id_promocion,
			'porcentaje_descuento' => $this->porcentaje_descuento,
			'es_para_estudiantes' => $this->es_para_estudiantes,
			'fecha_limite' => $this->fecha_limite,
		]);

		$query->andFilterWhere(['like', 'nombre_promo', $this->nombre_promo])
			->andFilterWhere(['like', 'codigo_descuento', $this->codigo_descuento]);

		return $dataProvider;
	}
}
