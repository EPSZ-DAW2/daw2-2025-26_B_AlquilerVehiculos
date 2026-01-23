<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MultasInformes;

class MultasInformesSearch extends MultasInformes
{
	public function rules()
	{
		return [
			[['id_informe', 'id_reserva'], 'integer'],
			[['descripcion', 'fecha_incidencia'], 'safe'],
			[['importe_multa'], 'number'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = MultasInformes::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			'id_informe' => $this->id_informe,
			'id_reserva' => $this->id_reserva,
			'fecha_incidencia' => $this->fecha_incidencia,
			'importe_multa' => $this->importe_multa,
		]);

		$query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

		return $dataProvider;
	}
}