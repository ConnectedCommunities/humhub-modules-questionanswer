                <div class="panel-heading">
                    <ul class="nav nav-tabs qanda-header-tabs" id="filter">
                        <li class="dropdown active">
                            <a style="cursor:pointer;" href="<?php echo Yii::app()->createUrl('//questionanswer/main/index'); ?>">Questions</a>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Unanswered</a>
                        </li>
                        <li class=" dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tags <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <?php
                                $tags = Tag::model()->findAll();
                                if(!$tags) {
                                    echo "<li><a href=\"#\" class=\"wallFilter\">No tags found</a></li>";
                                } else {
                                    foreach($tags as $tag) {
                                        echo "<li><a href=\"".Yii::app()->createUrl('//questionanswer/main/tag', array('id' => $tag->id))."\" class=\"wallFilter\">".$tag->tag."</a></li>";
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Sorting<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="wallSorting" id="sorting_c"><i class="fa fa-check-square-o"></i> Creation time</a></li>
                                <li><a href="#" class="wallSorting" id="sorting_u"><i class="fa fa-square-o"></i> Last update</a></li>
                            </ul>
                        </li>
                        <?php if(Yii::app()->user->isAdmin()) { ?>
                            <li class="dropdown">
                                <?php echo CHtml::link('Admin', Yii::app()->createUrl('//questionanswer/question/admin'), array()); ?>
                            </li>
                        <?php } ?>
                        <li class="dropdown pull-right">
                            <?php echo CHtml::link('<i class="fa fa-plus"></i> Ask Question', Yii::app()->createAbsoluteUrl('//questionanswer/question/create'), array('class'=>'dropdown-toggle btn btn-info', 'style'=>"padding:8px;")); ?>
                        </li>
                    </ul>
                </div>