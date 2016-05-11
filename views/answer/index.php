<?php
/* @var $this AnswerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Responses',
);

$this->menu=array(
	array('label'=>'Create Answer', 'url'=>array('create')),
	array('label'=>'Manage Answer', 'url'=>array('admin')),
);
?>

<h1>Responses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
