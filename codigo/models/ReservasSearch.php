<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Reservas;

/**
 * ReservasSearch represents the model behind the search form of `app\models\Reservas`.
 */
class ReservasSearch extends Reservas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_reserva', 'id_usuario', 'id_vehiculo', 'km_entrega', 'km_devolucion'], 'integer'],
            [['fecha_inicio', 'fecha_fin', 'estado_reserva', 'observaciones_contrato'], 'safe'],
            [['coste_total'], 'number'],
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
        $query = Reservas::find();

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
            'id_reserva' => $this->id_reserva,
            'id_usuario' => $this->id_usuario,
            'id_vehiculo' => $this->id_vehiculo,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'coste_total' => $this->coste_total,
            'km_entrega' => $this->km_entrega,
            'km_devolucion' => $this->km_devolucion,
        ]);

        $query->andFilterWhere(['like', 'estado_reserva', $this->estado_reserva])
            ->andFilterWhere(['like', 'observaciones_contrato', $this->observaciones_contrato]);

        return $dataProvider;
    }
}
