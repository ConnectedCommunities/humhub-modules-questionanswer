<?php
/* @var $this QuestionController */
/* @var $model Question */


use humhub\modules\questionanswer\models\QuestionVotes;
use yii\helpers\Html;
use yii\helpers\Url;
use humhub\modules\questionanswer\models\Answer;
use humhub\modules\questionanswer\models\QAComment;
use humhub\modules\user\models\User;
\humhub\modules\questionanswer\Assets::register($this);
?>


<div class="container">

	<!-- Top Banner -->
    <div class="row" style="margin-bottom:40px;">
        <div class="col-md-12">
            <div class="panel panel-default panel-profile">
                <div class="panel-profile-header">
                    <div class="image-upload-container" style="width: 100%; height: 100%; overflow:hidden;">
                        <img class="img-profile-header-background img-profile-header-background-qanda" id="space-banner-image" src="<?php echo $this->theme->getBaseUrl(); ?>/img/tc-qanda-banner.png" style="width: 100%;" width="100%">

                        <div class="img-profile-data">
                            <h1 class="space">Community Knowledge</h1>
                            <h2 class="space">A searchable repository of teaching knowledge.</h2>
                        </div>
                    </div>

                    <div class="image-upload-container profile-user-photo-container" style="width: 140px; height: 140px;">
                        <img class="img-rounded profile-user-photo" id="space-profile-image" src="<?php echo $this->theme->getBaseUrl(); ?>/img/tc-profile-qanda.png" data-src="holder.js/140x140" alt="140x140" style="width: 140px; height: 140px;">
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default qanda-panel qanda-panel-question">
                <div class="panel-body">
                    <div class="media">
                        <div class="pull-left">
                            <div class="vote_control pull-left" style="padding:5px; padding-right:10px; border-right:1px solid #eee; margin-right:10px;">

                                <?php
                                $upBtnClass = ""; $downBtnClass = ""; $vote = ""; $vote_type = "up";

                                // Change the button class to 'active' if the user has voted
                                $vote = QuestionVotes::find()->andWhere(['post_id' => $model->id, 'created_by' => \Yii::$app->user->id])->one();
                                if($vote) {
                                    if($vote->vote_type == "up") {
                                        $upBtnClass = "active btn-info";
                                        $downBtnClass = "";
                                    }

                                    if($vote->created_by == Yii::$app->user->id && $vote->vote_type == "up") {
                                        $vote_type = 'down';
                                    } else {
                                        $vote_type = "up";
                                    }
                                }

                                ?>
                                <?= \humhub\modules\questionanswer\widgets\VoteButtonWidget::widget(array('post_id' => $model->id, 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => $vote_type, 'classObj' => $upBtnClass, 'should_open_question' => 1)) ?>
                                <div class="text-center" style="line-height:1;">
                                    <strong>
                                        <?php echo QuestionVotes::score($model->id); ?><br>
                                        <small>likes</small>
                                    </strong><br />
                                </div>
                            </div>

                        </div>



                        <div class="media-body" style="padding-top:5px; ">
                            <h3 class="media-heading">
                                <?php echo \yii\helpers\Html::a(\yii\helpers\Html::encode($model->post_title), Url::toRoute('//questionanswer/question/view', array('id' => $model->id))); ?>
                            </h3>
                            <?php print \yii\helpers\Html::decode($model->post_text); ?>
                            <?= \humhub\modules\file\widgets\ShowFiles::widget(array('object' => $model)); ?>
                            <div class="row qanda-details-padding">
                            	<div class="col-sm-8">
                                	<div class="row">
                                    	<div class="col-sm-12">
									    <?php foreach($model->tags as $tag) { ?>
                                            <span class="label label-default tag6"><a href="<?php echo Url::toRoute(array('//questionanswer/main/tag', 'id' => $tag->tag_id)); ?>"><?php echo $tag->tag->tag; ?></a></span>
                                        <?php } ?>
                                    	</div>
                                        <div class="col-sm-12">
                                        	<?php
											if(Yii::$app->user->isAdmin() || $model->created_by == Yii::$app->user->id) {
												echo Html::a("<div class='qanda-button pull-left' style='margin-left:0px;'><span class='icon icon-pencil'></span> Edit</div>", Url::toRoute(array('update', 'id'=>$model->id)));
											} ?>
											<?php if(Yii::$app->user->isAdmin()) {
                                                echo Html::a('<div class="qanda-button pull-left"><span class="icon icon-trash"></span> Delete</div>', Url::toRoute(array('delete', 'id'=>$model->id)));
                                            } ?>
                            	       </div>
                            	   </div>

                            	</div>
                                <div class="col-sm-4">
                                    <?= \humhub\modules\questionanswer\widgets\ProfileWidget::widget(array('user' => $model->user, 'timestamp' => $model->created_at)); ?>
                                </div>
                            </div>

							<div class='qanda-comments-panel'>
                            <?php $comments = Answer::find()->andWhere(['id' => $model->id])->one()->comments;
							echo "<h5 style='padding-left:4px;'>";
							echo count($comments);
							echo " Comments</h5>";
                            if($comments) {
                                foreach($comments as $comment) {
                                    echo '<div style="border-bottom:1px solid #d8d8d8; padding: 4px;">';
                                    echo $comment->post_text;
									echo '<div class="row"><div class="col-sm-6">';
                                    echo "<a class='display-name' href=\"". Url::toRoute(array('//user/profile', 'uguid' => $comment->user->guid)) . "\">" . $comment->user->displayName . "</a>";
                                    echo " &bull; ".date('Y-m-d H:i:s', strtotime($comment->created_at));
                                    echo '</div>';
									echo '<div class="col-sm-6">';
                                    echo "<small>";

									if(Yii::$app->user->isAdmin()) {
                                        echo Html::a('<div class="qanda-button pull-right"><span class="icon icon-trash"></span> Delete</div>',Url::toRoute(array('//questionanswer/comment/delete', 'id'=>$comment->id)));
                                    }

                                    if(Yii::$app->user->isAdmin() || $comment->created_by == Yii::$app->user->id) {
                                        echo Html::a("<div class='qanda-button pull-right'><span class='icon icon-pencil'></span> Edit</div>", array('//questionanswer/comment/update', 'id'=>$comment->id));
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
                                    <?= \humhub\modules\questionanswer\widgets\CommentFormWidget::widget(array('model' => new QAComment, 'question_id' => $model->id, 'parent_id' => $model->id)); ?>

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
                                $upBtnClass = ""; $downBtnClass = ""; $vote = ""; $vote_type = "up";

                                // Change the button class to 'active' if the user has voted
                                $vote = QuestionVotes::find()->andWhere(['post_id' => $question_answer['id'], 'created_by' => \Yii::$app->user->id])->one();
                                if($vote) {
                                    if($vote->vote_type == "up") {
                                        $upBtnClass = "active btn-info";
                                        $downBtnClass = "";
                                    }

                                    if($vote->created_by == Yii::$app->user->id && $vote->vote_type == "up") {
                                        $vote_type = 'down';
                                    } else {
                                        $vote_type = "up";
                                    }
                                }
                                ?>

                                <?= \humhub\modules\questionanswer\widgets\VoteButtonWidget::widget(array('post_id' => $question_answer['id'], 'model' => new QuestionVotes, 'vote_on' => 'answer', 'vote_type' => $vote_type, 'classObj' => $upBtnClass, 'should_open_question' => 1)); ?>
                                <div class="text-center" style="line-height:1;">
                                    <strong>
                                        <?php echo $question_answer['score']; ?><br>
                                        <small>likes</small>
                                    </strong><br />
                                </div>
                            </div>
                        </div>
                        <?php $user = User::find()->andWhere(['id' => ($question_answer['created_by'])])->one(); ?>
                        <div class="media-body" style="padding-top:5px; ">
                            <?php print Html::encode($question_answer['post_text']); ?>
                            <?php
                            $answerModel = Answer::findOne($question_answer['id']);
                            ?>
                            <div class="row qanda-details-padding">
                            	<div class="col-sm-8">
                                    <?= \humhub\modules\file\widgets\ShowFiles::widget(array('object' => $answerModel)); ?>
                                	<?php
                                    if(Yii::$app->user->isAdmin() || $question_answer['created_by'] == Yii::$app->user->id) {
                                        echo Html::a("<div class='qanda-button pull-left'><span class='icon icon-pencil'></span> Edit</div>", array('//questionanswer/answer/update', 'id'=>$question_answer['id']));
                                    }

                                    if(Yii::$app->user->isAdmin()) {
                                        echo Html::a('<div class="qanda-button pull-left"><span class="icon icon-trash"></span> Delete</div>', Url::toRoute(array('//questionanswer/answer/delete', 'id'=>$question_answer['id'])));
                                    }

                                    echo "<br /><br />";

                                    echo \humhub\modules\questionanswer\widgets\BestAnswerWidget::widget(array(
                                        'post_id' => $question_answer['id'],
                                        'author' => $author,
                                        'model' => new QuestionVotes(),
                                        'accepted_answer' => ($question_answer['answer_status'] ? true : false)
                                    ));
                                    ?>
                            	</div>
                                <div class="col-sm-4">
                                    <?= \humhub\modules\questionanswer\widgets\ProfileWidget::widget(array('user' => $user, 'timestamp' => $question_answer['created_at'])) ?>
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
                                    print Html::encode($comment->post_text);
									echo '<div class="row"><div class="col-sm-6">';
									echo "<a class='display-name' href=\"". Url::toRoute(array('//user/profile', 'uguid' => $comment->user->guid)) . "\">" . $comment->user->displayName . "</a>";
                                    echo " &bull; ".date('Y-m-d H:i:s', strtotime($comment->created_at));
                                    echo '</div>';
									echo '<div class="col-sm-6">';
                                    echo "<small>";


									if(Yii::$app->user->isAdmin()) {
                                        echo Html::a('<div class="qanda-button pull-right"><span class="icon icon-trash"></span> Delete</div>',
                                            Url::toRoute(array('//questionanswer/comment/delete', 'id'=>$comment->id))
                                        );
                                    }

                                    if(Yii::$app->user->isAdmin() || $comment->created_by == Yii::$app->user->id) {
                                        echo Html::a("<div class='qanda-button pull-right'><span class='icon icon-pencil'></span> Edit</div>", array('//questionanswer/comment/update', 'id'=>$comment->id));
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
                                    <?= \humhub\modules\questionanswer\widgets\CommentFormWidget::widget(array('model' => new QAComment, 'question_id' => $question_answer['question_id'], 'parent_id' => $question_answer['id'])); ?>
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


            <?=  \humhub\modules\questionanswer\widgets\AnswerFormWidget::widget(array('question' => $model, 'answer' => new Answer)); ?>

        </div>


        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Related</strong> Posts</div>
                <?php if(count($related) > 0) { ?>
                    <div class="list-group">
                        <?php foreach ($related as $question) { ?>
                            <a class="list-group-item" href="<?php echo Url::toRoute(array('//questionanswer/question/view', 'id' => $question['id'])); ?>"><?php echo Html::encode($question['post_title']); ?></a>
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

