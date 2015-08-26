<?php

/**
 * CommentFormWidget. 
 * Displays the comment form
 * 
 * @package application.modules.questionanswer.widgets
 * @since 0.5
 * @author Luke
 */
class CommentFormWidget extends HWidget {

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
     * Executes the widget.
     */
    public function run() {

        $this->render('commentForm', array(
            'model' => $this->model,
            'question_id' => $this->question_id,
            'parent_id' => $this->parent_id
        ));
    }

}

?>
