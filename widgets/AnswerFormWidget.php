<?php
namespace humhub\modules\questionanswer\widgets;

use Yii;
use humhub\modules\user\models\User;
use humhub\models\Setting;

/**
 * ProfileWidget. 
 * Displays the user profile
 * 
 * @package application.modules.questionanswer.widgets
 * @since 0.5
 * @author Luke
 */
class AnswerFormWidget extends \yii\base\Widget
{
    public $question;
    public $answer;

    /**
     * Executes the widget.
     */
    public function run() {

        $this->render('answerForm', array(
            'question' => $this->question,
            'answer' => $this->answer,
        ));
    }

}

?>
