<?php
namespace application\controllers\main;
use application\main\Controller;

class MainPhotoController extends Controller{

    public function photoAction(){
        $this->view->render("Mörtal");
    }

}