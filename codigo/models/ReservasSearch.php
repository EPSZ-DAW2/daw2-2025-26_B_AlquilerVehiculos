<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Reservas;

class ReservasSearch extends Reservas
{
	public function rules()
	{
		return [
			[['id_reserva', 'id_usuario', 'id_vehiculo'], 'integer'],
			[['fecha_inicio', 'fecha_fin', 'estado_reserva', 'fecha_creacion'], 'safe'],
			[['coste_total'], 'number'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = Reservas::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => ['defaultOrder' => ['fecha_creacion' => SORT_DESC]],
		]);

		$this->load($params);

		if (!$this->validate()) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			'id_reserva' => $this->id_reserva,
			'id_usuario' => $this->id_usuario,
			'id_vehiculo' => $this->id_vehiculo,
			'coste_total' => $this->coste_total,
		]);

		$query->andFilterWhere(['like', 'estado_reserva', $this->estado_reserva]);

		return $dataProvider;
	}
}