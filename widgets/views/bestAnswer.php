<?php
if($accepted_answer) {
	$btnClass = "btn-info";
	$text = "Accepted response";
} else {
	$btnClass = "btn-default";
	$text = "Mark as Accepted response";
} 

if(Yii::$app->user->id == $author) {
	$form= \yii\bootstrap\ActiveForm::begin(array(
		'id'=>'question-votes-vote_best_answer-form',
		'enableAjaxValidation'=>false,
		'action' =>  \yii\helpers\Url::toRoute(('//questionanswer/vote/create')),
	)); 

	echo $form->field($model,'should_open_question')->hiddenInput(array('type'=>"hidden", 'value' => $should_open_question))->label(false);
	echo $form->field($model,'post_id')->hiddenInput(array('type'=>"hidden", 'value' => $post_id))->label(false);
	echo $form->field($model,'vote_on')->hiddenInput(array('type'=>"hidden", 'value' => "answer"))->label(false);
	echo $form->field($model,'vote_type')->hiddenInput(array('type'=>"hidden", 'value' => "accepted_answer"))->label(false);

	echo \yii\helpers\Html::tag('button','<i class="fa fa-check"></i> ' . $text, array('class'=> "btn {$btnClass} btn-sm", 'type'=>'submit', 'style' => 'margin-top:5px;'));
} else if($accepted_answer) {
	echo "<span class=\"label label-success\" style=\"padding:5px;\"><i class=\"fa fa-check\"></i> $text</span>"; 
	echo "<br />";
}


if(Yii::$app->user->id == $author) {
	\yii\bootstrap\ActiveForm::end();
}
?>
