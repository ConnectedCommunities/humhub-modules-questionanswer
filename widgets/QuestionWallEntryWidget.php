<?php

namespace humhub\modules\questionanswer\widgets;

use Yii;
use humhub\modules\user\models\User;
use humhub\models\Setting;

/**
 * QuestionWallEntryWidget is used to display a question inside the stream.
 *
 * This Widget will used by the Question Model in Method getWallOut().
 *
 * @package humhub.modules.questionanswer.widgets
 * @since 0.5
 * @author Ben
 */
class QuestionWallEntryWidget extends \humhub\modules\content\widgets\WallEntry
{

    /**
     * NOTE:
     * Humhub have removed the ability to have
     * different views for the Wall Entry and
     * search result.
     */
    public function run() {
        return $this->render('searchResult', array(
            'question' => $this->contentObject,
        ));
    }

}

?>