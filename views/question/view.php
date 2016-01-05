<?php
use humhub\modules\questionanswer\models\QuestionVotes;
use humhub\modules\user\models\User;
use \humhub\modules\questionanswer\models\Answer;
use \humhub\modules\questionanswer\models\Comment;
use humhub\modules\questionanswer\widgets\VoteButtonWidget;
use humhub\modules\questionanswer\widgets\ProfileWidget;
use humhub\modules\file\widgets\ShowFiles;
use yii\helpers\Url;
use yii\helpers\Html;
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
                                $vote = QuestionVotes::find()->where(['post_id' => Yii::$app->getUser()->id])->one();
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


                                <?php
                                echo VoteButtonWidget::widget(array('post_id' => $model->id, 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'up', 'class' => $upBtnClass, 'should_open_question' => 1));
                                // $this->widget('application.modules.questionanswer.widgets.VoteButtonWidget', array('post_id' => $model->id, 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'up', 'class' => $upBtnClass, 'should_open_question' => 1));
                                ?>
                                <div class="text-center"><strong>
                                <?php
                                echo QuestionVotes::score($model->id);
                                // echo QuestionVotes::model()->score($model->id);
                                ?>
                                </strong><br /></div>
								<?php
                                echo VoteButtonWidget::widget(array('post_id' => $model->id, 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'down', 'class' => $downBtnClass,  'should_open_question' => 1));
                                // $this->widget('application.modules.questionanswer.widgets.VoteButtonWidget', array('post_id' => $model->id, 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'down', 'class' => $downBtnClass,  'should_open_question' => 1));
                                ?>
                            </div>
                            
                        </div>
                        
                        <?php
                        echo ProfileWidget::widget(array('user' => $model->user, 'timestamp' => $model->created_at));
//                        $this->widget('application.modules.questionanswer.widgets.ProfileWidget', array('user' => $model->user, 'timestamp' => $model->created_at));
                        ?>

                        <div class="media-body" style="padding-top:5px; ">
                            <h3 class="media-heading">
                                <?php echo Html::a(Html::encode($model->post_title), Url::toRoute(['question/view', array('id' => $model->id)])); ?>
                            </h3>
                            <?php print Html::encode($model->post_text); ?>
                            <br /><br />
                            <?php foreach($model->tags as $tag) { ?>
                                <span class="label label-default"><a href="<?php echo Url::toRoute(['/questionanswer/main/tag', 'id' => $tag->tag_id]); ?>"><?php echo $tag->tag->tag; ?></a></span>
                            <?php } ?>
                            <br /><br />
                            <?php
                            echo ShowFiles::widget(array('object' => $model));
//                            $this->widget('application.modules_core.file.widgets.ShowFilesWidget', array('object' => $model));
                            $comments = Answer::findOne(['id' => $model->id])->comments;
//                            $comments = Answer::model()->findByPk($model->id)->comments;
                            if($comments) {
                                echo "<div style=\"border: 1px solid #ccc; background-color: #f2f2f2; padding:10px;\">";
                                foreach($comments as $comment) {
                                    echo '<div style="border-bottom:1px solid #d8d8d8; padding: 4px;">';
                                    print Html::encode($comment->post_text);
                                    echo " &bull; <a href=\"". Url::toRoute(['user/profile', array('uguid' => $comment->user->guid)]) . "\">" . $comment->user->displayName . "</a>";
                                    
                                    echo "<small>";
                                    if(Yii::$app->user->isAdmin() || $comment->created_by == Yii::$app->user->id) {
                                        echo " &#8212; ";
                                        echo Html::a("Edit", array('//questionanswer/comment/update', 'id'=>$comment->id));
                                    }
                                    
                                    if(Yii::$app->user->isAdmin()) {
                                        echo " &bull; ";
                                        echo Html::button('Delete',array(
                                        'submit'=> Url::toRoute(['comment/delete', array('id'=>$comment->id)]),
                                        'confirm'=>"Are you sure want to delete?",
                                        'csrf'=>true,
                                        'params'=> array('YII_CSRF_TOKEN' => Yii::$app->request->csrfToken)));
                                    }
                                    echo "</small>";
                                    
                                    echo '</div>';
                                }
                                echo "</div>";
                            }
                            ?>
                            <br />
                            <br />
                            <?php
                            echo \humhub\modules\questionanswer\widgets\CommentFormWidget::widget(array('model' => new Comment, 'question_id' => $model->id, 'parent_id' => $model->id));
