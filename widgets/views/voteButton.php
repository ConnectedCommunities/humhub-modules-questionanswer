
<?php $form = \yii\widgets\ActiveForm::begin([
    'action' => \yii\helpers\Url::toRoute('vote/create')
]); ?>

    <?php if(!isset($btnClass)) $btnClass = "btn btn-default btn-xs"; ?>
    <?php echo $form->field($model, 'should_open_question')->hiddenInput(['value' => $should_open_question])->label(false); ?>
    <?php echo $form->field($model, 'post_id')->hiddenInput(['value' => $post_id])->label(false); ?>
    <?php echo $form->field($model, 'vote_on')->hiddenInput(['value' => $vote_on])->label(false); ?>
    <?php echo $form->field($model, 'vote_type')->hiddenInput(['value' => $vote_type])->label(false); ?>
    <?php echo \yii\helpers\Html::tag('button', '<i class="fa fa-angle-'.$vote_type.'"></i>', array(
        'options' => array('class'=> $btnClass . " " . $class, 'type'=>'submit', 'style' => 'margin-top:5px;')
    )); ?>

<?php \yii\widgets\ActiveForm::end(); ?>