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
    'action' => \yii\helpers\Url::toRoute('vote/create')
]); ?>
    <?php if(!isset($btnClass)) $btnClass = "btn btn-default btn-xs"; ?>
    <div style="display:none;">
    <?php echo $form->field($model, 'should_open_question')->hiddenInput(['value' => $should_open_question])->label(false); ?>
    <?php echo $form->field($model, 'post_id')->hiddenInput(['value' => $post_id])->label(false); ?>
    <?php echo $form->field($model, 'vote_on')->hiddenInput(['value' => $vote_on])->label(false); ?>
    <?php echo $form->field($model, 'vote_type')->hiddenInput(['value' => $vote_type])->label(false); ?>
    </div>
    <?php echo \yii\helpers\Html::tag('button', '<i class="fa fa-angle-'.$vote_type.'"></i>', array(
        'class'=> $btnClass . " " . $btn_class, 'type'=>'submit', 'style' => 'margin-top:5px;'
    )); ?>

<?php \yii\widgets\ActiveForm::end(); ?>