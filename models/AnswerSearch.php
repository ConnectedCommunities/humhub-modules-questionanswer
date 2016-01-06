<?php
/**
 * Created by PhpStorm.
 * User: byron
 * Date: 6/01/2016
 * Time: 10:47 AM
 */

namespace humhub\modules\questionanswer\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class AnswerSearch extends Answer
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
        $query = Answer::find();
        $query->andFilterWhere(['post_type' => 'answer']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id]);

        return $dataProvider;
    }
}