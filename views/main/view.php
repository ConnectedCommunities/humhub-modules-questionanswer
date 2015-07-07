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
                                if(array_key_exists($question['id'], $user_vote_history) && array_key_exists('question', $user_vote_history[$question['id']])) {

                                    if($user_vote_history[$question['id']]['question'] == "up") {
                                        $upBtnClass = "active";
                                        $downBtnClass = "";
                                    } else {
                                        $downBtnClass = "active";
                                        $upBtnClass = "";
                                    }
                                }
                                ?>
                                <?php echo $this->renderPartial('vote', array('post_id' => $question['id'], 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'up', 'btnClass' => 'btn btn-default btn-sm', 'class' => $upBtnClass)); ?>
                                <div class="text-center"><strong><?php if(array_key_exists($question['id'], $user_vote_history) && array_key_exists('question', $user_vote_history[$question['id']])) echo $question_vote_stats[$question['id']]['question']['total']; else echo "0"; ?></strong><br /></div>
                                <?php echo $this->renderPartial('vote', array('post_id' => $question['id'], 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'down', 'btnClass' => 'btn btn-default btn-sm', 'class' => $downBtnClass)); ?>
                            </div>
                            
                        </div>
                        <div class="media-body" style="position:absolute;top:0;right:0; padding:10px; width:200px; background-color:#708FA0; color:#fff;">
                            <a href="<?php echo $this->createUrl('//user/profile', array('uguid' => $question->user->guid)); ?>" style="color:#fff;">
                                <img id="user-account-image" class="img-rounded pull-left"
                                     src="<?php echo $question->user->getProfileImage()->getUrl(); ?>"
                                     height="32" width="32" alt="32x32" data-src="holder.js/32x32"
                                     style="width: 32px; height: 32px; margin-right:10px;"/>

                                <div class="user-title pull-left hidden-xs">
                                    <strong><?php echo CHtml::encode($question->user->displayName); ?></strong><br/><span class="truncate"><?php echo CHtml::encode($question->user->profile->title); ?></span>
                                </div>
                            </a>
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
                                    echo " &bull; <a href=\"". $this->createUrl('//user/profile', array('uguid' => $comment->user->guid)) . "\">" . $comment->user->displayName . "</a>";
                                    echo '</div>';
                                }
                                echo "</div>";
                            }
                            ?>
                            <br />
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
                                <?php 
                                $upBtnClass = ""; $downBtnClass = "";

                                // Change the button class to 'active' if the user has voted
                                if(array_key_exists($question_answer['id'], $user_vote_history) && array_key_exists('answer', $user_vote_history[$question_answer['id']])) {

                                    if($user_vote_history[$question_answer['id']]['answer'] == "up") {
                                        $upBtnClass = "active";
                                        $downBtnClass = "";
                                    } else {
                                        $downBtnClass = "active";
                                        $upBtnClass = "";
                                    }
                                }
                                ?>
                                <?php echo $this->renderPartial('vote', array('post_id' => $question_answer['id'], 'model' => new QuestionVotes, 'vote_on' => 'answer', 'vote_type' => 'up', 'btnClass' => 'btn btn-default btn-sm', 'class' => $upBtnClass)); ?>
                                <div class="text-center"><strong><?php if(array_key_exists($question_answer['id'], $user_vote_history) && array_key_exists('answer', $user_vote_history[$question_answer['id']])) echo $question_vote_stats[$question_answer['id']]['answer']['total']; else echo "0"; ?></strong><br /></div>
                                <?php echo $this->renderPartial('vote', array('post_id' => $question_answer['id'], 'model' => new QuestionVotes, 'vote_on' => 'answer', 'vote_type' => 'down', 'btnClass' => 'btn btn-default btn-sm', 'class' => $downBtnClass)); ?>
                            </div>
                        </div>
                        <div class="media-body" style="position:absolute;top:0;right:0; padding:10px; width:200px; background-color:#708FA0; color:#fff;">
                            <a href="<?php echo $this->createUrl('//user/profile', array('uguid' => $question_answer->user->guid)); ?>" style="color:#fff;">
                                <img id="user-account-image" class="img-rounded pull-left"
                                     src="<?php echo $question_answer->user->getProfileImage()->getUrl(); ?>"
                                     height="32" width="32" alt="32x32" data-src="holder.js/32x32"
                                     style="width: 32px; height: 32px; margin-right:10px;"/>

                                <div class="user-title pull-left hidden-xs">
                                    <strong><?php echo CHtml::encode($question_answer->user->displayName); ?></strong><br/><span class="truncate"><?php echo CHtml::encode($question_answer->user->profile->title); ?></span>
                                </div>
                            </a>
                        </div>
                        <div class="media-body" style="padding-top:5px; ">
                            <br />
                            <?php echo nl2br(CHtml::encode($question_answer->post_text)); ?>
                            <br />
                            <br />

                            <?php
                            if(array_key_exists($question_answer->id, $comments)) {
                                echo "<div style=\"border: 1px solid #ccc; background-color: #f2f2f2; padding:10px; margin-top:10px;\">";
                                foreach($comments[$question_answer->id] as $comment) {
                                    echo '<div style="border-bottom:1px solid #d8d8d8; padding: 4px;">';
                                    echo $comment->post_text;
                                    echo " &bull; <a href=\"". $this->createUrl('//user/profile', array('uguid' => $comment->user->guid)) . "\">" . $comment->user->displayName . "</a>";
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