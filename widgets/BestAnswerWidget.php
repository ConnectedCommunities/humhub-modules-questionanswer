<?php

/**
 * VoteWidget. 
 * Displays the vote 
 * 
 * @package application.modules.questionanswer.widgets
 * @since 0.5
 * @author Ben
 */
class BestAnswerWidget extends HWidget {

    public $post_id;
    public $author;
    public $model; 
    public $accepted_answer;

    /**
     * Executes the widget.
     */
    public function run() {

        $this->render('bestAnswer', array(
            'post_id' => $this->post_id, 
            'author' => $this->author, 
            'model' => $this->model,
            'accepted_answer' => $this->accepted_answer,
        ));

    }

}

?>
