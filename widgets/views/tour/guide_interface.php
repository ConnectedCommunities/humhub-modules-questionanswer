<script type="text/javascript">

    var gotoSpace = false;


    // Create a new tour
    var interfaceTour = new Tour({
        storage: false,
        template: '<div class="popover tour"> <div class="arrow"></div> <h3 class="popover-title"></h3> <div class="popover-content"></div> <div class="popover-navigation"> <div class="btn-group"> <button class="btn btn-sm btn-default" data-role="prev"><?php echo Yii::t('TourModule.base', '« Prev'); ?></button> <button class="btn btn-sm btn-default" data-role="next"><?php echo Yii::t('TourModule.base', 'Next »'); ?></button>  </div> <button class="btn btn-sm btn-default" data-role="end"><?php echo Yii::t('TourModule.base', 'End guide'); ?></button> </div> </div>',
        name: 'interface',
        onEnd: function(tour) {
            tourCompleted();
        }
    });


    // Add tour steps
    interfaceTour.addSteps([
        {
            // step 0
            orphan: true,
            backdrop: true,
            title: <?php echo json_encode(Yii::t('TourModule.widgets_views_guide_interface', '<strong>Community Knowledge</strong>')); ?>,
            content: <?php echo json_encode(Yii::t('TourModule.widgets_views_guide_interface', "Welcome to TeachConnect! This is your home page, where community knowledge is being developed around the teaching profession.<br><br>Here you can ask questions, share resources or see what other teachers are interested in. The community is made up of pre-service teachers, in-service teachers and subject experts across Queensland.")); ?>
        },
        {
            element: "#icon-notifications",
            title: <?php echo json_encode(Yii::t('TourModule.widgets_views_index', '<strong>Notifications</strong>')); ?>,
            content: <?php echo json_encode(Yii::t('TourModule.widgets_views_index', 'Don\'t lose track of things!<br /><br />This icon will keep you informed of activities and posts that concern you directly.')); ?>,
            placement: "bottom"
        },
        {
            element: ".dropdown.account",
            title: <?php echo json_encode(Yii::t('TourModule.widgets_views_index', '<strong>Account</strong> Menu')); ?>,
            content: <?php echo json_encode(Yii::t('TourModule.widgets_views_index', 'The account menu gives you access to your private settings and allows you to manage your public profile.')); ?>,
            placement: "bottom"
        },
        {
            element: ".typeahead",
            title: <?php echo json_encode(Yii::t('TourModule.widgets_views_index', '<strong>Search, share something</strong> or ask a question')); ?>,
            content: <?php echo json_encode(Yii::t('TourModule.widgets_views_index', 'Text to be defined.')); ?>,
            placement: "top"
        },
        {
            element: ".media-heading:eq(0)",
            title: <?php echo json_encode(Yii::t('TourModule.widgets_views_index', '<strong>Existing questions/answers</strong> title')); ?>,
            content: <?php echo json_encode(Yii::t('TourModule.widgets_views_index', 'Text to be defined.')); ?>,
            placement: "left"
        },
        {
            element: ".media-body:eq(0)",
            title: <?php echo json_encode(Yii::t('TourModule.widgets_views_index', '<strong>Existing questions/answers</strong> post')); ?>,
            content: <?php echo json_encode(Yii::t('TourModule.widgets_views_index', 'Text to be defined.')); ?>,
            placement: "left"
        },
        {
            element: ".vote_control:eq(0)",
            title: <?php echo json_encode(Yii::t('TourModule.widgets_views_index', '<strong>Existing questions/answers</strong> karma')); ?>,
            content: <?php echo json_encode(Yii::t('TourModule.widgets_views_index', 'Text to be defined.')); ?> + "<br><br><a href='javascript:gotoSpace = true; tourCompleted();'><?php echo Yii::t("TourModule.widgets_views_index", "<strong>Start</strong> mentorship circle guide"); ?></a><br><br>",
            placement: "bottom"
        }

    ]);

    // Initialize tour plugin
    interfaceTour.init();

    // start the tour
    interfaceTour.restart();




    /**
     * Set tour as seen
     */
    function tourCompleted() {
        // load user spaces
        $.ajax({
            'url': '<?php echo Yii::app()->createAbsoluteUrl('//tour/tour/tourCompleted', array('section' => 'interface')); ?>',
            'cache': false,
            'data': jQuery(this).parents("form").serialize()
        }).done(function() {
            // cross out welcome tour entry
            $('#interface_entry').addClass('completed');

            if (gotoSpace == true) {

                // redirect to space
                window.location.href = "<?php echo Yii::app()->createUrl('//tour/tour/startSpaceTour'); ?>";
            }
        });
    }



</script>