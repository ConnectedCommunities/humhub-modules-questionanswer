<?php

class MainController extends Controller{

    public function actionIndex(){
        $this->render('index');
    }

    public function actionAnswer() {
    	$this->render('answer');
    }
}