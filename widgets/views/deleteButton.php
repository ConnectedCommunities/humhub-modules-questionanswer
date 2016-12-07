<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016 Queensland University of Technology
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

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