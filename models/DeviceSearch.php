<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class DeviceSearch extends Device
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'plant_id', 'location_id', 'state_id', 'value'], 'integer'],
            [['short_name', 'name', 'kks', 'info'], 'safe'],
            [['pos_x', 'pos_y'], 'number'],
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
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Device::find();

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
            'id' => $this->id,
            'plant_id' => $this->plant_id,
            'location_id' => $this->location_id,
            'state_id' => $this->state_id,
            'value' => $this->value,
            'pos_x' => $this->pos_x,
            'pos_y' => $this->pos_y,
        ]);

        $query->andFilterWhere(['like', 'short_name', $this->short_name])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'kks', $this->kks])
            ->andFilterWhere(['like', 'info', $this->info]);

        return $dataProvider;
    }
}
