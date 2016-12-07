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

/* @var $this QuestionController */
/* @var $model Question */
/* @var $form CActiveForm */
?>

<?php $form = \yii\widgets\ActiveForm::begin([
//			'action' => \yii\helpers\Url::to(['question/update'])
]); ?>

<p class="note">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->field($model, 'question_id'); ?>
<?php echo $form->field($model, 'parent_id'); ?>
<?php echo $form->field($model, 'post_title'); ?>
<?php echo $form->field($model, 'post_text')->textArea(['rows' => 6]); ?>
<?php echo $form->field($model, 'post_type'); ?>
<?php echo $form->field($model, 'created_at'); ?>
<?php echo $form->field($model, 'created_by'); ?>
<?php echo $form->field($model, 'updated_at'); ?>
<?php echo $form->field($model, 'updated_by'); ?>
<hr>
<?php
echo humhub\modules\file\widgets\FileUploadButton::widget(array(
    'uploaderId' => 'contentFormFiles',
    'fileListFieldName' => 'fileList',
    'object' => $model,
));

echo \humhub\modules\file\widgets\FileUploadList::widget(array(
    'object' => $model,
    'uploaderId' => 'contentFormFiles',
));
?>
<hr>
<?php echo \yii\helpers\Html::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>

<?php \yii\widgets\ActiveForm::end(); ?>
