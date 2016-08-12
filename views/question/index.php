<?php
/* @var $this QuestionController */
/* @var $dataProvider CActiveDataProvider */


use humhub\modules\user\components\User;

?>

<link rel="stylesheet" type="text/css"
         href="<?php echo $this->context->module->assetsUrl; ?>/css/questionanswer.css"/>
         
<script type="text/javascript"
            src="<?php echo $this->context->module->assetsUrl; ?>/js/typeahead/typeahead.bundle.js"></script>
            
<div class="container">

	<!-- Top Banner -->
    <div class="row qanda-banner">
        <div class="col-md-12">
            <div class="panel panel-default panel-profile">
    			<div class="panel-profile-header">
        			<div class="image-upload-container">
            			<img class="img-profile-header-background img-profile-header-background-qanda" id="space-banner-image" src="<?php echo $this->theme->getBaseUrl(); ?>/img/tc-qanda-banner.png" width="100%">
            
                        <div class="img-profile-data">
                            <h1 class="space">Community Knowledge</h1>
                            <h2 class="space">A searchable repository of teaching knowledge.</h2>
                        </div>
        			</div>

                    <div class="image-upload-container profile-user-photo-container">
                        <img class="img-rounded profile-user-photo" id="space-profile-image" src="<?php echo $this->theme->getBaseUrl(); ?>/img/tc-profile-qanda.png" data-src="holder.js/140x140" alt="140x140">
                    </div>

    			</div>
			</div>
        </div>
    </div>
    
    <div id="qanda-search" class="text-center">
      <span class="tt-input-span">
          <div id="scrollable-dropdown-menu">
              <input class="form-control typeahead searchInput fullwidth" type="text" placeholder="Search, Ask a Question or Share Something">
          </div>
      </span>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default qanda-panel">
                <?= $this->render('../partials/top_menu_bar'); ?>
                <div class="panel-body">
                    <?php
                       echo \yii\widgets\ListView::widget(array(
                            'dataProvider'=> $dataProvider,
                            'id'=>'customDataList',
                            'itemView'=>'_view',
                            'summaryOptions' => [
                                'style' => 'float:right',
                                'class' => 'summary'
                            ],
                        ));
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4 layout-sidebar-container">
            <div class="row">
                <div class="col-xs-12" id="quotes">
					<div class="panel panel-default panel-teachingquotes">
                        <img src="<?php echo $this->theme->getBaseUrl(); ?>/img/tc-apple.png" style="">
                        <?= $this->render('/quotes/quotes', array()); ?>
                    </div>
                </div>
            </div>
            <?= \humhub\modules\questionanswer\widgets\KnowledgeTour::widget(); ?>
            <?= \humhub\modules\activity\widgets\Stream::widget(['streamAction' => '//dashboard/dashboard/stream']); ?>
        </div>
    </div>
</div>
<!-- end: show content -->


<script type="text/javascript">
    // Owl Carousel Script - for rotating quotations
    $(document).ready(function () {

        // Only show welcome modal on first view
        if($.cookie('_viewed_welcome_modal') == undefined) {

            $.cookie('_viewed_welcome_modal', true, { path: '/', expires: 5 * 365 });
            // $.removeCookie('_viewed_welcome_modal', { path: '/' });
            $('#modalFirstUse').modal('show');
        }

        $(".panel-teachingquotes .owl-carousel").owlCarousel({
            animateOut: 'fadeOutDown',
            animateIn: 'fadeInDown',
            items:1,
            margin:30,
            stagePadding:30,
            fluidSpeed:50,
            autoplay:true,
            loop:true,
            dots: true,
            nav: false
        });

        // Owl Carousel for Instructions on first use in modal - initiate when modal is opened
        $('#modalFirstUse').on('shown.bs.modal', function () {
            $(".modal .owl-carousel").owlCarousel({
                items: 1,
                loop: false,
                dots: true,
                nav:false
            });

            // Custom next button on modal
            $('.customNextBtn').click(function () {
                $(".modal .owl-carousel").trigger('next.owl.carousel');
            })
        });

    });

