<?php
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
