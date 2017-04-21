<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Event;

/**
 * EventSearch represents the model behind the search form about `app\models\Event`.
 */
class EventSearch extends Event
{
    public $global;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'year', 'number_years_day', 'unix_time', 'created_at', 'created_by', 'updated_at', 'updated_by', 'person_id'], 'integer'],
            [['event', 'global'], 'safe'],
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
        $query = Event::find();

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
/*
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'year' => $this->year,
            'number_years_day' => $this->number_years_day,
            'unix_time' => $this->unix_time,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'person_id' => $this->person_id,
        ]);
*/

        $query->joinWith('person');

        $query->orFilterWhere(['like', 'year', $this->global])
              ->orFilterWhere(['like', 'number_years_day', $this->global])
              ->orFilterWhere(['like', 'person.name', $this->global]);

/*
        $query->andFilterWhere(['like', 'event', $this->event]);
*/
        return $dataProvider;
    }
}
