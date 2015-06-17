<div class="container">
    <div class="row">
        <div class="col-md-9">

            <?php
            // $this->widget('application.modules_core.wall.widgets.StreamWidget', array(
            //     'streamAction' => '//dashboard/dashboard/stream',
            //     'showFilters' => false,
            //     'messageStreamEmpty' => Yii::t('DashboardModule.views_dashboard_index', '<b>Your dashboard is empty!</b><br>Post something on your profile or join some spaces!'),
            // ));
            ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h1>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h1>
                    <div class="media" >
                        <div class="pull-left">
                            <div class="vote_control pull-left" style="padding:5px; padding-right:10px; border-right:1px solid #eee; margin-right:10px;">
                                <a class="btn btn-default btn-xs" href="#"><i class="fa fa-angle-up"></i></a><br />
                                <a class="btn btn-default btn-xs" href="#"><i class="fa fa-angle-down"></i></a>
                            </div>
                            <div class="pull-left" style="text-align:center; margin-top:5px; margin-right:8px;">
                                <b>2</b>
                                <p>votes</p>
                            </div>
                            <div class="pull-left" style="text-align:center; margin-top:5px;">
                                <b>1</b>
                                <p>answer</p>
                            </div>
                            <!-- <a href="/index.php?r=user/profile&amp;uguid=ba1069c3-aac0-4088-95b1-18e7d8440f7a" class="pull-left">
                                <img class="media-object img-rounded user-image user-ba1069c3-aac0-4088-95b1-18e7d8440f7a" alt="40x40" data-src="holder.js/40x40" style="width: 40px; height: 40px;" src="http://192.168.99.100/img/default_user.jpg?cacheId=0" width="40" height="40">
                            </a> -->
                        </div>

                        <div class="media-body" style="padding-top:5px; padding-left:10px;">
                            <h4 class="media-heading"><a href="/index.php?r=user/profile&amp;uguid=ba1069c3-aac0-4088-95b1-18e7d8440f7a">Lorem ipsum dolor sit amet</a></h4>
                            <h5>Nunc pharetra blandit sapien, et tempor nisi. Duis finibus venenatis commodo. Ut in metus placerat, tempor massa eget, mollis nisi.</h5>
                        </div>


                        <div class="well well-small comment-container" style="display: none;" id="comment_Post_1">
                            <div class="comment " id="comments_area_Post_1">
                            </div>

                            <div id="comment_create_form_Post_1" class="comment_create">
                            </div>
                        </div>

                    </div>

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