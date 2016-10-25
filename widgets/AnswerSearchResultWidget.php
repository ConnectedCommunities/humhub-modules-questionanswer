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
 * UserSearchResultWidget displays a user inside the search results.
 * The widget will be called by the User Model getSearchOutput method.
 *
 * @package application.modules.questionanswer.widgets
 * @since 0.5
 * @author Luke
 */
class AnswerSearchResultWidget extends Widget {

    /**
     * The user object
     *
     * @var User
     */
    public $answer;

    public $question;

    /**
     * Executes the widget.
     */
    public function run() {
        if(!empty($this->question)) {
            return $this->render('searchResult_answer', array(
                'question' => $this->question,
                'answer' => $this->answer,
            ));
        }
    }

}

?>
