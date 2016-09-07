<?php

namespace humhub\modules\questionanswer\widgets;

use humhub\components\Widget;
use yii\base\Exception;

/**
 * CommentFormWidget. 
 * Displays the comment form
 * 
 * @package application.modules.questionanswer.widgets
 * @since 0.5
 * @author Luke
 */
class CommentFormWidget extends Widget {

    /**
     * The comment model
     *
     * @var model
     */
    public $model;


    /**
     * The id of parent
     *
     * @var int
     */
    public $parent_id;


    /**
     * The id of question
     *
     * @var int
     */
    public $question_id;

    /**
     *
     * Add id to form for validation of unique form
     *
     * @var string
     */
    public $id;
    /**
     * Executes the widget.
     */
    public function run() {

        if(empty($this->id)) {
            throw new Exception('Empty id parameter');
        }

        return $this->render('commentForm', array(
            'model' => $this->model,
            'question_id' => $this->question_id,
            'parent_id' => $this->parent_id,
            'id' => $this->id,
        ));
    }

}

?>
