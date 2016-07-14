<?php
/* @var $this AnswerController */
/* @var $model Answer */
?>

<div class="container">
    <div class="row">


        <div class="panel panel-default qanda-form">

            <div class="panel-body">
            <h1>Update Answer <?php echo $model->id; ?></h1>
			<?php echo $this->render('_form', array('model'=>$model)); ?>
			</div>
		</div>

	</div>
</div>




