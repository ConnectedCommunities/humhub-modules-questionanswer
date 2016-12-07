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

/* @var $this VoteController */
/* @var $model QuestionVotes */

$this->breadcrumbs=array(
	'Question Votes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List QuestionVotes', 'url'=>array('index')),
	array('label'=>'Create QuestionVotes', 'url'=>array('create')),
	array('label'=>'View QuestionVotes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage QuestionVotes', 'url'=>array('admin')),
);
?>

<h1>Update QuestionVotes <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>