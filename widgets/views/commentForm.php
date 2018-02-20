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

?>

<?php $form = \yii\widgets\ActiveForm::begin([
    'action' => \yii\helpers\Url::toRoute(['comment/create'])
]); ?>

<?php echo $form->errorSummary($model); ?>
<?php
echo humhub\widgets\RichtextField::widget([
    'model' => $model,
    'attribute' => 'post_text',
    'placeholder' => 'Add comment...',
]);
?>
<?php
echo $form->field($model, 'question_id', [])->hiddenInput(['value' => $question_id])->label(false);
echo $form->field($model, 'parent_id', [])->hiddenInput(['value' => $parent_id])->label(false);
?>


<?php //echo $form->error($model,'post_text'); ?>
<?php //echo $form->textArea($model,'post_text',array('id' => "contentForm_answersText", 'rows' => '2', 'style' => 'height: auto !important;', "class" => "form-control contentForm", "tabindex" => "2", "placeholder" => "Add comment...")); ?>
<?php //echo $form->hiddenField($model,'question_id',array('type'=>"hidden", 'value' => $question_id)); ?>
<?php //echo $form->hiddenField($model,'parent_id',array('type'=>"hidden", 'value' => $parent_id)); ?>
<?php echo \yii\helpers\Html::submitButton('Submit', array('class' => ' btn btn-info pull-right', 'style' => 'margin-top: 5px;')); ?>

<?php \yii\widgets\ActiveForm::end(); ?>