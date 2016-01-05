<?php
namespace humhub\modules\questionanswer\widgets;

use Yii;
use humhub\modules\user\models\User;
use humhub\models\Setting;

/**
 * VoteWidget. 
 * Displays the vote 
 * 
 * @package application.modules.questionanswer.widgets
 * @since 0.5
 * @author Ben
 */
class VoteButtonWidget extends \yii\base\Widget
{
    public $post_id;
    public $model; 
    public $vote_on;
    public $vote_type;
    public $class;
    public $should_open_question;
    /**
     * Executes the widget.
     */
    public function run() {

        return $this->render('voteButton', array(
            'post_id' => $this->post_id,
            'model' => $this->model, 
            'vote_on' => $this->vote_on, 
            'vote_type' => $this->vote_type,
            'class' => $this->class,
            'should_open_question' => $this->should_open_question
        ));
    }

}

?>
