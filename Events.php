<?php

namespace humhub\modules\questionanswer;

use humhub\modules\user\models\forms\AccountRegister;
use humhub\modules\email_whitelist\models\EmailWhitelist;
use Yii;
use yii\helpers\Url;

class Events extends \yii\base\Object
{

    public static function onTopMenuInit($event)
    {
        $event->sender->addItem(array(
            'label' => "Q&A",
            'icon' => '<i class="fa fa-stack-exchange"></i>',
            'url' => Url::to(['/questionanswer/question/index']),
            'sortOrder' => 200,
        ));
    }

}