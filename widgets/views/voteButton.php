<?php $form=\yii\bootstrap\ActiveForm::begin(array(
    'id'=>'question-votes-_vote-form',
    'enableAjaxValidation'=>false,
    'action' => \yii\helpers\Url::toRoute('//questionanswer/vote/create')
)); ?>
<?php
if(!isset($btnClass)) {
	$btnClass = "btn btn-default btn-xs";
}
?>
<?php echo $form->field($model,'should_open_question')->hiddenInput(array('type'=>"hidden", 'value' => $should_open_question))->label(false); ?>
<?php echo $form->field($model,'post_id')->hiddenInput(array('type'=>"hidden", 'value' => $post_id))->label(false); ?>
<?php echo $form->field($model,'vote_on')->hiddenInput(array('type'=>"hidden", 'value' => $vote_on))->label(false); ?>
<?php echo $form->field($model,'vote_type')->hiddenInput(array('type'=>"hidden", 'value' => $vote_type))->label(false); ?>
<?php
    if ($vote_type='up') {
        echo \yii\helpers\Html::tag('button', '<i class="fa fa-thumbs-o-up"></i>', array('title'=>'like', 'class'=> $btnClass . " btn-like " . $class, 'type'=>'submit'));
    }else{
        echo \yii\helpers\Html::tag('button', '<i class="fa fa-thumbs-o-up"></i>', array('class'=> $btnClass . " btn-like " . $class, 'type'=>'submit'));
    }
?>
<?php \yii\bootstrap\ActiveForm::end(); ?>
