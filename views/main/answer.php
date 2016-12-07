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
?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'answer-answer-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // See class documentation of CActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>false,
)); ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Answer</strong> this question
    </div>
    <div class="panel-body">
        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->error($model,'post_text'); ?>
        <?php echo $form->textArea($model,'post_text',array('id' => "contentForm_answersText", 'rows' => '5', 'style' => 'height: auto !important;', "class" => "form-control contentForm", "tabindex" => "2", "placeholder" => "Your answer...")); ?>
        <?php echo CHtml::submitButton('Submit', array('class' => ' btn btn-info pull-right', 'style' => 'margin-top: 5px;')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>