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
<?php
/* @var $this AnswerController */
/* @var $model Answer */

$this->breadcrumbs=array(
	'Answers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Answer', 'url'=>array('index')),
	array('label'=>'Create Answer', 'url'=>array('create')),
	array('label'=>'Update Answer', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Answer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Answer', 'url'=>array('admin')),
);
?>

<h1>View Answer #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'question_id',
		'parent_id',
		'post_title',
		'post_text',
		'post_type',
		'created_at',
		'created_by',
		'updated_at',
		'updated_by',
	),
)); ?>
