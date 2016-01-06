<?php

echo humhub\widgets\ModalConfirm::widget(array(
    'uniqueID' => 'modal_postdelete_' . $id,
    'linkOutput' => 'a',
    'title' => Yii::t('ContentModule.widgets_views_deleteLink', $title),
    'message' => Yii::t('ContentModule.widgets_views_deleteLink', $message),
    'buttonTrue' => Yii::t('ContentModule.widgets_views_deleteLink', 'Delete'),
    'buttonFalse' => Yii::t('ContentModule.widgets_views_deleteLink', 'Cancel'),
    'linkContent' => '<i class="fa fa-trash-o"></i> ' . Yii::t('ContentModule.widgets_views_deleteLink', 'Delete'),
    'linkHref' => $deleteRoute,
    'confirmJS' => 'function(json) { $(".wall_"+json.uniqueId).remove(); }'
));

?>