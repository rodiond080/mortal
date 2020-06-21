<?php
namespace application\controllers\main;
use application\main\Controller;

class MainContactController extends Controller{

    public function contactAction(){
//        $result = $this->model->get();
        $this->view->render("Mörtal");
    }
}