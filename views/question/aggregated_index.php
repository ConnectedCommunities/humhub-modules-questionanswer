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
use yii\widgets\ListView;

// Split the groups we are provided into 2
$groupA = array_slice($groups, 0, ceil(count($groups) / 2));
$groupB = array_slice($groups, ceil(count($groups) / 2), count($groups));
?>

<style>


    .panel .panel-heading {
        font-size: 18px;
        font-weight: 400;
        border-bottom: 1px solid #E6E6E6;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .panel .panel-with-padding {
        padding: 20px;
    }



</style>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <?php foreach($groupA as $group => $categories) { ?>
                <div class="panel panel-default qanda-panel">
                    <div class="panel-heading">
                        <?php echo $group; ?>
                    </div>
                    <div class="list-group">
                        <?php foreach($categories as $category) { ?>
                            <a href="<?php echo $category['link']; ?>" class="list-group-item">
                                <b class="list-group-item-heading"><?php echo $category['name']; ?></b>
                                <p class="list-group-item-text"><?php echo $category['description']; ?></p>
                            </a>
                            <small>
                                <ul>
                                    <?php

                                    $questions = \humhub\modules\questionanswer\models\Question::find()
                                        ->contentContainer($category['space'])
                                        ->andFilterWhere(['post_type' => 'question'])
                                        ->orderBy('created_at DESC')
                                        ->limit(3)
                                        ->all();

                                    foreach($questions as $q) { ?>
                                    <li><a href="#"><?php echo $q['post_title']; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </small>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="col-md-6">
            <?php foreach($groupB as $group => $categories) { ?>
                <div class="panel panel-default qanda-panel">
                    <div class="panel-heading">
                        <?php echo $group; ?>
                    </div>
                    <div class="list-group">
                        <?php foreach($categories as $category) { ?>
                            <a href="<?php echo $category['link']; ?>" class="list-group-item">
                                <b class="list-group-item-heading"><?php echo $category['name']; ?></b>
                                <p class="list-group-item-text"><?php echo $category['description']; ?></p>
                            </a>

                            <small>
                                <ul>
                                    <?php

                                    $questions = \humhub\modules\questionanswer\models\Question::find()
                                        ->contentContainer($category['space'])
                                        ->andFilterWhere(['post_type' => 'question'])
                                        ->orderBy('created_at DESC')
                                        ->limit(3)
                                        ->all();

                                    foreach($questions as $q) { ?>
                                        <li><a href="#"><?php echo $q['post_title']; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </small>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- end: show content -->
