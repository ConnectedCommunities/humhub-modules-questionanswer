<?php $form = \yii\widgets\ActiveForm::begin([
    'action' => \yii\helpers\Url::to('comment/create')
]); ?>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->field($model, 'post_text', array(
    'options' => [
        'id' => "contentForm_answersText",
        'style' => 'height: auto !important;',
        "class" => "contentForm",
        "tabindex" => "2",
    ]
))->textArea(['rows' => 2, 'placeholder' => 'Add comment...'])->label(false);
?>
<?php
$form->field($model, 'question_id', array(
    'options' => [
        'value' => $question_id
    ]
))->hiddenInput();

$form->field($model, 'parent_id', array(
    'options' => [
        'value' => $parent_id
    ]
))->hiddenInput();
?>


<?php //echo $form->error($model,'post_text'); ?>
<?php //echo $form->textArea($model,'post_text',array('id' => "contentForm_answersText", 'rows' => '2', 'style' => 'height: auto !important;', "class" => "form-control contentForm", "tabindex" => "2", "placeholder" => "Add comment...")); ?>
<?php //echo $form->hiddenField($model,'question_id',array('type'=>"hidden", 'value' => $question_id)); ?>
<?php //echo $form->hiddenField($model,'parent_id',array('type'=>"hidden", 'value' => $parent_id)); ?>
<?php echo \yii\helpers\Html::submitButton('Submit', array('class' => ' btn btn-info pull-right', 'style' => 'margin-top: 5px;')); ?>

<?php \yii\widgets\ActiveForm::end(); ?>