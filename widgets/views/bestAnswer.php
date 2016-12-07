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

use yii\helpers\Html;

if($accepted_answer) {
	$btnClass = "btn-info";
	$text = "Accepted Answer";
} else {
	$btnClass = "btn-default";
	$text = "Mark as Accepted Answer";
}

if(Yii::$app->user->id == $author) {
	$form = \yii\widgets\ActiveForm::begin($config = array(
		'id'=>'question-votes-vote_best_answer-form',
		'enableAjaxValidation'=>false,
		'action' => \yii\helpers\Url::toRoute('vote/create')
	));

	echo $form->field($model, 'should_open_question')->hiddenInput(['value' => $should_open_question])->label(false);
	echo $form->field($model, 'post_id')->hiddenInput(['value' => $post_id])->label(false);
	echo $form->field($model, 'vote_on')->hiddenInput(['value' => 'answer'])->label(false);
	echo $form->field($model, 'vote_type')->hiddenInput(['value' => 'accepted_answer'])->label(false);

	echo Html::tag('button', '<i class="fa fa-check"></i> ' . $text, array('class'=> "btn {$btnClass} btn-sm", 'type'=>'submit', 'style' => 'margin-top:5px;'));

} else if($accepted_answer) {
	echo "<span class=\"label label-success\" style=\"padding:5px;\"><i class=\"fa fa-check\"></i> $text</span>"; 
	echo "<br />";
}


if(Yii::$app->user->id == $author) {
	\yii\widgets\ActiveForm::end();
}
?>
