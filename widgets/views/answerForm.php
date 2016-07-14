
<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<?php $form=\yii\bootstrap\ActiveForm::begin(array(
    'id'=>'answer-answer-form',
    'enableAjaxValidation'=>false,
    'action' => Url::toRoute('//questionanswer/answer/create')
)); ?>
<div class="panel panel-default panel-answer">
    <div class="panel-heading">
        <strong>Your</strong> response
    </div>
    <div class="panel-body">
        <?php echo $form->errorSummary($answer); ?>
        <?php echo $form->field($answer,'post_text')->textarea(array('id' => "contentForm_answersText", 'rows' => '5', 'style' => 'height: auto !important;', "class" => "form-control contentForm", "tabindex" => "2", "placeholder" => "Your response..."))->label(false); ?>
        <?php echo $form->field($answer,'question_id')->hiddenInput(array('type'=>"hidden", 'value' => $question->id))->label(false); ?>
        <div class="pull-left">
            <?= \humhub\modules\file\widgets\FileUploadButton::widget(array(
                'uploaderId' => 'contentFormFiles',
                'fileListFieldName' => 'fileList',
            )); ?>
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
            <?= \humhub\modules\file\widgets\FileUploadList::widget(array(
                'uploaderId' => 'contentFormFiles'
            )); ?>
        </div>
        <?php echo Html::submitButton('Submit', array('class' => ' btn btn-info pull-right', 'style' => 'margin-top: 5px;')); ?>
    </div>
</div>
<?php \yii\bootstrap\ActiveForm::end(); ?>