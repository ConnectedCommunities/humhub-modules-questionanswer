<?php

/**
 * UserSearchResultWidget displays a user inside the search results.
 * The widget will be called by the User Model getSearchOutput method.
 *
 * @package application.modules.questionanswer.widgets
 * @since 0.5
 * @author Luke
 */
class TagSearchResultWidget extends HWidget {

    /**
     * The tag object
     *
     * @var Tag
     */
    public $tag;

    /**
     * Executes the widget.
     */
    public function run() {

        $this->render('searchResult_tag', array(
            'tag' => $this->tag,
        ));
    }

}

?>
