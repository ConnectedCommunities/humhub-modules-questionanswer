<?php

/**
 * UserSearchResultWidget displays a user inside the search results.
 * The widget will be called by the User Model getSearchOutput method.
 *
 * @package humhub.modules_core.user.widgets
 * @since 0.5
 * @author Luke
 */
class QuestionSearchResultWidget extends HWidget {

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

        $this->render('searchResult', array(
            'question' => $this->question,
        ));
    }

}

?>
