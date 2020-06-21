<?php
namespace application\controllers\main;
use application\main\Controller;

class MainGigsController extends Controller{

    public function gigsAction(){
        $listOfYears = $this->model->getGigsYears();
        $listOfGigs = $this->model->getGigsForYear($this->getId($_SERVER['REQUEST_URI']));
        $gigsData = [
            'year'=>$this->getId($_SERVER['REQUEST_URI']),
            'years' =>$listOfYears,
            'gigs'=>$listOfGigs
        ];

        $this->view->render('Mörtal', $gigsData);
    }


    public function getId($uri){
        return basename($uri, "?");
    }


}