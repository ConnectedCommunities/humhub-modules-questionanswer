<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016  Queensland University of Technology
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
 *
 *
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.org/licences GNU AGPL v3
 *
 */

namespace humhub\modules\questionanswer\widgets;

use humhub\components\Widget;
use yii\base\Exception;

/**
 * CommentFormWidget. 
 * Displays the comment form
 * 
 * @package application.modules.questionanswer.widgets
 * @since 0.5
 * @author Luke
 */
class CommentFormWidget extends Widget {

    /**
     * The comment model
     *
     * @var model
     */
    public $model;


    /**
     * The id of parent
     *
     * @var int
     */
    public $parent_id;


    /**
     * The id of question
     *
     * @var int
     */
    public $question_id;

    /**
     *
     * Add id to form for validation of unique form
     *
     * @var string
     */
    public $id;
    /**
     * Executes the widget.
     */
    public function run() {

        if(empty($this->id)) {
            throw new Exception('Empty id parameter');
        }

        return $this->render('commentForm', array(
            'model' => $this->model,
            'question_id' => $this->question_id,
            'parent_id' => $this->parent_id,
            'id' => $this->id,
        ));
    }

}

?>
