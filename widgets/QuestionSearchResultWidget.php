<?php

namespace humhub\modules\questionanswer\widgets;

use humhub\components\Widget;

/**
 * UserSearchResultWidget displays a user inside the search results.
 * The widget will be called by the User Model getSearchOutput method.
 *
 * @package application.modules.questionanswer.widgets
 * @since 0.5
 * @author Luke
 */
class QuestionSearchResultWidget extends Widget {

    /**
     * The user object
     *
     * @var User
     */
    public $question;

    /**
     * Executes the widget.
     */
    public function run() {

        return $this->render('searchResult', array(
            'question' => $this->question,
        ));
    }

}

?>
