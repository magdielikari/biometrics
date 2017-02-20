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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'seconds', 'minutes', 'hours', 'number_day', 'number_weeks_day', 'number_month', 'year', 'number_years_day', 'unix_time', 'persona_id'], 'integer'],
            [['weekday', 'month', 'event'], 'safe'],
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
        $query->andFilterWhere([
            'id' => $this->id,
            'seconds' => $this->seconds,
            'minutes' => $this->minutes,
            'hours' => $this->hours,
            'number_day' => $this->number_day,
            'number_weeks_day' => $this->number_weeks_day,
            'number_month' => $this->number_month,
            'year' => $this->year,
            'number_years_day' => $this->number_years_day,
            'unix_time' => $this->unix_time,
            'persona_id' => $this->persona_id,
        ]);

        $query->andFilterWhere(['like', 'weekday', $this->weekday])
            ->andFilterWhere(['like', 'month', $this->month])
            ->andFilterWhere(['like', 'event', $this->event]);

        return $dataProvider;
    }
}
