<?php
namespace application\controllers\admin;
use application\libs\pagination\AdminGigsPaginationMaker;
use application\libs\pagination\AdminNewsPaginationMaker;
use application\main\Controller;

class AdminGigsController extends Controller{
    public function __construct($routeParameters){
        parent::__construct($routeParameters);
        $this->view->layout = 'admin_panel';
    }



    public function editGigsAction(){
        $localId = intval($this->getId($_SERVER['REQUEST_URI']));
        $numberOfGigsPerPage = 8;
        $numberOfGigs=$this->model->countNumberOfGigs();
        $paginationMaker = new AdminGigsPaginationMaker();
        $ultimateIndex = intval(ceil($numberOfGigs/$numberOfGigsPerPage));

        if($localId>$ultimateIndex){
            $localId=$ultimateIndex;
        }
//
        $this->view->render("The list of gigs",  [
            'pagination'=>$paginationMaker->makePagination($localId, $numberOfGigs, $numberOfGigsPerPage),
            'parameters'=>$this->model->getGigsForPage($localId, $numberOfGigs, $numberOfGigsPerPage)
        ]);


//        $rowOfGigs= $this->model->getGigs();
//        $this->view->render("Gigs", $rowOfGigs);
    }

    public function editGigAction(){
        $id = $this->getId($_SERVER['REQUEST_URI']);
        $rowOfGigs = $this->model->getGigWithId($id);
        $this->view->render("Edit a gig with id=".$id, $rowOfGigs);
    }

    public function deleteGigAction(){
        $id = $this->getId($_SERVER['REQUEST_URI']);
//        debug($id);
        $index = $_POST['index'];
        $this->model->deleteOneGig($id);
        header('Location: /admin/gigs/index/'.$index);
    }




    public function saveGigAction(){
        echo json_encode( $this->model->updateGig($_POST, $_FILES));
    }

    public function getGigPosterAction(){
        $_POST = json_decode(file_get_contents("php://input"), true);
        echo json_encode($this->model->getGigPoster($_POST));
    }

    public static function getId($uri){
        return basename($uri, "?");
    }
}