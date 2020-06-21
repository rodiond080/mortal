<?php
namespace application\controllers\main;
use application\main\Controller;

class MainController extends Controller{

    public function indexAction(){
        $this->view->render("Mörtal");
    }
}