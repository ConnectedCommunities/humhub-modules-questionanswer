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
 */

/**
 * VoteWidget. 
 * Displays the vote 
 * 
 * @package application.modules.questionanswer.widgets
 */
class BestAnswerWidget extends HWidget {

    public $post_id;
    public $author;
    public $model; 
    public $accepted_answer;

    /**
     * Executes the widget.
     */
    public function run() {

        $this->render('bestAnswer', array(
            'post_id' => $this->post_id, 
            'author' => $this->author, 
            'model' => $this->model,
            'accepted_answer' => $this->accepted_answer,
            'should_open_question' => 1 // we want to get redirected back to the question
        ));

    }

}

?>
