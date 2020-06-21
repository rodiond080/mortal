<?php
namespace application\controllers\admin;
use application\main\Controller;

class AdminAudioController extends Controller{
    public function __construct($routeParameters){
        parent::__construct($routeParameters);
        $this->view->layout = 'admin_panel';
    }

   public function audioAlbumsAction(){
        $audioalbums = $this->model->getAllAudioAlbums();
        $this->view->render('Audioalbums', $audioalbums);
   }

   public function  createNewAudioAlbumAction(){
        $this->view->setPathToSpecificView("application/views/admin/editAudioAlbum.php");
        $this->view->render("New audioalbum");
   }

    public function getAudioAlbumAction(){
        $_POST = json_decode(file_get_contents("php://input"), true);
        $id = $_POST['id'];
        $audioAlbumName = $this->model->getNameViaId($id);
        $listOfImages = $this->model->getListOfFileNames($id);
        $poster=$this->model->getPosterViaId($id);
        echo json_encode([
            'audio_albums_name'=>$audioAlbumName,
            'images'=>$listOfImages,
            'audio_albums_poster'=>$poster
        ]);
    }

   public function editAudioAlbumAction(){
       $this->view->render("Edit audioalbum");
   }

    public function saveAudioAlbumAction(){
//        $_POST = json_decode(file_get_contents("php://input"), true);
        $id = $_POST['audioalbum_id'];
        $name = $_POST['audioalbum_name'];
        $allFileNames = json_decode($_POST['all_file_names']);

        $result=array();
        if($id==='new'){
            $result['exists']=$this->model->checkIfAlbumExists($name);
            if(!$result['exists']){
                $this->model->createNewAlbum($name);
                $id = $this->model->getIdViaName($name);
                $this->model->uploadFiles($id, $_FILES);
                $result['id']=$id;
            }
            echo json_encode($result);
            exit();
        }

        $result['exists']=$this->model->checkIfAlbumExistsWithoutAlbumWithId($name, $id);
        if(!$result['exists']){
            $result['id']=$id;
            $this->model->deleteFiles($id, $allFileNames);
            $this->model->uploadFiles($id, $_FILES);
           echo json_encode($this->model->saveAlbum($id,$name,$_POST, $_FILES));
        }
//
//        echo json_encode($_FILES);
//        echo json_encode($result);
    }
}