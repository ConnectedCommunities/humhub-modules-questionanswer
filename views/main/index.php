<style>
.vote_control .btn-xs:nth-child(1) {
    margin-bottom:3px;
}

.qanda-panel {
    margin-top:57px;
}

.qanda-header-tabs {
    margin-top:-49px;
}

</style>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default qanda-panel">
                <div class="panel-heading">
                    <ul class="nav nav-tabs qanda-header-tabs" id="filter">
                        <li class="dropdown active">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Questions</a>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Unanswered</a>
                        </li>
                        <li class=" dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Filter <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="wallFilter" id="filter_entry_userinvoled"><i class="fa fa-square-o"></i> Where I´m involved</a></li>
                                <li><a href="#" class="wallFilter" id="filter_entry_mine"><i class="fa fa-square-o"></i> Created by me</a></li>

                                <!-- post module related -->
                                <li><a href="#" class="wallFilter" id="filter_entry_files"><i class="fa fa-square-o"></i> Content with attached files</a></li>
                                <li><a href="#" class="wallFilter" id="filter_posts_links"><i class="fa fa-square-o"></i> Posts with links</a></li>
                                <li><a href="#" class="wallFilter" id="filter_model_posts"><i class="fa fa-square-o"></i> Posts only</a></li>
                                <!-- /post module related -->

                                <li class="divider"></li>

                                <li><a href="#" class="wallFilter" id="filter_entry_archived"><i class="fa fa-square-o"></i> Include archived posts</a></li>
                                <li><a href="#" class="wallFilter" id="filter_visibility_public"><i class="fa fa-square-o"></i> Only public posts</a></li>
                                <li><a href="#" class="wallFilter" id="filter_visibility_private"><i class="fa fa-square-o"></i> Only private posts</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Sorting                <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="wallSorting" id="sorting_c"><i class="fa fa-check-square-o"></i> Creation time</a></li>
                                <li><a href="#" class="wallSorting" id="sorting_u"><i class="fa fa-square-o"></i> Last update</a></li>
                            </ul>
                        </li>
                        <li class="dropdown pull-right">
                            <?php echo CHtml::link('<i class="fa fa-plus"></i> Ask Question', Yii::app()->createAbsoluteUrl('//questionanswer/main/new_question'), array('class'=>'dropdown-toggle btn btn-info', 'style'=>"padding:8px;")); ?>
                        </li>
                    </ul>
                </div>
                <div class="panel-body">

                <?php foreach ($questions as $question) { ?>
                    <div class="media" >
                        <div class="pull-left">
                            <div class="vote_control pull-left" style="padding:5px; padding-right:10px; border-right:1px solid #eee; margin-right:10px;">
                                <a class="btn btn-default btn-xs" href="#"><i class="fa fa-angle-up"></i></a><br />
                                <a class="btn btn-default btn-xs" href="#"><i class="fa fa-angle-down"></i></a>
                            </div>
                            <!--<a href="" class="pull-left" style="padding-top:5px; padding-right:10px;">
                                <img class="media-object img-rounded user-image" alt="40x40" data-src="holder.js/40x40" style="width: 40px; height: 40px;" src="img/default_user.jpg?cacheId=0" width="40" height="40">
                            </a>-->
                            <div class="pull-left" style="text-align:center; margin-top:5px; margin-right:8px;">
                                <b>2</b>
                                <p>votes</p>
                            </div>
                            <div class="pull-left" style="text-align:center; margin-top:5px;">
                                <b>1</b>
                                <p>answer</p>
                            </div>

                        </div>

                        <div class="media-body" style="padding-top:5px; padding-left:10px;">
                            <h4 class="media-heading">
                                <?php echo CHtml::link(CHtml::encode($question->post_title), Yii::app()->createUrl('//questionanswer/main/view', array('id' => $question->id))); ?>
                            </h4>
                            <h5><?php echo CHtml::encode((strlen($question->post_text) > 203) ? substr($question->post_text,0,200).'...' : $question->post_text); ?></h5>
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