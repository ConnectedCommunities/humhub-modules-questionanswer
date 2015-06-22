
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default qanda-panel" style="padding:25px; padding-left:15px;">
                <div class="panel-body">
                    <div class="media">
                        <div class="pull-left">
                            <div class="vote_control pull-left" style="padding:5px; padding-right:10px; border-right:1px solid #eee; margin-right:10px;">
                                <a class="btn btn-default btn-sm" href="#"><i class="fa fa-angle-up"></i></a><br />
                                <div class="text-center"><strong>3</strong><br /></div>
                                <a class="btn btn-default btn-sm" href="#"><i class="fa fa-angle-down"></i></a>
                            </div>
                        </div>

                        <div class="media-body" style="padding-top:5px; ">
                            <h3 class="media-heading">
                                <?php echo CHtml::link(CHtml::encode($question->post_title), Yii::app()->createUrl('//questionanswer/main/view', array('id' => $question->id))); ?>
                            </h3>
                            <?php echo nl2br(CHtml::encode($question->post_text)); ?>
                        </div>
                    </div>

                </div>
            </div>

            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'question-new_question-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // See class documentation of CActiveForm for details on this,
                // you need to use the performAjaxValidation()-method described there.
                'enableAjaxValidation'=>false,
            )); ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Answer</strong> this question
                </div>
                <div class="panel-body">
                    <?php echo $form->errorSummary($model); ?>
                    <?php echo $form->error($model,'post_text'); ?>
                    <?php echo $form->textArea($model,'post_text',array('id' => "contentForm_answersText", 'rows' => '5', 'style' => 'height: auto !important;', "class" => "form-control contentForm", "tabindex" => "2", "placeholder" => "Your answer...")); ?>
                    <?php echo CHtml::submitButton('Submit', array('class' => ' btn btn-info pull-right', 'style' => 'margin-top: 5px;')); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>


        </div>

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Question</strong> information</div>
                <div class="list-group">
                    <a class="list-group-item" href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a>
                    <a class="list-group-item" href="#">Nunc pharetra blandit sapien, et tempor nisi.</a>
                    <a class="list-group-item" href="#">Duis finibus venenatis commodo. </a>
                </div>
                <br>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading"><strong>Related</strong> Questions</div>
                <div class="list-group">
                    <a class="list-group-item" href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a>
                    <a class="list-group-item" href="#">Nunc pharetra blandit sapien, et tempor nisi.</a>
                    <a class="list-group-item" href="#">Duis finibus venenatis commodo. </a>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>
<!-- end: show content -->