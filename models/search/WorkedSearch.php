<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Worked;

/**
 * WorkedSearch represents the model behind the search form about `app\models\Worked`.
 */
class WorkedSearch extends Worked
{
    public $global;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'in', 'out', 'created_at', 'created_by', 'updated_at', 'updated_by', 'person_id', 'date_id'], 'integer'],
            [['global'],'safe'],
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
        $query = Worked::find();

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
            'in' => $this->in,
            'out' => $this->out,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'person_id' => $this->person_id,
            'date_id' => $this->date_id,
        ]);
*/
        $query->joinWith('date');
        $query->joinWith('person');

        $query->orFilterWhere(['like','date.weekday',$this->global])
              ->orFilterWhere(['like','date.number_day',$this->global])
              ->orFilterWhere(['like','date.month',$this->global])
              ->orFilterWhere(['like','date.year',$this->global])
              ->orFilterWhere(['like','person.name',$this->global]);

        return $dataProvider;
    }
}
