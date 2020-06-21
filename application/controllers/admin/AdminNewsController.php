<?php
namespace application\controllers\admin;
use application\libs\pagination\AdminNewsPaginationMaker;
use application\main\Controller;


class AdminNewsController extends Controller{
    public function __construct($routeParameters){
        parent::__construct($routeParameters);
        $this->view->layout = 'admin_panel';
    }

    public function createNewOneNewsAction(){
        $this->view->setPathToSpecificView('application/views/admin/editOneNews.php');
        $date = date('Y-m-d').'T'.date('H:i');
        $this->view->render("Create news", [
            'news_date'=>$date,
            'news_id'=>'new',
            'news_heading'=>'',
            'news_content'=>'',
        ]);
    }

    public static function getId($uri){
        return basename($uri, "?");
    }

    public function loginAction(){
        if (!isset($_SESSION['admin'])){
                $_SESSION['admin'] = 0;
        }

        if($_SESSION['admin'] == 1){
            header('Location: /admin/news/index/1');
        }else{
            $this->view->render("Admin login");
        }
    }

    public function editNewsAction(){
        if ($_SESSION['admin'] == 1) {

            $this->successfulEntrance();
        }else{
            $login = $_POST['login'];
            $password = $_POST['password'];
            if ($this->model->thePasswordIsCorrect($login, $password)) {
                $_SESSION['admin'] = 1;
                $this->successfulEntrance();
            }else{
                $_SESSION['logged_in'] = "Wrong password or name";
                header('Location: /admin');
            }
        }
    }

    private function successfulEntrance(){
        $localId = intval($this->getId($_SERVER['REQUEST_URI']));
        $numberOfNewsPerPage = 8;
        $numberOfNews=$this->model->countNumberOfNews();
        $paginationMaker = new AdminNewsPaginationMaker();

        $ultimateIndex = intval(ceil($numberOfNews/$numberOfNewsPerPage));
        if($localId>$ultimateIndex){
            $localId=$ultimateIndex;
        }

        $this->view->render("The list of news",  [
            'pagination'=>$paginationMaker->makePagination($localId, $numberOfNews, $numberOfNewsPerPage),
            'parameters'=>$this->model->getNewsForPage($localId, $numberOfNews, $numberOfNewsPerPage)
        ]);
    }

    public function editOneNewsAction(){
        $id = $this->getIdForAnEdition($_SERVER['REQUEST_URI']);
        $rowOfNews = $this->model->getNewsWithId($id);
        $this->view->render("Edit news with id=".$id, $rowOfNews);
    }

    public function deleteNewsAction(){
        $id = $this->getIdForAnEdition($_SERVER['REQUEST_URI']);
        $index = $_POST['index'];
        $this->model->deleteOneNews($id);
        header('Location: /admin/news/index/'.$index);
    }

    public function processContent($contentWithOldDate){
        $patternToCheckImg = '';
    }


    //fetch
    public function saveNewsAction(){
        $id = $_POST['news_id'];
        $date = $_POST['news_date'];
        $heading = $_POST['news_heading'];
        $content = $_POST['news_content'];

        $allFileNames=null;
        $nameOfCoverImg=null;
        $files= null;
        if(isset($_POST['news_filenames'])){
            $allFileNames = json_decode($_POST['news_filenames']);
            $nameOfCoverImg= $_POST['news_images_cover'];
            if(isset($_FILES) && sizeof($_FILES)>0){
                $files=$_FILES;
            }
        }

        if($id==='new'){
                $newId='';
                if(isset($_FILES)){
                    $newId = $this->model->addOneNews($date, $heading, $content, $_FILES, $nameOfCoverImg);
                }else{
                    $newId = $this->model->addOneNews($date, $heading, $content);
                }
                echo json_encode(['id'=>$newId]);
            exit();
        }

        echo json_encode($this->model->updateOneNews($id, $date, $heading, $content, $allFileNames,$nameOfCoverImg, $files));
//        echo json_encode($_FILES);
}



//TODO clean folder if it was is not applied anymore
//TODO process the error

    //fetch
    public function getOneNewsPicturesAction(){
        $_POST=json_decode(file_get_contents("php://input"), true);
        $id = $_POST['id'];
        $rowOfImages=$this->model->getImagesViaNewsId($id);
        if(sizeof($rowOfImages)>0) {
            echo json_encode($rowOfImages);
        }else{
            echo json_encode(['empty'=>true]);
        }
    }

    public static function getIdForAnEdition($uri){
        return basename($uri, "?");
    }
}