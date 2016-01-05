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

	echo Html::hiddenInput('should_open_question', $should_open_question); 
	echo Html::hiddenInput('post_id', $post_id); 
	echo Html::hiddenInput('vote_on', "answer");
	echo Html::hiddenInput('vote_type', "accepted_answer"); 

	//**kane
	//echo Html::tag('button', array('class'=> "btn {$btnClass} btn-sm", 'type'=>'submit', 'style' => 'margin-top:5px;'), '<i class="fa fa-check"></i> ' . $text); 
	echo Html::tag('button', '<i class="fa fa-check"></i> ' . $text, array('class'=> "btn {$btnClass} btn-sm", 'type'=>'submit', 'style' => 'margin-top:5px;')); 
} else if($accepted_answer) {
	echo "<span class=\"label label-success\" style=\"padding:5px;\"><i class=\"fa fa-check\"></i> $text</span>"; 
	echo "<br />";
}


if(Yii::$app->user->id == $author) {
	\yii\widgets\ActiveForm::end();
}
?>
