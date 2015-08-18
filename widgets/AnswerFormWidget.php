<?php

/**
 * ProfileWidget. 
 * Displays the user profile
 * 
 * @package application.modules.questionanswer.widgets
 * @since 0.5
 * @author Luke
 */
class AnswerFormWidget extends HWidget {

    /**
     * The user object
     *
     * @var User
     */
    public $model;

    /**
     * Executes the widget.
     */
    public function run() {

        $this->render('answerForm', array(
            'model' => $this->model,
        ));
    }

}

?>
