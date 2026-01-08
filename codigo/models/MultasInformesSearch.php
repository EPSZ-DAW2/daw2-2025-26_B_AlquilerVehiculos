<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MultasInformes;

/**
 * MultasInformesSearch represents the model behind the search form of `app\models\MultasInformes`.
 */
class MultasInformesSearch extends MultasInformes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_informe', 'id_reserva'], 'integer'],
            [['descripcion', 'fecha_incidencia'], 'safe'],
            [['importe_multa'], 'number'],
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
        $query = MultasInformes::find();

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
            'id_informe' => $this->id_informe,
            'id_reserva' => $this->id_reserva,
            'fecha_incidencia' => $this->fecha_incidencia,
            'importe_multa' => $this->importe_multa,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
