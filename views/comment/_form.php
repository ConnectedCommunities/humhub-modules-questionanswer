<?php
/* @var $this CommentController */
/* @var $model Comment */
/* @var $form CActiveForm */
?>

<?php $form = \yii\widgets\ActiveForm::begin([
//			'action' => \yii\helpers\Url::to(['question/update'])
]); ?>


<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->field($model, 'question_id'); ?>
<?php echo $form->field($model, 'parent_id'); ?>
<?php echo $form->field($model, 'post_title'); ?>
<?php echo $form->field($model, 'post_text')->textArea(); ?>
<?php echo $form->field($model, 'post_type'); ?>
<?php echo $form->field($model, 'created_at'); ?>
<?php echo $form->field($model, 'created_by'); ?>
<?php echo $form->field($model, 'updated_at'); ?>
<?php echo $form->field($model, 'updated_by'); ?>
<?php echo \yii\helpers\Html::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>

<?php \yii\widgets\ActiveForm::end(); ?>