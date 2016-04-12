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
	                <textarea id="contentForm_question" class="form-control autosize contentForm" rows="1" placeholder="Ask something..." name="Question[post_title]"></textarea>
	                <input value="Space" name="Question[containerClass]" id="Question_containerClass" type="hidden">
	                <input value="204a13c6-db8e-4cd9-9e81-66055e1b1a50" name="Question[containerGuid]" id="Question_containerGuid" type="hidden">
                        <div class="contentForm_options">
                    	    <textarea id="contentForm_answersText" rows="5" class="form-control contentForm" placeholder="Question details..." name="Question[post_text]"></textarea><br>
                            <input class="form-control autosize contentForm" placeholder="Tags... Specify at least one tag for your question" name="Tags" id="Tags" type="text">
                        </div>
                        <div class="modal-file-upload pull-left">
                            <input id="fileUploaderHiddenField_contentFormFiles" value="" name="fileList" type="hidden">
                            <span class="btn btn-info fileinput-button tt" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Upload files">
                                <i class="icon icon-paperclip"></i>
                                <input id="fileUploaderButton_contentFormFiles" name="files[]" data-url="/teachconnect/humhub/index.php?r=file/file/upload&amp;objectModel=&amp;objectId=" multiple="" type="file">
                            </span>


                            <div class="progress" id="fileUploaderProgressbar_contentFormFiles" style="display:none">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                </div>
                             </div>

                            <div id="fileUploaderList_contentFormFiles">
                                <ul style="list-style: none; margin: 0;" class="contentForm-upload-list" id="fileUploaderListUl_contentFormFiles"></ul>
                            </div>
                        </div>

                        <input value="ac45f956-9307-4718-84b9-14ce4852c8f8" name="containerGuid" id="containerGuid" type="hidden"><input value="User" name="containerClass" id="containerClass" type="hidden">
                        <input class=" btn btn-info pull-right" name="yt0" value="Submit" type="submit">
                    </div>
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

        var questions = ['When should my registration be finalised?', 'How do I ensure my registration is processed quickly?', 'When should I submit my registration?', 'When should I submit my registration?', 'When should I submit my registration?', 'When should I submit my registration?', 'When should I submit my registration?', 'When should I submit my registration?', 'When should I submit my registration?', 'When should I submit my registration?', 'When should I submit my registration?', 'When should I submit my registration?', 'When should I submit my registration?'
        ];

        $('#qanda-search .typeahead').typeahead({
          hint: true,
          highlight: true,
          minLength: 1
        },
        {
          name: 'questions',
          source: substringMatcher(questions),
          templates: {
                footer: '<btn class="btn btn-info" data-toggle="modal" data-target="#modalAskNewQuestion">Ask new question</button>',
                empty: '<p>No results found matching your query.</p><btn class="btn btn-info" data-toggle="modal" data-target="#modalAskNewQuestion">Ask new question</button>'
            }
        });

    });
</script>