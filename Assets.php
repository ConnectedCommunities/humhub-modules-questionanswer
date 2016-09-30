<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.org/licences
 */

namespace humhub\modules\questionanswer;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{

    public $css = [
        'css/questionanswer.css',
    ];
    public $js = [
        'js/typeahead/typeahead.bundle.js',
        'js/typeahead/typeahead.jquery.js',
    ];

    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . '/assets';
        parent::init();
    }

}
