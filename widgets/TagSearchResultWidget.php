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
class TagSearchResultWidget extends Widget {

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

        return $this->render('searchResult_tag', array(
            'tag' => $this->tag,
        ));
    }

}

?>
