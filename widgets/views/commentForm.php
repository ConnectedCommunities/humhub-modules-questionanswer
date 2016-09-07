<?php $form=\yii\bootstrap\ActiveForm::begin(array(
    'id'=> $id,
    'enableAjaxValidation'=>false,
    'action' => \yii\helpers\Url::toRoute('//questionanswer/comment/create'),
)); ?>

<?php echo $form->field($model,'post_text')->textarea(array('id' => "contentForm_answersText", 'rows' => '2', 'style' => 'height: auto !important;', "class" => "form-control contentForm", "tabindex" => "2", "placeholder" => "Add comment..."))->label(false); ?>
<?php echo $form->field($model,'question_id')->hiddenInput(array('type'=>"hidden", 'value' => $question_id))->label(false); ?>
<?php echo $form->field($model,'parent_id')->hiddenInput(array('type'=>"hidden", 'value' => $parent_id))->label(false); ?>
<?php echo \yii\helpers\Html::submitButton('Submit', array('class' => ' btn btn-info pull-right', 'style' => 'margin-top: 5px;')); ?>
<?php \yii\bootstrap\ActiveForm::end(); ?>