
<?php
/**
 * Connected Communities Initiative
 * Copyright (C) 2016  Queensland University of Technology
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use yii\widgets\ActiveForm;

$form=ActiveForm::begin(array(
    'action' => yii\helpers\url::toRoute('answer/create')
)); ?>
<div class="panel panel-default panel-answer">
    <div class="panel-heading">
        <strong>Your</strong> answer
    </div>
    <div class="panel-body">

        <style>
            #answer_field {
                height: 130px;
            }
        </style>

        <?php
        echo humhub\widgets\RichtextField::widget([
            'id' => 'answer_field',
            'model' => $answer,
            'attribute' => 'post_text',
            'placeholder' => 'Your answer...'
        ]);
        ?>


        <?php echo $form->field($answer,'question_id')->hiddenInput(array('value' => $question->id))->label(false); ?>
        <div class="pull-left">
            <?php
            // Creates Uploading Button
            echo \humhub\modules\file\widgets\FileUploadButton::widget(array(
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
        echo \yii\helpers\Html::hiddenInput("containerGuid", Yii::$app->user->guid);
        echo \yii\helpers\Html::hiddenInput("containerClass",  get_class(new \humhub\modules\user\models\User()));
        ?>
        <?php echo \yii\helpers\Html::submitButton('Submit', array('class' => ' btn btn-info pull-right', 'style' => 'margin-top: 5px;')); ?>
    </div>
</div>
<?php \yii\widgets\ActiveForm::end(); ?>