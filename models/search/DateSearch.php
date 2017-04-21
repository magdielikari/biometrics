<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Date;

/**
 * DateSearch represents the model behind the search form about `app\models\Date`.
 */
class DateSearch extends Date
{
    public $global;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'number_day', 'number_weeks_day', 'number_month', 'year', 'number_years_day', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['weekday','global', 'month'], 'safe'],
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
        $query = Date::find();

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
            'id' => $this->id,
            'number_day' => $this->number_day,
            'number_weeks_day' => $this->number_weeks_day,
            'number_month' => $this->number_month,
            'year' => $this->year,
            'number_years_day' => $this->number_years_day,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);
*/

        $query->orFilterWhere(['like', 'weekday', $this->global])
              ->orFilterWhere(['like', 'number_day', $this->global])
              ->orFilterWhere(['like', 'number_month', $this->global])
              ->orFilterWhere(['like', 'year', $this->global])
              ->orFilterWhere(['like', 'number_years_day', $this->global])
              ->orFilterWhere(['like', 'month', $this->global]);
/*
        $query->andFilterWhere(['like', 'weekday', $this->weekday])
            ->andFilterWhere(['like', 'month', $this->month]);
*/
        return $dataProvider;
    }
}
