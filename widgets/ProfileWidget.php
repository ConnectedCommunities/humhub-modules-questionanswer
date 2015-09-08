<?php

/**
 * ProfileWidget. 
 * Displays the user profile
 * 
 * @package application.modules.questionanswer.widgets
 * @since 0.5
 * @author Luke
 */
class ProfileWidget extends HWidget {

    /**
     * The user object
     *
     * @var User
     */
    public $user;

    /** 
     * Timestamp
     *
     * @var Datetime
     */
    public $timestamp;

    /**
     * Executes the widget.
     */
    public function run() {

        $this->render('profile', array(
            'user' => $this->user,
            'timestamp' => $this->timestamp
        ));
    }

}

?>
