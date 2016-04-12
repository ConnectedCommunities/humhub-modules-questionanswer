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
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<strong>Ask</strong> a new question
	            </div>
	            <div class="panel-body">
	            	<?php echo $form->errorSummary($model); ?>
            		<?php echo $form->error($model,'post_title'); ?>
            		<?php echo $form->textArea($model,'post_title',array('id'=>'contentForm_question', 'class' => 'form-control autosize contentForm', 'rows' => '1', "placeholder" => "Ask something...")); ?>
                    <?php echo $form->hiddenField($model, 'containerClass', array('value' => 'Space')); ?>
                    <?php echo $form->hiddenField($model, 'containerGuid', array('value' => '204a13c6-db8e-4cd9-9e81-66055e1b1a50')); ?>

                    <div class="contentForm_options">
                    	<?php echo $form->error($model,'post_text'); ?>
                    	<?php echo $form->textArea($model,'post_text',array('id' => "contentForm_answersText", 'rows' => '5', 'style' => 'height: auto !important;', "class" => "form-control contentForm", "placeholder" => "Question details...")); ?>
                    <br />
                        <?php echo CHtml::textField('Tags', null, array('class' => 'form-control autosize contentForm', "placeholder" => "Tags... Specify at least one tag for your question")); ?>
                    </div>
                    <div class="pull-left" style="margin-top:5px;">
                    <?php
                    // Creates Uploading Button
                    $this->widget('application.modules_core.file.widgets.FileUploadButtonWidget', array(
                        'uploaderId' => 'contentFormFiles',
                        'fileListFieldName' => 'fileList',
                    ));
                    ?>
                    <script>
                        $('#fileUploaderButton_contentFormFiles').bind('fileuploaddone', function (e, data) {
                            $('.btn_container').show();
                        });

                        $('#fileUploaderButton_contentFormFiles').bind('fileuploadprogressall', function (e, data) {
                            var progress = parseInt(data.loaded / data.total * 100, 10);
                            if (progress != 100) {
                                // Fix: remove focus from upload button to hide tooltip
                                $('#post_submit_button').focus();

                                // hide form buttons
                                $('.btn_container').hide();
                            }
                        });
                    </script>
                    <?php
                    // Creates a list of already uploaded Files
                    $this->widget('application.modules_core.file.widgets.FileUploadListWidget', array(
                        'uploaderId' => 'contentFormFiles'
                    ));
                    ?>
                    </div>

                    <?php
                    echo CHtml::hiddenField("containerGuid", Yii::app()->user->guid);
                    echo CHtml::hiddenField("containerClass",  get_class(new User()));
                    ?>
					<?php echo CHtml::submitButton('Submit', array('class' => ' btn btn-info pull-right', 'style' => 'margin-top: 5px;')); ?>
                </div>
            </div>
        </div>
   </div>
</div>

<?php $this->endWidget(); ?>

