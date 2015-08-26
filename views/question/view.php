<?php
/* @var $this QuestionController */
/* @var $model Question */
?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default qanda-panel" style="padding:25px; padding-left:15px;">
                <div class="panel-body">
                    <div class="media">
                        <div class="pull-left">
                            <div class="vote_control pull-left" style="padding:5px; padding-right:10px; border-right:1px solid #eee; margin-right:10px;">
                                
                                <?php 
                                $upBtnClass = ""; $downBtnClass = "";

                                // Change the button class to 'active' if the user has voted
                                $vote = QuestionVotes::model()->post($model->id)->user(Yii::app()->user->id)->find();
                                if($vote) {
                                    if($vote->vote_type == "up") {
                                        $upBtnClass = "active btn-info";
                                        $downBtnClass = "";
                                    } else if($vote->vote_type =="down") {
                                        $downBtnClass = "active btn-info";
                                        $upBtnClass = "";
                                    }
                                }
                        
                                ?>


                                <?php $this->widget('application.modules.questionanswer.widgets.VoteButtonWidget', array('post_id' => $model->id, 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'up', 'class' => $upBtnClass, 'should_open_question' => 1));  ?>
                                <div class="text-center"><strong>
                                <?php echo QuestionVotes::model()->score($model->id); ?>
                                </strong><br /></div>
								<?php $this->widget('application.modules.questionanswer.widgets.VoteButtonWidget', array('post_id' => $model->id, 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'down', 'class' => $downBtnClass,  'should_open_question' => 1)); ?>
                            </div>
                            
                        </div>
                        
                        <?php
                        $this->widget('application.modules.questionanswer.widgets.ProfileWidget', array('user' => $model->user));
                        ?>

                        <div class="media-body" style="padding-top:5px; ">
                            <h3 class="media-heading">
                                <?php echo CHtml::link(CHtml::encode($model->post_title), Yii::app()->createUrl('//questionanswer/main/view', array('id' => $model->id))); ?>
                            </h3>
                            <?php echo nl2br(CHtml::encode($model->post_text)); ?>
                            <br /><br />
                            <?php foreach($model->tags as $tag) { ?>
                                <span class="label label-default"><a href="<?php echo $this->createUrl('//questionanswer/main/tag', array('id' => $tag->tag_id)); ?>"><?php echo $tag->tag->tag; ?></a></span>
                            <?php } ?>
                            <br /><br />
                            <?php
                            $comments = Answer::model()->findByPk($model->id)->comments;
                            if($comments) {
                                echo "<div style=\"border: 1px solid #ccc; background-color: #f2f2f2; padding:10px;\">";
                                foreach($comments as $comment) {
                                    echo '<div style="border-bottom:1px solid #d8d8d8; padding: 4px;">';
                                    echo $comment->post_text;
                                    echo " &bull; <a href=\"". $this->createUrl('//user/profile', array('uguid' => $comment->user->guid)) . "\">" . $comment->user->displayName . "</a>";
                                    echo '</div>';
                                }
                                echo "</div>";
                            }
                            ?>
                            <br />
                            <br />
                            <?php 
                            $this->widget('application.modules.questionanswer.widgets.commentFormWidget', array('model' => new Comment, 'question_id' => $model->id, 'parent_id' => $model->id));
                            ?>
                            <?php 
                            if(Yii::app()->user->isAdmin() || $model->created_by == Yii::app()->user->id) {
                            	echo CHtml::link("Edit", array('update', 'id'=>$model->id)); 
                            }
                            ?>
                            &bull;
							<?php
						    if(Yii::app()->user->isAdmin()) {
						    	echo CHtml::linkButton('Delete',array(
							    'submit'=>$this->createUrl('delete',array('id'=>$model->id)),
							    'confirm'=>"Are you sure want to delete?",
								'csrf'=>true,
							    'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken)));
							}

							?>

                            <a href="#"></a>
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
                                <?php 
                                $upBtnClass = ""; $downBtnClass = "";
                                $vote = QuestionVotes::model()->post($question_answer['id'])->user(Yii::app()->user->id)->find();
                                if($vote) {
                                    if($vote->vote_type == "up") {
                                        $upBtnClass = "active btn-info";
                                        $downBtnClass = "";
                                    } else if($vote->vote_type == "down") {
                                        $downBtnClass = "active btn-info";
                                        $upBtnClass = "";
                                    }
                                }
                                ?>
                                <?php $this->widget('application.modules.questionanswer.widgets.VoteButtonWidget', array('post_id' => $question_answer['id'], 'model' => new QuestionVotes, 'vote_on' => 'answer', 'vote_type' => 'up', 'class' => $upBtnClass, 'should_open_question' => 1));  ?>
                                <div class="text-center"><strong><?php echo $question_answer['score']; ?></strong><br /></div>
                                <?php $this->widget('application.modules.questionanswer.widgets.VoteButtonWidget', array('post_id' => $question_answer['id'], 'model' => new QuestionVotes, 'vote_on' => 'answer', 'vote_type' => 'down', 'class' => $downBtnClass, 'should_open_question' => 1)); ?>
                            </div>
                        </div>
                        <?php $user = User::model()->findByPk($question_answer['created_by']); ?>                        
                        <?php
                        $this->widget('application.modules.questionanswer.widgets.ProfileWidget', array('user' => $user));
                        ?>
                        <div class="media-body" style="padding-top:5px; ">
                            <br />
                            <?php echo nl2br(CHtml::encode($question_answer['post_text'])); ?>
                            <br />
                            <br />
                            <?php 
                            $this->widget('application.modules.questionanswer.widgets.BestAnswerWidget', array(
                                'post_id' => $question_answer['id'], 
                                'author' => $author, 
                                'model' => new QuestionVotes, 
                                'accepted_answer' => ($question_answer['answer_status'] ? true : false)
                            ));
                            ?>
                            <?php
                            $comments = Answer::model()->findByPk($question_answer['id'])->comments;
                            if($comments) {
                                echo "<div style=\"border: 1px solid #ccc; background-color: #f2f2f2; padding:10px; margin-top:10px;\">";
                                foreach($comments as $comment) {
                                    echo '<div style="border-bottom:1px solid #d8d8d8; padding: 4px;">';
                                    echo $comment->post_text;
                                    echo " &bull; <a href=\"". $this->createUrl('//user/profile', array('uguid' => $comment->user->guid)) . "\">" . $comment->user->displayName . "</a>";
                                    echo '</div>';
                                }
                                echo "</div>";
                            }
                            ?>
                            <br />
                            <?php 
                            $this->widget('application.modules.questionanswer.widgets.commentFormWidget', array('model' => new Comment, 'question_id' => $question_answer['question_id'], 'parent_id' => $question_answer['id']));
                            ?>
                            <?php 
                            if(Yii::app()->user->isAdmin() || $question_answer['created_by'] == Yii::app()->user->id) {
                                echo CHtml::link("Edit", array('//questionanswer/answer/update', 'id'=>$question_answer['id'])); 
                            }
                            ?>
                            &bull;
                            <?php
                            if(Yii::app()->user->isAdmin()) {
                                echo CHtml::linkButton('Delete',array(
                                'submit'=>$this->createUrl('//questionanswer/answer/delete',array('id'=>$question_answer['id'])),
                                'confirm'=>"Are you sure want to delete?",
                                'csrf'=>true,
                                'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken)));
                            }

                            ?>
                        </div>

                    </div>
                    
                </div>
            </div>
            <?php } ?>


            <?php
            $this->widget('application.modules.questionanswer.widgets.AnswerFormWidget', array('question' => $model, 'answer' => new Answer));
            ?>

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

            <?php if(count($related) > 0) { ?>
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Related</strong> Questions</div>
                <div class="list-group">
                    <?php foreach ($related as $question) { ?>
                        <a class="list-group-item" href="<?php echo Yii::app()->createUrl('//questionanswer/main/view', array('id' => $question['id'])); ?>"><?php echo CHtml::encode($question['post_title']); ?></a>
                    <?php } ?>
                </div>
                <br>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- end: show content -->

