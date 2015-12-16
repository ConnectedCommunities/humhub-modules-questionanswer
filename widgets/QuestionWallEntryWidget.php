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

    public $question;

    public function run() {

        $this->render('entry', array('question' => $this->question,
            'user' => $this->question->content->user,
            'contentContainer' => $this->question->content->container));
    }

}

?>