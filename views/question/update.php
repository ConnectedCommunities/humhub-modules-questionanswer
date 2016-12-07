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
/* @var $this QuestionController */
/* @var $model Question */

$breadcrumbs=array(
	'Questions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$menu=array(
	array('label'=>'List Question', 'url'=>array('index')),
	array('label'=>'Create Question', 'url'=>array('create')),
	array('label'=>'View Question', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Question', 'url'=>array('admin')),
);
?>


<div class="container">
    <div class="row">


        <div class="panel panel-default">

            <div class="panel-body">
			<h1>Update Question <?php echo $model->id; ?></h1>
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
			</div>
		</div>

	</div>
</div>