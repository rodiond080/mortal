<?php
namespace application\controllers\main;
use application\libs\pagination\AmaticPaginationMaker;
use application\main\Controller;
//use application\libs\Pagination;

class MainNewsController extends Controller{

    public function newsAction(){
        $localId = $this->getId($_SERVER['REQUEST_URI']);
        $numberOfNewsPerPage = 18;
        $numberOfNews=$this->model->countNumberOfNews();
//        $pagination = new Pagination($localId, $numberOfNews,$numberOfNewsPerPage);
        $paginationMaker = new AmaticPaginationMaker();

        $this->view->render("Mörtal", [
            'pagination'=>$paginationMaker->makePagination($localId, $numberOfNews, $numberOfNewsPerPage),
            'parameters'=>$this->model->getNewsForPage($localId, $numberOfNews, $numberOfNewsPerPage)
        ]);
    }

    public static function getId($uri){
        return basename($uri, "?");
    }
}