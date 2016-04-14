<?php
/* @var $this QuestionController */
/* @var $dataProvider CActiveDataProvider */
?>

<link rel="stylesheet" type="text/css"
         href="<?php echo $this->module->assetsUrl; ?>/css/questionanswer.css"/>
         
<script type="text/javascript"
            src="<?php echo $this->module->assetsUrl; ?>/js/typeahead/typeahead.bundle.js"></script>
            
<div class="container">

	<!-- Top Banner -->
    <div class="row qanda-banner">
        <div class="col-md-12">
            <div class="panel panel-default panel-profile">
    			<div class="panel-profile-header">
        			<div class="image-upload-container">
            			<img class="img-profile-header-background img-profile-header-background-qanda" id="space-banner-image" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/tc-qanda-banner.png" width="100%">
            
                        <div class="img-profile-data">
                            <h1 class="space">Community Knowledge Q&amp;A</h1>
                            <h2 class="space">A searchable repository of teaching knowledge.</h2>
                        </div>
        			</div>

                    <div class="image-upload-container profile-user-photo-container">
                        <img class="img-rounded profile-user-photo" id="space-profile-image" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/tc-profile-qanda.png" data-src="holder.js/140x140" alt="140x140">
                    </div>

    			</div>
			</div>
        </div>
    </div>
    
    <div id="qanda-search" class="text-center">
      <span class="tt-input-span"><input class="form-control typeahead fullwidth" type="text" placeholder="Search or Ask a Question"></span>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default qanda-panel">
                <?php $this->renderPartial('../partials/top_menu_bar'); ?>
                <div class="panel-body">
                    <?php
                        $this->widget('zii.widgets.CListView', array(
                            'dataProvider'=>$dataProvider,
                            'id'=>'customDataList',
                            'ajaxUpdate'=>true,
                            'itemView'=>'_view',
                        ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end: show content -->

<!-- Ask Question Modal -->
<div class="modal" id="modalAskNewQuestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="panel panel-default">
                <div class="panel-heading">
                	<strong>Ask</strong> a new question
                	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
	            </div>
	            <div class="panel-body">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'action' => Yii::app()->createUrl("/questionanswer/question/create"),
                        'id'=>'question-new_question-form',
                        'enableAjaxValidation'=>true,
                    )); ?>
                        <?php echo $form->textArea($question,'post_title',array('class' => 'form-control autosize contentForm', 'rows' => '1', "placeholder" => "Ask something...")); ?>
                        <?php echo $form->error($question,'post_title'); ?>

                        <div class="contentForm_options">
                            <?php echo $form->textArea($question,'post_text',array('rows' => '5', 'style' => 'height: auto !important;', "class" => "form-control contentForm", "placeholder" => "Question details...")); ?>
                            <?php echo $form->error($question,'post_text'); ?>
                            <br />
                            <?php echo CHtml::textField('Tags', null, array('class' => 'form-control autosize contentForm', "placeholder" => "Tags... Specify at least one tag for your question")); ?>
                        </div>
                        <div class="pull-left" style="margin-top:5px;">
                            <?php
                            // Creates Uploading Button
                            $this->widget('application.modules_core.file.widgets.FileUploadButtonWidget', array(
                                'uploaderId' => 'contentFormFiles',
                                'fileListFieldName' => 'fileList',
                            ));
                            ?>
                            <script>
                                $('#fileUploaderButton_contentFormFiles').bind('fileuploaddone', function (e, data) {
                                    $('.btn_container').show();
                                });

                                $('#fileUploaderButton_contentFormFiles').bind('fileuploadprogressall', function (e, data) {
                                    var progress = parseInt(data.loaded / data.total * 100, 10);
                                    if (progress != 100) {
                                        // Fix: remove focus from upload button to hide tooltip
                                        $('#post_submit_button').focus();

                                        // hide form buttons
                                        $('.btn_container').hide();
                                    }
                                });
                            </script>
                            <?php
                            // Creates a list of already uploaded Files
                            $this->widget('application.modules_core.file.widgets.FileUploadListWidget', array(
                                'uploaderId' => 'contentFormFiles'
                            ));
                            ?>
                        </div>

                        <?php
                        echo CHtml::hiddenField("containerGuid", Yii::app()->user->guid);
                        echo CHtml::hiddenField("containerClass",  get_class(new User()));
                        ?>
                        <?php echo CHtml::submitButton('Submit', array('class' => ' btn btn-info pull-right', 'style' => 'margin-top: 5px;')); ?>
                    <?php $this->endWidget(); ?>
                </div>

            </div>
        </div>
    </div>
<!-- End Ask Question Modal -->

<script type="text/javascript">
	$(document).ready(function () {

	// Initiate Q&A typeahead searchbar
	var substringMatcher = function(strs) {
          return function findMatches(q, cb) {
            var matches, substringRegex;
            // an array that will be populated with substring matches
            matches = [];
            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');
            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
              if (substrRegex.test(str)) {
                matches.push(str);
              }
            });

            cb(matches);
          };
        };

        var questions = '<?= $resultSearchData ?>';
        $('#qanda-search .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'questions',
            source: substringMatcher(JSON.parse(questions)),
            templates: {
                footer: '<btn class="btn btn-info" data-toggle="modal" data-target="#modalAskNewQuestion">Ask new question</button>',
                empty: '<p>No results found matching your query.</p><btn class="btn btn-info" data-toggle="modal" data-target="#modalAskNewQuestion">Ask new question</button>'
            }
        });
//        $.ajax({
//            url: '<?//= Yii::app()->createUrl("/questionanswer/question/getSearch") ?>//',
//            type: "POST",
//            success: function (data) {
//                questions = JSON.parse(data);
//                $('#qanda-search .typeahead').typeahead({
//                        hint: true,
//                        highlight: true,
//                        minLength: 1
//                    },
//                    {
//                        name: 'questions',
//                        source: substringMatcher(questions),
//                        templates: {
//                            footer: '<btn class="btn btn-info" data-toggle="modal" data-target="#modalAskNewQuestion">Ask new question</button>',
//                            empty: '<p>No results found matching your query.</p><btn class="btn btn-info" data-toggle="modal" data-target="#modalAskNewQuestion">Ask new question</button>'
//                        }
//                    });
//            }
//        })

        $('.tt-suggestion').live("click", function() {
            var text = $(this).text();
            $.fn.yiiListView.update('customDataList', {
                    data: {text:text},
                    type:"POST",
                    url: '<?= Yii::app()->createUrl("/questionanswer/question/getSearchOneSelectItem") ?>',
                    success: function (data) {
                        $("#customDataList .items").html(data);
                    }
                }
            );
        });
    });
</script>