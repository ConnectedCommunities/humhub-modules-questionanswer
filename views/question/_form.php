<?php
/* @var $this CommentController */
/* @var $model \humhub\modules\questionanswer\models\QAComment */
?>

<div class="form">

	<?php $form= \yii\bootstrap\ActiveForm::begin(array(
		'id'=>'comment-form',
		'enableAjaxValidation'=>false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="col-xs-12">
			<?php echo $form->field($model, 'post_title')->textInput(array('rows'=>6, 'cols'=>50)); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<?php echo $form->field($model, 'post_text')->textInput(array('rows'=>6, 'cols'=>50)); ?>
		</div>
	</div>

	<div class="row buttons">
		<div class="col-xs-12">
			<?php echo \yii\helpers\Html::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	</div>

	<?php \yii\bootstrap\ActiveForm::end(); ?>

</div><!-- form -->