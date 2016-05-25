<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default qanda-panel">
                <?php $this->renderPartial('../partials/top_menu_bar'); ?>
                <div class="panel-body">

                <?php
                // $this->widget('application.modules.reportcontent.widgets.ReportContentWidget', array('object' => Post::model()->findByPk(1)));
                // $this->widget('application.modules_core.file.widgets.FileUploadListWidget',[
                //     'uploaderId' => 'cover_uploader'
                // ]);
                // $this->widget('application.modules_core.admin.widgets.AdminMenuWidget', array());
                ?>

                <?php foreach ($questions as $question) { ?>
                    <div class="media" >
                        <div class="pull-left">
                            <div class="vote_control pull-left" style="padding:5px; padding-right:10px; border-right:1px solid #eee; margin-right:10px;">
                                <?php
                                $upBtnClass = ""; $downBtnClass = ""; $vote = "";

                                // Change the button class to 'active' if the user has voted
                                $vote = QuestionVotes::model()->post($question['id'])->user(Yii::app()->user->id)->find();
                                if($vote) {
                                    if($vote->vote_type == "up") {
                                        $upBtnClass = "active btn-info";
                                        $downBtnClass = "";
                                    } else {
                                        $downBtnClass = "active btn-info";
                                        $upBtnClass = "";
                                    }
                                }
                                ?>
                                <?php echo $this->renderPartial('vote', array('post_id' => $question['id'], 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'up', 'class' => $upBtnClass)); ?>
                                <?php echo $this->renderPartial('vote', array('post_id' => $question['id'], 'model' => new QuestionVotes, 'vote_on' => 'question', 'vote_type' => 'down', 'class' => $downBtnClass)); ?>
                            </div>
                            <!--<a href="" class="pull-left" style="padding-top:5px; padding-right:10px;">
                                <img class="media-object img-rounded user-image" alt="40x40" data-src="holder.js/40x40" style="width: 40px; height: 40px;" src="img/default_user.jpg?cacheId=0" width="40" height="40">
                            </a>-->
                            <div class="pull-left" style="text-align:center; margin-top:5px; margin-right:8px;">
                                <b><?php echo $question['vote_count']; ?></b>
                                <p>votes</p>
                            </div>
                            <div class="pull-left" style="text-align:center; margin-top:5px;">
                                <b><?php echo $question['answers']; ?></b>
                                <p>answers</p>
                            </div>

                        </div>

                        <div class="media-body" style="padding-top:5px; padding-left:10px;">
                            <h4 class="media-heading">
                                <?php echo CHtml::link(CHtml::encode($question['post_title']), Yii::app()->createUrl('//questionanswer/main/view', array('id' => $question['id']))); ?>
                            </h4>

                            <h5><?php echo CHtml::encode(Helpers::truncateText($question['post_text'], 200)); ?></h5>
                        </div>
                    </div>
                <?php } ?>

                </div>
            </div>
        </div>

        <div class="col-md-3">
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