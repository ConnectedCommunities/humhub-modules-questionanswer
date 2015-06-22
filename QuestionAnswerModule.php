<?php
class QuestionAnswerModule extends HWebModule{
 
    /**
     * Inits the Module
     */
    public function init()
    {

        $this->setImport(array(
            'questionanswer.models.*',
        ));
    }
    
}