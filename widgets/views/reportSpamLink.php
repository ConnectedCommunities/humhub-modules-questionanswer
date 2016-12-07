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

use yii\helpers\Html;
use humhub\compat\CActiveForm;
?>
<!-- Link in menu for reporting the post -->
    <a href="#"
       class="qanda-button pull-left"
       id="reportLinkPost_modal_postreport_<?php echo $object->id; ?>"
       data-toggle="modal"
       data-target="#submitReportContent_<?php echo $object->id; ?>"> <?php echo '<i class="fa fa-exclamation-circle"></i> ' . Yii::t('ReportcontentModule.widgets_views_reportSpamLink', 'Report post'); ?>
    </a>


    <!-- Modal with reasons of report -->
    <div class="modal" id="submitReportContent_<?php echo $object->id;?>"
         tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-small animated pulse">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">
                        <strong><?php echo  Yii::t('ReportcontentModule.widgets_views_reportSpamLink', 'Help Us Understand What\'s Happening'); ?>
                        </strong>
                    </h4>

                </div>
                <hr />
                <?php $form = CActiveForm::begin(['id' => 'report-content-form']); ?>
                <?php echo $form->hiddenField($model, 'object_id', array('value' => $object->id)); ?>
                <div class="modal-body text-left">

                    <?php echo $form->labelEx($model, 'reason'); ?>
                    <br />
                    <?php
                    echo $form->radioButtonList($model, 'reason', array('1' => Yii::t('ReportcontentModule.widgets_views_reportSpamLink', 'Does not belong to this space'),
                        '2' => Yii::t('ReportcontentModule.widgets_views_reportSpamLink', 'It\'s offensive'),
                        '3' => Yii::t('ReportcontentModule.widgets_views_reportSpamLink', 'It\'s spam')));
                    ?>
                    <?php echo $form->error($model, 'reason'); ?>



                </div>
                <hr />
                <div class="modal-footer">

                    <?php
                    echo \humhub\widgets\AjaxButton::widget([
                        'label' => Yii::t('ReportcontentModule.widgets_views_reportSpamLink', 'Submit'),
                        'tag' => 'button',
                        'ajaxOptions' => [
                            'type' => 'POST',
                            'beforeSend' => new yii\web\JsExpression('function(){ setModalLoader(); }'),
                            'success' => new yii\web\JsExpression('function(data){ if(data.success) $("#reportLinkPost_modal_postreport_' . $object->id . '").hide(); }'),
                            'url' => \yii\helpers\Url::to(['/questionanswer/question/report']),
                        ],
                        'htmlOptions' => [
                            'return' => 'true',
                            'class' => 'btn btn-primary', 'data-dismiss' => "modal", 'disabled' => 'disabled'
                        ]
                    ]);
                    ?>
                </div>
                <?php CActiveForm::end(); ?>
            </div>
        </div>
    </div>

<script type="text/javascript">

    $(document).ready(function () {
        // move modal to body
        $('#submitReportContent_<?php echo $object->id; ?>').appendTo(document.body);

    });


    $(function(){
        $('#submitReportContent_<?php echo $object->id; ?>').find("input[type='radio']").change(function () {
            $('#submitReportContent_<?php echo $object->id; ?>').find("button").prop("disabled", false);
        });
    });

</script>