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

    public $question;
    public $answer;

    /**
     * Executes the widget.
     */
    public function run() {
        
        $this->render('answerForm', array(
            'question' => $this->question,
            'answer' => $this->answer,
        ));
    }

}

?>
