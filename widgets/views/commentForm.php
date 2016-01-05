<?php $form = \yii\widgets\ActiveForm::begin([
    'action' => \yii\helpers\Url::toRoute(['comment/create'])
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
echo $form->field($model, 'question_id', [])->hiddenInput(['value' => $question_id])->label(false);
echo $form->field($model, 'parent_id', [])->hiddenInput(['value' => $parent_id])->label(false);
?>


<?php //echo $form->error($model,'post_text'); ?>
<?php //echo $form->textArea($model,'post_text',array('id' => "contentForm_answersText", 'rows' => '2', 'style' => 'height: auto !important;', "class" => "form-control contentForm", "tabindex" => "2", "placeholder" => "Add comment...")); ?>
<?php //echo $form->hiddenField($model,'question_id',array('type'=>"hidden", 'value' => $question_id)); ?>
<?php //echo $form->hiddenField($model,'parent_id',array('type'=>"hidden", 'value' => $parent_id)); ?>
<?php echo \yii\helpers\Html::submitButton('Submit', array('class' => ' btn btn-info pull-right', 'style' => 'margin-top: 5px;')); ?>

<?php \yii\widgets\ActiveForm::end(); ?>