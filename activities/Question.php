<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\questionanswer\activities;

use humhub\modules\activity\components\BaseActivity;

/**
 * Description of SpaceCreated
 *
 * @author luke
 */
class Question extends BaseActivity
{

    /**
     * @inheritdoc
     */
    public $moduleId = 'questionanswer';

    /**
     * @inheritdoc
     */
    public $viewName = 'QuestionCreated';
}
