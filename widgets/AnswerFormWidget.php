<?php

namespace humhub\modules\questionanswer\widgets;

use humhub\components\Widget;

/**
 * ProfileWidget. 
 * Displays the user profile
 * 
 * @package application.modules.questionanswer.widgets
 * @since 0.5
 * @author Luke
 */
class AnswerFormWidget extends Widget {

    public $question;
    public $answer;

    /**
     * Executes the widget.
     */
    public function run() {

        return $this->render('answerForm', array(
            'question' => $this->question,
            'answer' => $this->answer,
        ));
    }

}

?>
