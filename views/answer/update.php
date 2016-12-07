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

?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default qanda-panel">
                <div class="panel-body">
                    <div class="media">
                        <div class="media-body" style="padding-top:5px; ">
                            <h3 class="media-heading">Edit Answer #<?php echo $model->id ?></h3>
                            <?php echo $this->render('_form', array('model'=>$model)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>