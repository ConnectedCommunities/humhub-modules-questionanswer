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


/* @var $this AnswerController */
/* @var $model Answer */
?>
<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-body">
				<h1>View Answer #<?php echo $model->id; ?></h1>
			</div>
		</div>
	</div>
</div>

<?php /* $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'question_id',
		'parent_id',
		'post_title',
		'post_text',
		'post_type',
		'created_at',
		'created_by',
		'updated_at',
		'updated_by',
	),
)); */?>
