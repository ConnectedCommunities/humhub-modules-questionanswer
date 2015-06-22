
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'question-ask-form',
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
                    <?php echo CHtml::textArea("post_title", "", array('id'=>'contentForm_question', 'class' => 'form-control autosize contentForm', 'rows' => '1', "tabindex" => "1", "placeholder" => "Ask something...")); ?>
                    <div class="contentForm_options">
                        <?php echo CHtml::textArea("post_text", "", array('id' => "contentForm_answersText", 'rows' => '5', 'style' => 'height: auto !important;', "class" => "form-control contentForm", "tabindex" => "2", "placeholder" => "Question details...")); ?>
                    </div>

					<?php echo CHtml::submitButton('Submit', array('name' => 'question')); ?>
                </div>
            </div>

        </div>
   </div>
</div>

<?php $this->endWidget(); ?>