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
    public $global;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_id', 'date_id', 'counter_record', 'counter_worked', 'min_record', 'max_record', 'average_record', 'time_worked', 'time_record', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['global'], 'safe']
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
/*
        $query->andFilterWhere([
            'person_id' => $this->person_id,
            'date_id' => $this->date_id,
            'counter_record' => $this->counter_record,
            'counter_worked' => $this->counter_worked,
            'min_record' => $this->min_record,
            'max_record' => $this->max_record,
            'average_record' => $this->average_record,
            'time_worked' => $this->time_worked,
            'time_record' => $this->time_record,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);
*/
        $query->joinWith('date');
        $query->joinWith('person');

        $query->orFilterWhere(['like','person.name',$this->global])
              ->orFilterWhere(['like','date.weekday',$this->global])
              ->orFilterWhere(['like','date.number_day',$this->global])
              ->orFilterWhere(['like','date.month',$this->global])
              ->orFilterWhere(['like','date.year',$this->global]);

        return $dataProvider;
    }
}
