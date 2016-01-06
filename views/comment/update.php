<?php
/* @var $this CommentController */
/* @var $model Comment */

$breadcrumbs=array(
	'Comments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$menu=array(
	array('label'=>'List Comment', 'url'=>array('index')),
	array('label'=>'Create Comment', 'url'=>array('create')),
	array('label'=>'View Comment', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Comment', 'url'=>array('admin')),
);
?>

<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-body">
				<h1>Update Comment <?php echo $model->id; ?></h1>
				<?php echo $this->render('_form', array('model'=>$model)); ?>
			</div>
		</div>
	</div>
</div>