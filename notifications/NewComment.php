<?php
/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace humhub\modules\questionanswer\notifications;

use Yii;
use humhub\modules\notification\components\BaseNotification;
use yii\helpers\Html;

class NewComment extends BaseNotification
{

    /**
     * @inheritdoc
     */
    public $moduleId = "questionanswer";

    /**
     * @inheritdoc
     */
    public $viewName = "newComment";

    /**
     * @inheritdoc
     */
    public function html()
    {
        return Html::tag('strong', Html::encode($this->originator->displayName))
            . " commented on your post in "
            . Html::tag('strong', Html::encode($this->source->question->post_title));
    }

}