//                            $this->widget('application.modules.questionanswer.widgets.CommentFormWidget', array('model' => new Comment, 'question_id' => $model->id, 'parent_id' => $model->id));
                            ?>
                            <?php
                            if(Yii::$app->user->isAdmin() || $model->created_by == Yii::$app->user->id) {
                            	echo Html::a("Edit", array('update', 'id'=>$model->id));
                            }
                            ?>
                            &bull;
							<?php
						    if(Yii::$app->user->isAdmin()) {
                                //todo: refactor into a nice widget
                                echo humhub\widgets\ModalConfirm::widget(array(
                                    'uniqueID' => 'modal_postdelete_' . $model->id,
                                    'linkOutput' => 'a',
                                    'title' => Yii::t('ContentModule.widgets_views_deleteLink', '<strong>Confirm</strong> question deleting'),
                                    'message' => Yii::t('ContentModule.widgets_views_deleteLink', 'Do you really want to delete this question? All answers will be lost!'),
                                    'buttonTrue' => Yii::t('ContentModule.widgets_views_deleteLink', 'Delete'),
                                    'buttonFalse' => Yii::t('ContentModule.widgets_views_deleteLink', 'Cancel'),
                                    'linkContent' => '<i class="fa fa-trash-o"></i> ' . Yii::t('ContentModule.widgets_views_deleteLink', 'Delete'),
                                    'linkHref' => URL::toRoute(['delete', 'id' => $model->id]),
                                    'confirmJS' => 'function(json) { $(".wall_"+json.uniqueId).remove(); }'
                                ));
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
                                //$vote = QuestionVotes::post($question_answer['id'])->user(Yii::$app->user->id)->find();
                                $vote = QuestionVotes::findOne(['post_id' => $question_answer['id'], 'id' => Yii::$app->user->id]);
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
                                <?php VoteButtonWidget::widget(array('post_id' => $question_answer['id'], 'model' => new QuestionVotes, 'vote_on' => 'answer', 'vote_type' => 'up', 'class' => $upBtnClass, 'should_open_question' => 1)); ?>
                                <div class="text-center"><strong><?php echo $question_answer['score']; ?></strong><br /></div>
                                <?php VoteButtonWidget::widget(array('post_id' => $question_answer['id'], 'model' => new QuestionVotes, 'vote_on' => 'answer', 'vote_type' => 'down', 'class' => $downBtnClass, 'should_open_question' => 1)); ?>
                            </div>
                        </div>
                        <?php $user = User::findOne(['id' => $question_answer['created_by']]); ?>
                        <?php
                        ProfileWidget::widget(array('user' => $user, 'timestamp' => $question_answer['created_at']));
                        ?>
                        <div class="media-body" style="padding-top:5px; ">
                            <br />
                            <?php print Html::encode($question_answer['post_text']); ?>
                            <br />
                            <br />
                            <?php
                            echo \humhub\modules\questionanswer\widgets\BestAnswerWidget::widget(array(
                                'post_id' => $question_answer['id'],
                                'author' => $author,
                                'model' => new QuestionVotes,
                                'accepted_answer' => ($question_answer['answer_status'] ? true : false)
                            ));
                            ?>

                            <?php
                            $answerModel = Answer::findOne(['id' => $question_answer['id']]);
                            $comments = $answerModel->comments;

                            echo ShowFiles::widget(array('object' => $model));

                            if($comments) {
                                echo "<div style=\"border: 1px solid #ccc; background-color: #f2f2f2; padding:10px; margin-top:10px;\">";
                                foreach($comments as $comment) {
                                    echo '<div style="border-bottom:1px solid #d8d8d8; padding: 4px;">';
                                    print Html::encode($comment->post_text);
                                    echo " &bull; <a href=\"". $this->createUrl('//user/profile', array('uguid' => $comment->user->guid)) . "\">" . $comment->user->displayName . "</a>";
                                    
                                    echo "<small>";
                                    if(Yii::$app->user->isAdmin() || $comment->created_by == Yii::$app->user->id) {
                                        echo " &#8212; ";
                                        echo Html::a("Edit", array('//questionanswer/comment/update', 'id'=>$comment->id));
                                    }
                                    
                                    if(Yii::$app->user->isAdmin()) {
                                        echo " &bull; ";
                                        echo Html::button('Delete',array(
                                        'submit'=>\yii\helpers\Url::toRoute('comment/delete',array('id'=>$comment->id)),
                                        'confirm'=>"Are you sure want to delete?",
                                        'csrf'=>true,
                                        'params'=> array('YII_CSRF_TOKEN' => Yii::$app->request->csrfToken)));
                                    }
                                    echo "</small>";

                                    echo '</div>';
                                }
                                echo "</div>";
                            }
                            ?>
                            <br />
                            <?php
                            echo \humhub\modules\questionanswer\widgets\CommentFormWidget::widget(array('model' => new Comment, 'question_id' => $question_answer['question_id'], 'parent_id' => $question_answer['id']));
                            ?>
                            <?php 
                            if(Yii::$app->user->isAdmin() || $question_answer['created_by'] == Yii::$app->user->id) {
                                echo Html::a("Edit", array('//questionanswer/answer/update', 'id'=>$question_answer['id']));
                            }
                            ?>
                            &bull;
                            <?php
                            if(Yii::$app->user->isAdmin()) {
                                echo Html::button('Delete',array(
                                'submit'=>\yii\helpers\Url::toRoute('answer/delete',array('id'=>$question_answer['id'])),
                                'confirm'=>"Are you sure want to delete?",
                                'csrf'=>true,
                                'params'=> array('YII_CSRF_TOKEN' => Yii::$app->request->csrfToken)));
                            }

                            ?>
                        </div>

                    </div>
                    
                </div>
            </div>
            <?php } ?>


            <?php
            echo \humhub\modules\questionanswer\widgets\AnswerFormWidget::widget(array('question' => $model, 'answer' => new Answer));
            ?>

        </div>

        <div class="col-md-3">
            
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Related</strong> Questions</div>
                <?php if(count($related) > 0) { ?>
                    <div class="list-group">
                        <?php foreach ($related as $question) { ?>
                            <a class="list-group-item" href="<?php echo Url::toRoute(['question/view', array('id' => $question['id'])]); ?>"><?php echo Html::encode($question['post_title']); ?></a>
                        <?php } ?>
                    </div>
                    <br>
                <?php } else { ?>
                    <div class="panel-body"><p>No related questions</p></div>
                <?php } ?>
            </div>
            
        </div>
    </div>
</div>
<!-- end: show content -->

