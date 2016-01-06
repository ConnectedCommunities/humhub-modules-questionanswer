<?php
namespace humhub\modules\questionanswer\widgets;

use Yii;
use humhub\modules\user\models\User;


/**
 * ProfileWidget.
 * Displays the user profile
 *
 * @package application.modules.questionanswer.widgets
 * @since 0.5
 * @author Luke
 */
class DeleteButtonWidget extends \yii\base\Widget
{

    /**
     * The ID of the model to delete
     *
     * @var Int
     */
    public $id;

    /**
     * The string for the delete route
     *
     * @var String
     */
    public $deleteRoute;

    public $title;
    public $message;


    /**
     * Executes the widget.
     */
    public function run() {

        return $this->render('deleteButton', array(
            'id' => $this->id,
            'deleteRoute' => $this->deleteRoute,
            'title' => $this->title,
            'message' => $this->message,
        ));
    }

}

?>
