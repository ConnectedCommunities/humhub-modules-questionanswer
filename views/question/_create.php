<?php
/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
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

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
?>
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