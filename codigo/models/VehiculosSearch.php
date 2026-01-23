<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Vehiculos;

/**
 * VehiculosSearch represents the model behind the search form of `app\models\Vehiculos`.
 */
class VehiculosSearch extends Vehiculos
{
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['id_vehiculo', 'id_categoria'], 'integer'],
			[['matricula', 'marca', 'modelo', 'estado', 'fecha_baja_logica'], 'safe'],
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
		$query = Vehiculos::find();

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
			'id_vehiculo' => $this->id_vehiculo,
			'id_categoria' => $this->id_categoria,
			'fecha_baja_logica' => $this->fecha_baja_logica,
		]);

		$query->andFilterWhere(['like', 'matricula', $this->matricula])
			->andFilterWhere(['like', 'marca', $this->marca])
			->andFilterWhere(['like', 'modelo', $this->modelo])
			->andFilterWhere(['like', 'estado', $this->estado]);

		return $dataProvider;
	}
}
