<?php


namespace humhub\modules\questionanswer\widgets;

use humhub\components\Widget;
use Yii;
use humhub\models\Setting;
/**
 * Will show the introduction tour
 *
 * @package humhub.modules_core.tour.widgets
 * @since 0.5
 * @author andystrobel
 */
class KnowledgeTourWidget extends Widget
{

    /**
     * Executes the widgets
     */
    public function run()
    {
        if (Yii::$app->user->isGuest)
            return;
        // Active tour flag not set
        if (!isset($_GET['tour'])) {
            return;
        }

        // Tour only possible when we are in a module
        if (Yii::$app->controller->module === null) {
            return;
        }

        // Check if tour is activated by admin and users
        if (Setting::Get('enable', 'tour') == 0 || Yii::$app->user->getIdentity()->getSetting("hideTourPanel", "tour") == 1) {
            return;
        }

        // save current module and controller id's
        $currentModuleId = Yii::$app->controller->module->id;
        $currentControllerId = Yii::$app->controller->id;
        if ($currentModuleId == "questionanswer") {
            return $this->render('tour/guide_interface');
        } elseif ($currentModuleId == "space" && $currentControllerId == "space") {
            return $this->render('tour/guide_spaces', array());
        } elseif ($currentModuleId == "user" && $currentControllerId == "profile") {
            return $this->render('tour/guide_profile', array());
        } elseif ($currentModuleId == "admin" && $currentControllerId == "module") {
            return $this->render('tour/guide_administration', array());
        } elseif ($currentModuleId == "chat" && $currentControllerId == "chat") {
            return $this->render('tour/guide_chat', array());
        }
    }

    /**
     * load needed resources files
     */
    public function loadResources(\yii\web\View $view)
    {
        $view->registerJsFile('@web/resources/tour/bootstrap-tour.min.js');
        $view->registerCssFile('@web/resources/tour/bootstrap-tour.min.css');
    }

}

?>
