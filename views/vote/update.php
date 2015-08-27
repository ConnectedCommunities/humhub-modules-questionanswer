<?php
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