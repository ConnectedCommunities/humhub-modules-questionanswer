<?php
/* @var $this QuestionController */
/* @var $model Question */
/* @var $form CActiveForm */
?>

<div class="form">
	<div class="panel-body">
		<?php $form = \yii\widgets\ActiveForm::begin([
//			'action' => \yii\helpers\Url::to(['question/update'])
		]); ?>

		<p class="note">Fields with <span class="required">*</span> are required.</p>

		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo $form->field($model, 'question_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->field($model, 'parent_id'); ?>
		</div>

		<div class="row">
			<?php echo $form->field($model, 'post_title'); ?>
		</div>

		<div class="row">
			<?php echo $form->field($model, 'post_text')->textArea(['rows' => 6]); ?>
		</div>

		<div class="row">
			<?php echo $form->field($model, 'post_type'); ?>
		</div>

		<div class="row">
			<?php echo $form->field($model, 'created_at'); ?>
		</div>

		<div class="row">
			<?php echo $form->field($model, 'created_by'); ?>
		</div>

		<div class="row">
			<?php echo $form->field($model, 'updated_at'); ?>
		</div>

		<div class="row">
			<?php echo $form->field($model, 'updated_by'); ?>
		</div>

		<div class="row buttons">
			<?php echo \yii\helpers\Html::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>

		<?php \yii\widgets\ActiveForm::end(); ?>
	</div>
</div><!-- form -->
