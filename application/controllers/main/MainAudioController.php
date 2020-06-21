<?php
namespace application\controllers\main;
use application\main\Controller;

class MainAudioController extends Controller{

    public function audioAction(){
        $this->view->render("Mörtal");
    }
}