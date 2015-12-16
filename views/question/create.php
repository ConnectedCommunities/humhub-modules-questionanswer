<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

use yii\data\ActiveDataProvider;
?>

<?php $form = \yii\widgets\ActiveForm::begin(); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<strong>Ask</strong> a new question
	            </div>
	            <div class="panel-body">
	            	<?php echo $form->errorSummary($model); ?>
            		<?php // echo $form->error($model,'post_title'); ?>
            		<?php
                        echo $form->field($model, 'post_title', array(
                            'options' => array(
                                'id'=>'contentForm_question',
                                'class' => 'contentForm',
                                'rows' => '1',
                                "placeholder" => "Ask something...",
                            )
                        ));
                    ?>
                    <div class="contentForm_options">
                    	<?php // echo $form->error($model,'post_text'); ?>
                    	<?php
                            echo $form->field($model, 'post_text', array(
                                'options' => array(
                                    'id' => "contentForm_answersText",
                                    'rows' => '5',
                                    'style' => 'height: auto !important;',
                                    "class" => "contentForm",
                                    "placeholder" => "Question details..."
                                )
                            ))->textArea(['rows' => 6]);
                        ?>
                        <br />
                        <?php echo Html::textInput('Tags', null, array('class' => 'form-control autosize contentForm', "placeholder" => "Tags... Specify at least one tag for your question")); ?>
                    </div>
                    <div class="pull-left" style="margin-top:5px;">
                    <?php
                    // Creates Uploading Button
                    echo humhub\modules\file\widgets\FileUploadButton::widget(array(
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
                    echo \humhub\modules\file\widgets\FileUploadList::widget(array(
                        'uploaderId' => 'contentFormFiles'
                    ));
                    ?>
                    </div>

                    <?php
                    echo Html::hiddenInput("containerGuid", Yii::$app->user->guid);
                    echo Html::hiddenInput("containerClass",  get_class(new \humhub\modules\user\models\User()));
                    ?>
                    <?php echo Html::submitButton('Submit', array('class' => ' btn btn-info pull-right', 'style' => 'margin-top: 5px;')); ?>
                </div>
            </div>
        </div>
   </div>
</div>

<?php \yii\widgets\ActiveForm::end(); ?>

