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

/* @var $this AnonAccountsSettingsController */
/* @var $model AnonAccountsSettings */
/* @var $form CActiveForm */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use humhub\widgets\DataSaved;

?>
<div class="panel panel-default">
    <div class="panel-heading"><strong>Q&A</strong> Settings</div>
    <div class="panel-body">

        <?php $form = ActiveForm::begin(array(
            'id'=>'anon-accounts-settings-index2-form',
            'enableAjaxValidation'=>false,
        )); ?>

        <div class="form-group">
            <p>Q&A module has two <i>modes</i>, global and spaces.</p>
            <ul>
                <li><b>Global</b> - Is where all of the Q&A content is combined into one view on the front page (this is the default mode).</li>
                <li><b>Spaces</b> - Is where <i>spaces</i> (with the questionanswer module enabled) act as categories. The front page shows the available categories and the ability to post global is removed.</li>
            </ul>
        </div>

        <div class="form-group">
            <!-- show flash message after saving -->
            <?php echo DataSaved::widget(); ?>
            <?php echo $form->errorSummary($model); ?>
        </div>
        <?php
        // Use Global Content Container?
        echo $form->field($model, 'useGlobalContentContainer')->dropDownList($options,['prompt'=>'Choose Q&A mode']);
        ?>
        
        <?php echo Html::submitButton('Save', array('class' => 'btn btn-primary')); ?>

        <?php $form->end(); ?>

    </div>
</div>
