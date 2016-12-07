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

use humhub\modules\space\models\Space;


$container = $this->context->contentContainer;
$useGlobalContentContainer = $this->context->useGlobalContentContainer;
$isSpace = is_a($container, Space::className());

?>
<?php $form = \yii\widgets\ActiveForm::begin(); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<strong>Ask</strong> a new question
	            </div>

                <?php if($isSpace) { ?>

                    <?php if($container->canWrite()) { ?>

                        <?php echo $this->render('_create.php', [
                            'form' => $form,
                            'model' => $model
                        ]); ?>

                    <?php } else { ?>

                        <div class="panel-body">
                            <div class="text-center">
                                <h2>Join this Space to Ask a Question</h2>
                                <strong>You are not member of this space.</strong>
                                <br><br>
                                <?php echo \humhub\modules\space\widgets\MembershipButton::widget(['space' => $container]); ?>
                            </div>
                        </div>

                    <?php } ?>

                <?php } else { ?>

                    <?php echo $this->render('_create.php', [
                        'form' => $form,
                        'model' => $model
                    ]); ?>

                <?php } ?>
            </div>
        </div>
   </div>
</div>

<?php \yii\widgets\ActiveForm::end(); ?>

