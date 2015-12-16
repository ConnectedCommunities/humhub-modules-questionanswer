<?php

namespace humhub\modules\questionanswer\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use humhub\modules\questionanswer\models\Question;

class QuestionSearch extends Question
{

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
        $query = Question::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id]);
//        $query->andFilterWhere(['points' => $this->points]);
//        $query->andFilterWhere(['like', 'name', $this->name])
//            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}