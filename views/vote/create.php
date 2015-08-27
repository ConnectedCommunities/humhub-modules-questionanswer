<?php
/* @var $this VoteController */
/* @var $model QuestionVotes */

$this->breadcrumbs=array(
	'Question Votes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List QuestionVotes', 'url'=>array('index')),
	array('label'=>'Manage QuestionVotes', 'url'=>array('admin')),
);
?>

<h1>Create QuestionVotes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>