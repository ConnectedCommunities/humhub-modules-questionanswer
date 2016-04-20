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
class QuestionWallEntryWidget extends HWidget {

    public $question;

    public function run() {
        $this->render('entry', array('question' => $this->question,
            'user' => $this->question->content->user,
            'contentContainer' => $this->question->content->container));
    }

}

?>