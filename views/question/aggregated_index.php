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
                <?php echo $this->render('../partials/group', [
                    'link' => $categories['link'],
                    'createLink' => $categories['createLink'],
                    'group' => $group,
                    'categories' => $categories
                ]); ?>
            <?php } ?>
        </div>

        <div class="col-md-6">
            <?php foreach($groupB as $group => $categories) { ?>
                <?php echo $this->render('../partials/group', [
                    'link' => $categories['link'],
                    'createLink' => $categories['createLink'],
                    'group' => $group,
                    'categories' => $categories
                ]); ?>
            <?php } ?>
        </div>
    </div>
</div>
<!-- end: show content -->
