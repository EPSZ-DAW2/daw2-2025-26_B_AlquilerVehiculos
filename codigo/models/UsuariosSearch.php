<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuarios;

class UsuariosSearch extends Usuarios
{
	public function rules()
	{
		return [
			[['id_usuario', 'edad', 'menor_25'], 'integer'],
			[['nombre', 'email', 'dni', 'rol'], 'safe'],
		];
	}

	public function scenarios()
	{
		return Model::scenarios();
	}

	public function search($params)
	{
		$query = Usuarios::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			'id_usuario' => $this->id_usuario,
			'edad' => $this->edad,
			'menor_25' => $this->menor_25,
		]);

		$query->andFilterWhere(['like', 'nombre', $this->nombre])
			->andFilterWhere(['like', 'email', $this->email])
			->andFilterWhere(['like', 'dni', $this->dni])
			->andFilterWhere(['like', 'rol', $this->rol]);

		return $dataProvider;
	}
}