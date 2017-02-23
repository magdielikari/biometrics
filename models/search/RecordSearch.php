<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Record;

/**
 * RecordSearch represents the model behind the search form about `app\models\Record`.
 */
class RecordSearch extends Record
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_id', 'date_id', 'counter', 'min', 'max', 'average'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Record::find();

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
            'person_id' => $this->person_id,
            'date_id' => $this->date_id,
            'counter' => $this->counter,
            'min' => $this->min,
            'max' => $this->max,
            'average' => $this->average,
        ]);

        return $dataProvider;
    }
}
