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
     * Executes the widget.
     */
    public function run() {

        $this->render('commentForm', array(
            'model' => $this->model,
            'parent_id' => $this->parent_id
        ));
    }

}

?>
