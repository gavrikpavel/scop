<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;

class RecordSearch extends Record
{
    public function rules()
    {
        return [
            [['id', 'plant_id'], 'integer'],
            [['changed'], 'boolean'],
            [['text', 'comment', 'user_id'], 'string'],
            [['date_event', 'date', 'device_id'], 'safe'],
        ];
    }

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
        $query = Record::find()->indexBy('id');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        // Сортировка по-умолчанию - по убыванию
        if (empty($dataProvider->sort->getAttributeOrders())) {
            $dataProvider->query->orderBy(['date_event' => SORT_DESC]);
        }

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Массивы диапазона дат
        $dateRange = $this->getRange($this->date);
        $dateEventRange = $this->getRange($this->date_event);

        // Фильтр по совпадению из выпадающего списка
        $query->andFilterWhere([
            'id' => $this->id,
            'plant_id' => $this->plant_id,
            'user_id' => $this->user_id,
            'changed' => $this->changed,
        ]);

        // Фильтр по совпадению из строки поиска
        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        // Фильтр по диапазону дат из DateTimePicker
        $query->andFilterWhere(['>=', 'date', $dateRange[0]])
            ->andFilterWhere(['<=', 'date', $dateRange[1]])
            ->andFilterWhere(['>=', 'date_event', $dateEventRange[0]])
            ->andFilterWhere(['<=', 'date_event', $dateEventRange[1]]);

        // Фильтр по массиву устройств из Multiple Select2
        $query->andFilterWhere([
            'device_id' => $this->getIdDevices($this->device_id),
        ]);

        return $dataProvider;
    }

    /**
     * Обработка строки диапазона дат из DateTimePicker
     * Возвращает массив [dateFrom, dateTo]
     * @param $stringRange
     * @return array
     */
    public function getRange($stringRange)
    {
        return StringHelper::explode(strip_tags($stringRange), ' -- ');
    }

    /**
     * Обработка массива устройств из Multiple Select2
     * @param $ids
     * @return array
     */
    public function getIdDevices($ids)
    {
        if (is_null($ids) | $ids === [] | empty($ids)) {
            return [];
        }
        else {
            $arrId = array_values($ids);
            foreach ($arrId as &$id) {
                $id = intval(strip_tags($id));
            }
            unset($id); // разорвать ссылку на последний элемент
            return $arrId;
        }
    }
}