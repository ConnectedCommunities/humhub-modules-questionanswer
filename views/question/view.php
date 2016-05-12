<?php
/* @var $this QuestionController */
/* @var $model Question */
?>

<div class="container">

	<!-- Top Banner -->
    <div class="row" style="margin-bottom:40px;">
        <div class="col-md-12">
            <div class="panel panel-default panel-profile">
                <div class="panel-profile-header">
                    <div class="image-upload-container" style="width: 100%; height: 100%; overflow:hidden;">
                        <img class="img-profile-header-background img-profile-header-background-qanda" id="space-banner-image" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/tc-qanda-banner.png" style="width: 100%;" width="100%">
            
                        <div class="img-profile-data">
                            <h1 class="space">Community Knowledge</h1>
                            <h2 class="space">A searchable repository of teaching knowledge.</h2>
                        </div>
                    </div>
    
                    <div class="image-upload-container profile-user-photo-container" style="width: 140px; height: 140px;">
                        <img class="img-rounded profile-user-photo" id="space-profile-image" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/tc-profile-qanda.png" data-src="holder.js/140x140" alt="140x140" style="width: 140px; height: 140px;">
                    </div>
    
    
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default qanda-panel qanda-panel-question">
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
                        
                        

                        <div class="media-body" style="padding-top:5px; ">
                            <h3 class="media-heading">
                                <?php echo CHtml::link(CHtml::encode($model->post_title), Yii::app()->createUrl('//questionanswer/question/view', array('id' => $model->id))); ?>
                            </h3>
                            <?php print HHtml::enrichText($model->post_text); ?>
                            <?php $this->widget('application.modules_core.file.widgets.ShowFilesWidget', array('object' => $model)); ?>
                            <div class="row qanda-details-padding">
                            	<div class="col-sm-8">
                                	<div class="row">
                                    	<div class="col-sm-12">
									    <?php foreach($model->tags as $tag) { ?>
                                            <span class="label label-default tag6"><a href="<?php echo $this->createUrl('//questionanswer/main/tag', array('id' => $tag->tag_id)); ?>"><?php echo $tag->tag->tag; ?></a></span>
                                        <?php } ?>
                                    	</div>
                                        <div class="col-sm-12">
                                        	<?php 
											if(Yii::app()->user->isAdmin() || $model->created_by == Yii::app()->user->id) {
												echo CHtml::link("<div class='qanda-button pull-left' style='margin-left:0px;'><span class='icon icon-pencil'></span> Edit</div>", array('update', 'id'=>$model->id)); 
											} ?>
											<?php if(Yii::app()->user->isAdmin()) {
                                                echo CHtml::linkButton('<div class="qanda-button pull-left"><span class="icon icon-trash"></span> Delete</div>',array(
                                                'submit'=>$this->createUrl('delete',array('id'=>$model->id)),
                                                'confirm'=>"Are you sure want to delete?",
                                                'csrf'=>true,
                                                'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken)));
                                            } ?>
                                            <?php
                                            if($model->reportModuleEnabled()) {
                                                $this->widget('application.modules.questionanswer.widgets.QAReportContentWidget', array(
                                                    'content' => $model
                                                ));
                                            }
                                            ?>
                            	       </div>
                            	   </div>
                            
                            	</div>
                                <div class="col-sm-4">
                                	<?php $this->widget('application.modules.questionanswer.widgets.ProfileWidget', array('user' => $model->user, 'timestamp' => $model->created_at)); ?>
                                </div>
                            </div>

							<div class='qanda-comments-panel'>
                            <?php $comments = Answer::model()->findByPk($model->id)->comments;
							echo "<h5 style='padding-left:4px;'>";
							echo count($comments);
							echo " Comments</h5>";
                            if($comments) {
                                foreach($comments as $comment) {
                                    echo '<div style="border-bottom:1px solid #d8d8d8; padding: 4px;">';
                                    echo $comment->post_text;
									echo '<div class="row"><div class="col-sm-6">';
                                    echo "<a class='display-name' href=\"". $this->createUrl('//user/profile', array('uguid' => $comment->user->guid)) . "\">" . $comment->user->displayName . "</a>";
                                    echo " &bull; ".date('Y-m-d H:i:s', strtotime($comment->created_at)); 
                                    echo '</div>';
									echo '<div class="col-sm-6">';
                                    echo "<small>";
									
									if(Yii::app()->user->isAdmin()) {
                                      
                                        echo CHtml::linkButton('<div class="qanda-button pull-right"><span class="icon icon-trash"></span> Delete</div>',array(
                                        'submit'=>$this->createUrl('//questionanswer/comment/delete',array('id'=>$comment->id)),
                                        'confirm'=>"Are you sure want to delete?",
                                        'csrf'=>true,
                                        'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken)));
                                    }
									
                                    if(Yii::app()->user->isAdmin() || $comment->created_by == Yii::app()->user->id) {
                                        echo CHtml::link("<div class='qanda-button pull-right'><span class='icon icon-pencil'></span> Edit</div>", array('//questionanswer/comment/update', 'id'=>$comment->id)); 
                                    }
                                    
                                    
                                    echo "</small>";
									echo '</div></div>';
                                    
                                    echo '</div>';
                                }
                            } ?>
                            	<div class="add-comment-button" style="padding-top:10px;">
                            		<a class="add-comment-link" style="margin-left:4px;color:#ccc;">add a comment</a>								
                                </div>
                                <div class="hidden-comment-form">
                                    <?php $this->widget('application.modules.questionanswer.widgets.CommentFormWidget', array('model' => new Comment, 'question_id' => $model->id, 'parent_id' => $model->id)); ?>
                                    
                                </div>
                                
                                <script type="text/javascript">
									$(document).ready(function() { 
										$(".add-comment-link").click(function() {
											
											if ($(".hidden-comment-form").css('opacity') == '0'){
												$(".hidden-comment-form").animate({'opacity':1})
												$('.hidden-comment-form').css("height","auto");
											}else{
												$(".hidden-comment-form").animate({'opacity':0}) 
												$('.hidden-comment-form').css("height","0px");
											}
										});
									});
								</script>
							</div>

                            

                        </div>
                    </div>

                </div>
            </div>
            
            <h4><?php echo count($answers) ?> Responses</h4>
            <hr>

            <?php foreach($answers as $question_answer) { ?>
            <div class="panel panel-default qanda-panel">
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
                        
                        
                        <div class="media-body" style="padding-top:5px; ">
                            <?php print HHtml::enrichText($question_answer['post_text']); ?>
                            <?php
                            $answerModel = Answer::model()->findByPk($question_answer['id']);
                            ?>
                            <div class="row qanda-details-padding">
                            	<div class="col-sm-8">
                                    <?php $this->widget('application.modules_core.file.widgets.ShowFilesWidget', array('object' => $answerModel)); ?>
                                	<?php
                                    if(Yii::app()->user->isAdmin() || $question_answer['created_by'] == Yii::app()->user->id) {
                                        echo CHtml::link("<div class='qanda-button pull-left'><span class='icon icon-pencil'></span> Edit</div>", array('//questionanswer/answer/update', 'id'=>$question_answer['id'])); 
                                    }

                                    if(Yii::app()->user->isAdmin()) {
                                        echo CHtml::linkButton('<div class="qanda-button pull-left"><span class="icon icon-trash"></span> Delete</div>',array(
                                        'submit'=>$this->createUrl('//questionanswer/answer/delete',array('id'=>$question_answer['id'])),
                                        'confirm'=>"Are you sure want to delete?",
                                        'csrf'=>true,
                                        'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken)));
                                    }
                                    
                                    echo "<br /><br />";

                                    $this->widget('application.modules.questionanswer.widgets.BestAnswerWidget', array(
                                        'post_id' => $question_answer['id'], 
                                        'author' => $author, 
                                        'model' => new QuestionVotes, 
                                        'accepted_answer' => ($question_answer['answer_status'] ? true : false)
                                    ));
                                    ?>
                            	</div>
                                <div class="col-sm-4">
                                	<?php $this->widget('application.modules.questionanswer.widgets.ProfileWidget', array('user' => $user, 'timestamp' => $question_answer['created_at'])); ?>
                                </div>
                            </div>
                            
                            
                            <div class='qanda-comments-panel'>
                            <?php
                            $comments = $answerModel->comments;
							echo "<h5 style='padding-left:4px;'>";
							echo count($comments);
							echo " Comments</h5>";
                            
                            if($comments) {
                                
                                foreach($comments as $comment) {
                                    echo '<div style="border-bottom:1px solid #d8d8d8; padding: 4px;">';
                                    print HHtml::enrichText($comment->post_text);
									echo '<div class="row"><div class="col-sm-6">';
									echo "<a class='display-name' href=\"". $this->createUrl('//user/profile', array('uguid' => $comment->user->guid)) . "\">" . $comment->user->displayName . "</a>";
                                    echo " &bull; ".date('Y-m-d H:i:s', strtotime($comment->created_at)); 
                                    echo '</div>';
									echo '<div class="col-sm-6">';
                                    echo "<small>";

									
									if(Yii::app()->user->isAdmin()) {
                                        echo CHtml::linkButton('<div class="qanda-button pull-right"><span class="icon icon-trash"></span> Delete</div>',array(
                                        'submit'=>$this->createUrl('//questionanswer/comment/delete',array('id'=>$comment->id)),
                                        'confirm'=>"Are you sure want to delete?",
                                        'csrf'=>true,
                                        'params'=> array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken)));
                                    }
									
                                    if(Yii::app()->user->isAdmin() || $comment->created_by == Yii::app()->user->id) {
                                        echo CHtml::link("<div class='qanda-button pull-right'><span class='icon icon-pencil'></span> Edit</div>", array('//questionanswer/comment/update', 'id'=>$comment->id)); 
                                    }
                                    
                                    
                                    echo "</small>";
									echo '</div></div>';
                                    echo '</div>';
                                }
                            }
                            ?>
                            
                            <div class="add-comment-button" style="padding-top:10px;">
                            		<a class="add-comment-link<?php echo $question_answer['id'] ?>" style="margin-left:4px;color:#ccc;">add a comment</a>								
                                </div>
                                <div class="hidden-comment-form-answer" id="<?php echo $question_answer['id'] ?>">
                                    <?php $this->widget('application.modules.questionanswer.widgets.commentFormWidget', array('model' => new Comment, 'question_id' => $question_answer['question_id'], 'parent_id' => $question_answer['id'])); ?>
                                </div>
                                
                                <script type="text/javascript">
									$(document).ready(function() { 
										$(".add-comment-link<?php echo $question_answer['id'] ?>").click(function() {
											
											if ($("#<?php echo $question_answer['id'] ?>").css('opacity') == '0'){
												$("#<?php echo $question_answer['id'] ?>").animate({'opacity':1})
												$('#<?php echo $question_answer['id'] ?>').css("height","auto");
											}else{
												$("#<?php echo $question_answer['id'] ?>").animate({'opacity':0}) 
												$('#<?php echo $question_answer['id'] ?>').css("height","0px");
											}
										});
									});
								</script>
                            
                            </div>
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
                <div class="panel-heading"><strong>Related</strong> Posts</div>
                <?php if(count($related) > 0) { ?>
                    <div class="list-group">
                        <?php foreach ($related as $question) { ?>
                            <a class="list-group-item" href="<?php echo Yii::app()->createUrl('//questionanswer/question/view', array('id' => $question['id'])); ?>"><?php echo CHtml::encode($question['post_title']); ?></a>
                        <?php } ?>
                    </div>
                    <br>
                <?php } else { ?>
                    <div class="panel-body"><p>No related posts</p></div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- end: show content -->

