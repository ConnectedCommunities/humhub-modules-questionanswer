<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace humhub\modules\questionanswer\widgets;

use humhub\components\Widget;

/**
 * VoteWidget. 
 * Displays the vote 
 * 
 * @package application.modules.questionanswer.widgets
 * @since 0.5
 * @author Ben
 */
class VoteButtonWidget extends Widget {

    public $post_id;
    public $model; 
    public $vote_on;
    public $vote_type;
    public $classObj;
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
            'class' => $this->classObj,
            'should_open_question' => $this->should_open_question
        ));
    }

}

?>
