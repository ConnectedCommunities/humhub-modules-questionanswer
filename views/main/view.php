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
                            <?php
                            if(array_key_exists($question->id, $comments)) {
                                echo "<div style=\"border: 1px solid #ccc; background-color: #f2f2f2; padding:10px; margin-top:10px;\">";
                                foreach($comments[$question->id] as $comment) {
                                    echo '<div style="border-bottom:1px solid #d8d8d8; padding: 4px;">';
                                    echo $comment->post_text;
                                    echo '</div>';
                                }
                                echo "</div>";
                            }
                            ?>
                            <br />
                            <?php $this->renderPartial('comment', array('model' => $commentModel, 'parent_id' => $question->id)); ?>
                        </div>
                    </div>

                </div>
            </div>

            <?php foreach($answers as $question_answer) { ?>
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
                            <br />
                            <?php echo nl2br(CHtml::encode($question_answer->post_text)); ?>
                            <br />
                            <hr />
                            <br />

                            <?php
                            if(array_key_exists($question_answer->id, $comments)) {
                                echo "<div style=\"border: 1px solid #ccc; background-color: #f2f2f2; padding:10px; margin-top:10px;\">";
                                foreach($comments[$question_answer->id] as $comment) {
                                    echo '<div style="border-bottom:1px solid #d8d8d8; padding: 4px;">';
                                    echo $comment->post_text;
                                    echo '</div>';
                                }
                                echo "</div>";
                            }
                            ?>
                            <br />
                            <?php $this->renderPartial('comment', array('model' => $commentModel, 'parent_id' => $question_answer->id)); ?>
                        </div>
                    </div>
                    
                </div>
            </div>
            <?php } ?>


            <?php $this->renderPartial('answer', array('model' => $answerModel)); ?>

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