<?php
use yii\helpers\Url;
$this->context->loadResources($this);
?>
<script type="text/javascript">
    var gotoProfile = false;
    $(document).ready(function() {

        // Create a new tour
        var spacesTour = new Tour({
            storage: false,
            template: '<div class="popover tour"> <div class="arrow"></div> <h3 class="popover-title"></h3> <div class="popover-content"></div> <div class="popover-navigation"> <div class="btn-group"> <button class="btn btn-sm btn-default" data-role="prev"><?php echo Yii::t('TourModule.base', '« Prev'); ?></button> <button class="btn btn-sm btn-default" data-role="next"><?php echo Yii::t('TourModule.base', 'Next »'); ?></button>  </div> <button class="btn btn-sm btn-default" data-role="end"><?php echo Yii::t('TourModule.base', 'End guide'); ?></button> </div> </div>',
            name: 'spaces',
            onEnd: function (tour) {
                tourCompleted();
            }
        });


        // Add tour steps
        spacesTour.addSteps([
            {
                orphan: true,
                backdrop: true,
                title: <?php echo json_encode(Yii::t('TourModule.widgets_views_guide_spaces', '<strong>Live Chat</strong>')); ?>,
                content: <?php echo json_encode(Yii::t('TourModule.widgets_views_guide_spaces', "This is your mentorship circle, where you can talk in-depth about your teaching.  Discuss it over with your group, or call upon an experienced mentor.")); ?>
            },
            {
                element: "#icon-messages",
                title: <?php echo json_encode(Yii::t('TourModule.widgets_views_guide_spaces', '<strong>Messaging</strong>')); ?>,
                content: <?php echo json_encode(Yii::t('TourModule.widgets_views_guide_spaces', 'Contact your mentor by name for private one-on-one advice.')); ?>,
                placement: "bottom"
            },
            {
                element: "#contentFormBody",
                title: <?php echo json_encode(Yii::t('TourModule.widgets_views_guide_spaces', '<strong>Writing</strong> posts')); ?>,
                content: <?php echo json_encode(Yii::t('TourModule.widgets_views_guide_spaces', 'New posts can be written and posted here.<br><br>Talk about what’s going on in your classroom – you may be surprised what comes back. Feeling confused or challenged? This is the space to let it out. Everything here is private – this group can be trusted.')); ?>,
                placement: "bottom"
            },
            {
                element: ".wall-entry:eq(0)",
                title: <?php echo json_encode(Yii::t('TourModule.widgets_views_guide_spaces', '<strong>Posts</strong>')); ?>,
                content: <?php echo json_encode(Yii::t('TourModule.widgets_views_guide_spaces', 'Yours, and other users\' posts will appear here.<br><br>These can then be liked or commented on.')); ?>,
                placement: "bottom"
            },
            {
                element: ".panel-activities",
                title: <?php echo json_encode(Yii::t('TourModule.widgets_views_guide_spaces', '<strong>Most recent</strong> activities')); ?>,
                content: <?php echo json_encode(Yii::t('TourModule.widgets_views_guide_spaces', 'To keep you up to date, other users\' most recent activities in this space will be displayed here, along with recent chat messages and community knowledge questions.')); ?>,
                placement: "left"
            },
            {
                element: "#space-members-panel",
                title: <?php echo json_encode(Yii::t('TourModule.widgets_views_guide_spaces', '<strong>Mentorship Circle</strong> members')); ?>,
                content: <?php echo json_encode(Yii::t('TourModule.widgets_views_guide_spaces', 'All users who are a member of this space will be displayed here.<br /><br />New members can be added by anyone who has been given access rights by the admin.')); ?> + "<br><br><a href='javascript:gotoSpace = true; tourCompleted();'><?php echo Yii::t("TourModule.widgets_views_index", "<strong>Start</strong> chat guide"); ?></a><br><br>",
            }
        ]);

        // Initialize tour plugin
        spacesTour.init();

        // start the tour
        spacesTour.restart();


        /**
         * Set tour as seen
         */
        function tourCompleted() {
            // load user spaces
            $.ajax({
                'url': '<?php echo Url::toRoute(array('//tour/tour/tour-completed', 'section' => 'chat')); ?>',
                'cache': false,
                'data': jQuery(this).parents("form").serialize()
            }).done(function () {
                if (gotoProfile == true) {
                    // redirect to profile
                    window.location.href="<?php echo Url::toRoute(array('//user/profile',  'uguid' => Yii::$app->user->guid,'tour' => 'true')); ?>";
                } else {
                    // redirect to dashboard
                    window.location.href="<?php echo Url::toRoute('//dashboard/dashboard'); ?>";
                }

            });
        }

    });

</script>