
<?php $form = \yii\widgets\ActiveForm::begin([
    'action' => \yii\helpers\Url::to('create')
]); ?>

    <?php if(!isset($btnClass)) $btnClass = "btn btn-default btn-xs"; ?>
    <?php echo \yii\helpers\Html::input('text', 'should_open_question', $should_open_question); ?>
    <?php echo \yii\helpers\Html::input('text', 'post_id', $post_id); ?>
    <?php echo \yii\helpers\Html::input('text', 'vote_on', $vote_on); ?>
    <?php echo \yii\helpers\Html::input('text', 'vote_type', $vote_type); ?>
    <?php echo \yii\helpers\Html::tag('button', '<i class="fa fa-angle-'.$vote_type.'"></i>', array(
        'options' => array('class'=> $btnClass . " " . $class, 'type'=>'submit', 'style' => 'margin-top:5px;')
    )); ?>

<?php \yii\widgets\ActiveForm::end(); ?>