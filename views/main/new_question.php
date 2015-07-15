<?php
/* @var $this QuestionController */
/* @var $model Question */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'question-new_question-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<strong>Ask</strong> a new question
	            </div>
	            <div class="panel-body">
	            	<?php echo $form->errorSummary($model); ?>
            		<?php echo $form->error($model,'post_title'); ?>
            		<?php echo $form->textArea($model,'post_title',array('id'=>'contentForm_question', 'class' => 'form-control autosize contentForm', 'rows' => '1', "placeholder" => "Ask something...")); ?>

                    
                    <div class="contentForm_options">
                    	<?php echo $form->error($model,'post_text'); ?>
                    	<?php echo $form->textArea($model,'post_text',array('id' => "contentForm_answersText", 'rows' => '5', 'style' => 'height: auto !important;', "class" => "form-control contentForm", "placeholder" => "Question details...")); ?>
                    <br />
                        <?php echo CHtml::textarea('Tags', null, array('class' => 'form-control autosize contentForm', 'rows' => '1', "placeholder" => "Tags... Specify at least one tag for your question")); ?>
                    </div>
					<?php echo CHtml::submitButton('Submit', array('class' => ' btn btn-info pull-right', 'style' => 'margin-top: 5px;')); ?>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Related</strong> Questions</div>
                <div class="list-group">
                    <a class="list-group-item" href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a>
                    <a class="list-group-item" href="#">Nunc pharetra blandit sapien, et tempor nisi.</a>
                    <a class="list-group-item" href="#">Duis finibus venenatis commodo. </a>
                </div>
                <br>
            </div>
        </div>
   </div>
</div>

<?php $this->endWidget(); ?>
