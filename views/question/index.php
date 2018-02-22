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
/* @var $dataProvider CActiveDataProvider */

humhub\modules\questionanswer\Asset::register($this);

use yii\widgets\ListView;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="<?php echo \yii\helpers\Url::toRoute('/questionanswer/question/index'); ?>">Discussion Forums</a></li>
                <?php if(get_class($contentContainer) == \humhub\modules\space\models\Space::class) { ?>
                    <li class="active"><?php echo $contentContainer->name; ?></li>
                <?php } ?>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default qanda-panel">
                <?php echo $this->render('../partials/top_menu_bar'); ?>
                <div class="panel-body">

                <?php
                echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => function($model) {
                        return $this->render('_view', ['data' => $model]);
                    },
                ]);
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end: show content -->
