<?php if(!empty($user) && !empty($target) && (\Yii::app()->user->id != $target->created_by)) {  ?>
    <div class="question-activity">
        <?php $this->beginContent('application.modules_core.activity.views.activityLayout', array('activity' => $activity)); ?>
            <?php echo Yii::t('TasksModule.views_activities_TaskCreated', '<i class="fa fa-stack-exchange" style="margin-right: 5px;color: #ffdf2c;vertical-align: middle"></i> {userName} asked "{answer}".', array(
                '{userName}' => '<strong>' . CHtml::encode($user->displayName) . '</strong>',
                '{answer}' => '<strong>' . ActivityModule::formatOutput($target->post_title) . '</strong>'
            ));
        ?>
        <?php $this->endContent(); ?>
    </div>
<?php } ?>