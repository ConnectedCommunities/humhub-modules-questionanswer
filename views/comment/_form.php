<?php
/* @var $this CommentController */
/* @var $model Comment */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
    	<div class="col-xs-12">
		<?php echo $form->labelEx($model,'question_id'); ?>
		<?php echo $form->textField($model,'question_id'); ?>
		<?php echo $form->error($model,'question_id'); ?>
        </div>
	</div>

	<div class="row">
    	<div class="col-xs-12">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->textField($model,'parent_id'); ?>
		<?php echo $form->error($model,'parent_id'); ?>
        </div>
	</div>

	<div class="row">
    	<div class="col-xs-12">
		<?php echo $form->labelEx($model,'post_title'); ?>
		<?php echo $form->textField($model,'post_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'post_title'); ?>
        </div>
	</div>

	<div class="row">
    	<div class="col-xs-12">
		<?php echo $form->labelEx($model,'post_text'); ?>
		<?php echo $form->textArea($model,'post_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'post_text'); ?>
        </div>
	</div>

	<div class="row">
    	<div class="col-xs-12">
		<?php echo $form->labelEx($model,'post_type'); ?>
		<?php echo $form->textField($model,'post_type',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'post_type'); ?>
        </div>
	</div>

	<div class="row">
    	<div class="col-xs-12">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
        </div>
	</div>

	<div class="row">
    	<div class="col-xs-12">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by'); ?>
		<?php echo $form->error($model,'created_by'); ?>
        </div>
	</div>

	<div class="row">
    	<div class="col-xs-12">
		<?php echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
		<?php echo $form->error($model,'updated_at'); ?>
        </div>
	</div>

	<div class="row">
    	<div class="col-xs-12">
		<?php echo $form->labelEx($model,'updated_by'); ?>
		<?php echo $form->textField($model,'updated_by'); ?>
		<?php echo $form->error($model,'updated_by'); ?>
        </div>
	</div>

	<div class="row buttons">
    	<div class="col-xs-12">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->