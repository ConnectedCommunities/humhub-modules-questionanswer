<?php
/* @var $this QuestionController */
/* @var $dataProvider CActiveDataProvider */
?>

<h1>Questions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
