<?php
/**
 * Connected Communities Initiative
 * Copyright (C) 2016  Queensland University of Technology
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
?>
<?php
/* @var $this QuestionController */
/* @var $dataProvider CActiveDataProvider */
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
                <?php $this->renderPartial('../partials/top_menu_bar'); ?>
                <div class="panel-body">

                <?php 
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$dataProvider,
                    'itemView'=>'_view',
                )); 
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end: show content -->
