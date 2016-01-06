<?php
/**
 * Created by PhpStorm.
 * User: byron
 * Date: 6/01/2016
 * Time: 10:51 AM
 */

namespace humhub\modules\questionanswer\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use humhub\modules\questionanswer\models\Comment;


class CommentSearch extends Comment
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
        $query = Comment::find();
        $query->andFilterWhere(['post_type' => 'comment']);

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