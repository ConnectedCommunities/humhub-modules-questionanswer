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
 * ProfileWidget.
 * Displays the user profile
 *
 * @package application.modules.questionanswer.widgets
 */
class AnswerFormWidget extends HWidget {

    public $question;
    public $answer;

    /**
     * Executes the widget.
     */
    public function run() {

        $this->render('answerForm', array(
            'question' => $this->question,
            'answer' => $this->answer,
        ));
    }

}

?>
