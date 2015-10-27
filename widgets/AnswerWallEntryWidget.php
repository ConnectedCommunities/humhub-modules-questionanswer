<?php

/**
 * QuestionWallEntryWidget is used to display a question inside the stream.
 *
 * This Widget will used by the Question Model in Method getWallOut().
 *
 * @package humhub.modules.questionanswer.widgets
 * @since 0.5
 * @author Luke
 */
class AnswerWallEntryWidget extends HWidget {

    public $answer;

    public function run() {

        $this->render('answerWallEntry', array(
            'question' => Question::model()->findByPk($this->answer->question_id),
            'answer' => $this->answer,
            'user' => $this->answer->content->user,
            'contentContainer' => $this->answer->content->container));
    }

}

?>