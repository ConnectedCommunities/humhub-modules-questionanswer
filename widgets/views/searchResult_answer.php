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

use yii\helpers\Url;
use yii\helpers\Html;
use humhub\libs\Helpers;

$question = $answer->question;
?>
<p>
    <a href=""><b>Q: <?php echo Html::a(Html::encode($question->post_title), Url::toRoute(['/questionanswer/question/view', 'id' => $question->id])); ?></b></a>
</p>
<p>
    <span class="content" style="border-left:2px solid #ccc; padding-top:2px; padding-bottom:2px; padding-left:5px; margin-left: 5px;">
        A: <?php echo Html::a(Html::encode(Helpers::truncateText($answer->post_text, 150)), Url::toRoute(['/questionanswer/question/view', 'id' => $question->id])); ?>
    </span>
</p>
