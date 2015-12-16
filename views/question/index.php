<?php
/* @var $this QuestionController */
/* @var $dataProvider CActiveDataProvider */

use yii\widgets\ListView;
?>

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
        <div class="col-md-12">
            <div class="panel panel-default qanda-panel">
                <?php echo $this->render('../partials/top_menu_bar'); ?>
                <div class="panel-body">

                <?php
                echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_view'
                ]);
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end: show content -->
