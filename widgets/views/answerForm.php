
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'answer-answer-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // See class documentation of CActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>false,
    'action' => Yii::app()->createUrl('//questionanswer/answer/create')
)); ?>
<div class="panel panel-default panel-answer">
    <div class="panel-heading">
        <strong>Your</strong> response
    </div>
    <div class="panel-body">
        <?php echo $form->errorSummary($answer); ?>
        <?php echo $form->error($answer,'post_text'); ?>
        <?php echo $form->textArea($answer,'post_text',array('id' => "contentForm_answersText", 'rows' => '5', 'style' => 'height: auto !important;', "class" => "form-control contentForm", "tabindex" => "2", "placeholder" => "Your response...")); ?>
        <?php echo $form->hiddenField($answer,'question_id',array('type'=>"hidden", 'value' => $question->id)); ?>
        <div class="pull-left">
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
<?php $this->endWidget(); ?>