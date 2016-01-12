<?php

namespace humhub\modules\questionanswer\widgets;

use Yii;
use humhub\modules\user\models\User;
use humhub\models\Setting;

/**
 * UserSearchResultWidget displays a user inside the search results.
 * The widget will be called by the User Model getSearchOutput method.
 *
 * @package application.modules.questionanswer.widgets
 * @since 0.5
 * @author Luke
 */
class QuestionSearchResultWidget extends \humhub\modules\content\widgets\WallEntry
{

    /**
     * Executes the widget.
     */
    public function run() {

//        return "SearchResultWidget";

        return $this->render('searchResult', array(
            'question' => $this->contentObject
        ));
    }

}

?>