</script>
<!-- Ask Question Modal -->
<div class="modal" id="modalAskNewQuestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                	<h3 class="text-center" style="margin-bottom:0px;"><strong>Ask</strong> a new question or share something</h3>
	            </div>
	            <div class="panel-body">
	                <div class="col-xs-12">
                        <?php $form=\yii\bootstrap\ActiveForm::begin(array(
                            'action' => \yii\helpers\Url::toRoute(["/questionanswer/default/create"]),
                            'id'=>'question-form_create',

                        )); ?>
                        <div class="logErrors"></div>
                            <?php echo $form->field($question,'post_title')->textarea(array('class' => 'form-control autosize contentForm post_title', 'rows' => '1', "placeholder" => "Ask or share anything!")); ?>

                            <div class="contentForm_options">
                                <?php echo $form->field($question,'post_text')->textarea(array('rows' => '5', 'style' => 'height: auto !important;', "class" => "form-control contentForm", "placeholder" => "What is it about teaching that is confusing or exciting you today?")); ?>
                                <br />
                                <?php echo \yii\helpers\Html::textInput('Tags', null, array('class' => 'form-control autosize contentForm', "placeholder" => "Enter comma separated tags here...")); ?>
                                <p class="help-block">Example: teaching, students, lesson planning ...</p>
                            </div>

                            <div class="row" style="padding-bottom:20px;">
                                <div class="col-xs-12">
                                <div class="pull-left">
                                    <?php
                                    // Creates Uploading Button
                                        echo \humhub\modules\file\widgets\FileUploadButton::widget(array(
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
                                        echo \humhub\modules\file\widgets\FileUploadList::widget(array(
                                            'uploaderId' => 'contentFormFiles'
                                        ));

                                    ?>

                                </div>

                                <?php
                                    echo \yii\helpers\Html::hiddenInput("uguid", Yii::$app->user->guid);
//                                    echo \yii\helpers\Html::hiddenInput("sguid", Yii::$app->user->guid);
                                ?>

                                <?php echo \yii\helpers\Html::submitButton('Submit', array('class' => ' btn btn-info pull-right')); ?>
                            </div>
                        </div>
                        <?php \yii\bootstrap\ActiveForm::end(); ?>
                    </div>
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

        var questions = '<?= addslashes($resultSearchData); ?>';
        $('#qanda-search .typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'questions',
            source: substringMatcher(JSON.parse(questions)),
            limit: 1000,
            templates: {
                footer: '<btn class="btn btn-info btn-new-post" data-toggle="modal" data-target="#modalAskNewQuestion">Ask new question</button>',
                empty: '<p>No results found matching your query.</p><btn class="btn btn-info btn-new-post" data-toggle="modal" data-target="#modalAskNewQuestion">Ask a new question or share something</button>',
            }
        });

        $('.searchInput').on("keyup", function() {
            var dataSearch = $(".tt-dataset .tt-suggestion").detach();
            if(dataSearch.length) {
                var html = "<div class='scrollSearchData'>";
                    $.each(dataSearch,function(index, value) {
                        html+=$(this)[0].outerHTML;
                    })
                html+="</div>";

                $(".tt-dataset .btn").before(html);
            }
        })

        $(document).on("click", ".tt-suggestion", function() {
            var text = $(this).text();
            $.ajax({
                    data: {text:text},
                    type: "POST",
                    url: '<?= \yii\helpers\Url::toRoute("/questionanswer/question/get-location-one-select-item") ?>',
                    success: function (data) {
                        if(data) {
                            window.location.href = data;
                        }
                    }
                }
            );
        });

        $("#question-form_create").submit(function() {
                $.ajax({
                    data: $(this).serialize(),
                    type: "POST",
                    url: '<?= \yii\helpers\Url::toRoute("/questionanswer/question/create") ?>',
                    success: function (data) {
                        var res = JSON.parse(data);
                        if(res.flag) {
                            $(".logErrors").html(res.errors);
                        } else {
                            $(".logErrors").empty();
                            window.location.href = res.location;
                        }
                    }
                });

            return false;
        });

        $(document).on("click",".btn-new-post",function() {
            var text = $(".tt-input.searchInput[value!='']").val();
            $(".post_title").val(text);
        });

    });
</script>