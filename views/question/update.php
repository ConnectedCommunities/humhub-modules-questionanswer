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

<h1>Update Question <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>