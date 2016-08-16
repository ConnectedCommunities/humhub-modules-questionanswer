<?php if(!empty($user) && !empty($target) && (\Yii::app()->user->id != $target->created_by)) {  ?>
    <div class="answer-activity">
        <?php $this->beginContent('application.modules_core.activity.views.activityLayout', array('activity' => $activity)); ?>
            <?php
                echo Yii::t('TasksModule.views_activities_TaskCreated', '<i class="fa fa-stack-exchange color-qanda" style="margin-right: 5px;color: #fdc015;vertical-align: middle"></i> {userName} answered "{answer}".', array(
                    '{userName}' => '<strong>' . CHtml::encode($user->displayName) . '</strong>',
                    '{answer}' => '<strong>' . ActivityModule::formatOutput($target->post_text) . '</strong>'
                ));
            ?>
        <?php $this->endContent(); ?>
    </div>
<?php } ?>

