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

/* @var $this CommentController */
/* @var $model Comment */

$breadcrumbs=array(
	'Comments'=>array('index'),
	'Manage',
);

$menu=array(
	array('label'=>'List Comment', 'url'=>array('index')),
	array('label'=>'Create Comment', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#comment-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<style>
.vote_control .btn-xs:nth-child(1) {
    margin-bottom:3px;
}

.qanda-panel {
    margin-top:57px;
}

.qanda-header-tabs {
    margin-top:-49px;
}
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
	        <div class="panel qanda-panel">
	        	<div class="panel-heading">
	        		<?php $this->renderPartial('../partials/admin_menu_links'); ?>
	        		<strong>Manage</strong> comments
	        	</div>

	            <div class="panel-body">
					<p>
					You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
					or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
					</p>

					<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
					<div class="search-form" style="display:none">
					<?php $this->renderPartial('_search',array(
						'model'=>$model,
					)); ?>
					</div><!-- search-form -->

					<?php $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'comment-grid',
						'dataProvider'=>$model->search(),
						'filter'=>$model,
						'columns'=>array(
							'id',
							'question_id',
							'parent_id',
							'post_text',
							'post_type',
							/*
							'created_at',
							'created_by',
							'updated_at',
							'updated_by',
							*/
							array(
								'class'=>'CButtonColumn',
							),
						),
					)); ?>
				</div>
			</div>
		</div>
	</div>
</div>


