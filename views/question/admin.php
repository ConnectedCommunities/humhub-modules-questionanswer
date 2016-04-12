<?php
/* @var $this QuestionController */
/* @var $model Question */

$breadcrumbs=array(
	'Questions'=>array('index'),
	'Manage',
);

$menu=array(
	array('label'=>'List Question', 'url'=>array('index')),
	array('label'=>'Create Question', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#question-grid').yiiGridView('update', {
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
	        		<strong>Manage</strong> questions
	        	</div>

	            <div class="panel-body">
					<p>
					You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
					or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
					</p>

					<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
					<div class="search-form" style="display:none">
                    	<div class="panel panel-default qanda-form">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <?php $this->renderPartial('_search',array(
                                            'model'=>$model,
                                        )); ?>
                                	</div>
                            	</div>
                        	</div>
                    	</div>
					</div><!-- search-form -->

					<?php $this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'question-grid',
						'dataProvider'=>$model->search(),
						'filter'=>$model,
						'columns'=>array(
							'id',
							/*'question_id',
							'parent_id',*/
							'post_title',
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

