<?php
/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use humhub\modules\questionanswer\models\QuestionVotes;
use humhub\modules\user\models\User;
use \humhub\modules\questionanswer\models\Answer;
use \humhub\modules\questionanswer\models\Comment;
use humhub\modules\questionanswer\widgets\VoteButtonWidget;
use humhub\modules\questionanswer\widgets\ProfileWidget;
use humhub\modules\file\widgets\ShowFiles;
use humhub\modules\questionanswer\helpers\Url;
use yii\helpers\Html;

?>
<div class="container-fluid">
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

                                $vote = QuestionVotes::findOne(['post_id' => $model->id, 'created_by' => Yii::$app->user->id]);
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
                                echo VoteButtonWidget::widget(array('post_id' => $model->id, 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'up', 'btn_class' => $upBtnClass, 'should_open_question' => 1));
                                ?>
                                <div class="text-center"><strong>
                                <?php
                                echo QuestionVotes::score($model->id);
                                ?>
                                </strong><br /></div>
								<?php
                                echo VoteButtonWidget::widget(array('post_id' => $model->id, 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'down', 'btn_class' => $downBtnClass,  'should_open_question' => 1));
                                ?>
                            </div>
                            
                        </div>
                        
                        <?php
                        echo ProfileWidget::widget(array('user' => $model->user, 'timestamp' => $model->created_at));
                        ?>

                        <div class="media-body" style="padding-top:5px; ">
                            <h3 class="media-heading">
                                <?php echo Html::a(Html::encode($model->post_title), Url::createUrl('question/view', ['id' => $model->id])); ?>
                            </h3>
                            <?php echo humhub\widgets\RichText::widget(['text' => $model->post_text, 'record' => $model]); ?>
                            <br /><br />
                            <?php foreach($model->tags as $tag) { ?>
                                <span class="label label-default"><a href="<?php echo Url::createUrl('question/tag', ['id' => $tag->tag_id]); ?>"><?php echo $tag->tag->tag; ?></a></span>
                            <?php } ?>
                            <br /><br />
                            <?php
                            echo ShowFiles::widget(array('object' => $model));
                            $comments = Comment::findAll(['parent_id' => $model->id]);
                            if($comments) {
                                echo "<div style=\"border: 1px solid #ccc; background-color: #f2f2f2; padding:10px;\">";
                                foreach($comments as $comment) {
                                    echo '<div style="border-bottom:1px solid #d8d8d8; padding: 4px;">';
                                    echo humhub\widgets\RichText::widget(['text' => $comment->post_text, 'record' => $comment]);
                                    echo " &bull; <a href=\"". Url::createUrl('/user/profile', ['uguid' => $comment->user->guid]) . "\">" . $comment->user->displayName . "</a>";

                                    echo "<small>";
                                    if(Yii::$app->user->isAdmin() || $comment->created_by == Yii::$app->user->id) {
                                        echo " &#8212; ";
                                        echo Html::a("Edit", Url::createUrl('comment/update', ['id'=>$comment->id]));
                                    }

                                    if(Yii::$app->user->isAdmin()) {
                                        echo " &bull; ";
                                        echo \humhub\modules\questionanswer\widgets\DeleteButtonWidget::widget([
                                            'id' => 'comment_'.$comment->id,
                                            'deleteRoute' => URL::createUrl('comment/delete', ['id' => $comment->id]),
                                            'title' => '<strong>Confirm</strong> delete comment',
                                            'message' => 'Do you really want to delete this comment?',
                                        ]);
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
                            ?>
                            <?php
                            if(Yii::$app->user->isAdmin() || $model->created_by == Yii::$app->user->id) {
                            	echo Html::a("Edit", Url::createUrl('update', ['id'=>$model->id]));
                            }
                            ?>
                            &bull;
							<?php
						    if(Yii::$app->user->isAdmin()) {
                                echo \humhub\modules\questionanswer\widgets\DeleteButtonWidget::widget([
                                    'id' => 'question_'.$model->id,
                                    'deleteRoute' => URL::createUrl('question/delete', ['id' => $model->id]),
                                    'title' => '<strong>Confirm</strong> delete question',
                                    'message' => 'Do you really want to delete this question? All answers will be lost!',
                                ]);
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
                                $vote = QuestionVotes::findOne(['post_id' => $question_answer['id'], 'created_by' => Yii::$app->user->id]);
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
                                <?php echo \humhub\modules\questionanswer\widgets\VoteButtonWidget::widget(array('post_id' => $question_answer['id'], 'model' => new QuestionVotes, 'vote_on' => 'answer', 'vote_type' => 'up', 'btn_class' => $upBtnClass, 'should_open_question' => 0));?>
                                <div class="text-center"><strong><?php echo $question_answer['score']; ?></strong><br /></div>
                                <?php echo \humhub\modules\questionanswer\widgets\VoteButtonWidget::widget(array('post_id' => $question_answer['id'], 'model' => new QuestionVotes, 'vote_on' => 'answer', 'vote_type' => 'down', 'btn_class' => $downBtnClass, 'should_open_question' => 0));?>
                            </div>
                        </div>
                        <?php
                        $user = User::findOne(['id' => $question_answer['created_by']]);
                        echo ProfileWidget::widget(array('user' => $user, 'timestamp' => $question_answer['created_at']));
                        ?>
                        <div class="media-body" style="padding-top:5px; ">
                            <br />
                            <?php echo humhub\widgets\RichText::widget(['text' => $question_answer['post_text'], 'record' => $question_answer]); ?>
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

                            echo ShowFiles::widget(array('object' => $answerModel));

                            if($comments) {
                                echo "<div style=\"border: 1px solid #ccc; background-color: #f2f2f2; padding:10px; margin-top:10px;\">";
                                foreach($comments as $comment) {
                                    echo '<div style="border-bottom:1px solid #d8d8d8; padding: 4px;">';
                                    print Html::encode($comment->post_text);

                                    echo " &bull; <a href=\"". \yii\helpers\Url::createUrl(['/user/profile', 'uguid' => $comment->user->guid]) . "\">" . $comment->user->displayName . "</a>";

                                    echo "<small>";
                                    if(Yii::$app->user->isAdmin() || $comment->created_by == Yii::$app->user->id) {
                                        echo " &#8212; ";
                                        echo Html::a("Edit", array('//questionanswer/comment/update', 'id'=>$comment->id));
                                    }

                                    if(Yii::$app->user->isAdmin()) {
                                        echo " &bull; ";
                                        echo \humhub\modules\questionanswer\widgets\DeleteButtonWidget::widget([
                                            'id' => 'comment_'.$comment->id,
                                            'deleteRoute' => URL::createUrl(['comment/delete', 'id' => $comment->id]),
                                            'title' => '<strong>Confirm</strong> delete comment',
                                            'message' => 'Are you sure want to delete this comment?',
                                        ]);
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
                                echo \humhub\modules\questionanswer\widgets\DeleteButtonWidget::widget([
                                    'id' => 'answer_'.$question_answer['id'],
                                    'deleteRoute' => URL::createUrl('answer/delete', ['id' => $question_answer['id']]),
                                    'title' => '<strong>Confirm</strong> delete answer',
                                    'message' => 'Are you sure want to delete this answer?',
                                ]);
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
                            <a class="list-group-item" href="<?php echo Url::createUrl('question/view', ['id' => $question['id']]); ?>"><?php echo Html::encode($question['post_title']); ?></a>
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

