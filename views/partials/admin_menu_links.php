<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php if(Yii::$app->user->isAdmin()) { ?>
    <?php
    $controller = Yii::$app->controller;
    $isQuestion = $controller->id === 'question' && $controller->action->id === 'admin';
    $isAnswer = $controller->id === 'answer' && $controller->action->id === 'admin';
    $isComment = $controller->id === 'comment' && $controller->action->id === 'admin';
    ?>
    <ul class="nav nav-tabs qanda-header-tabs" id="filter">
        <li class="dropdown <?php echo ($isQuestion ? "active" : ""); ?>">
            <?php echo Html::a('Questions', Url::toRoute('question/admin'), ['style' => 'cursor: pointer;']); ?>
        </li>
        <li class="dropdown <?php echo ($isAnswer ? "active" : ""); ?>">
            <?php echo Html::a('Answers', Url::toRoute('answer/admin'), ['style' => 'cursor: pointer;']); ?>
        </li>
        <li class="dropdown <?php echo ($isComment ? "active" : ""); ?>">
            <?php echo Html::a('Comments', Url::toRoute('comment/admin'), ['style' => 'cursor: pointer;']); ?>
        </li>
    </ul>
<?php } ?>

