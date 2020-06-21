<?php
namespace application\controllers\admin;
use application\main\Controller;

class AdminPhotoController extends Controller{
    public function __construct($routeParameters){
        parent::__construct($routeParameters);
        $this->view->layout = 'admin_panel';
    }

    public function photoAlbumsAction(){
        $photoalbums = $this->model->getAllPhotoAlbums();
        $this->view->render("Photoalbums", $photoalbums);
    }

    public function createNewPhotoAlbumAction(){
        $this->view->setPathToSpecificView('application/views/admin/editPhotoAlbum.php');
        $this->view->render("New photoalbum");
    }

    public function editPhotoAlbumAction(){
        $this->view->render("Edit photoalbum");
    }

    public function savePhotoAlbumAction(){
        $id = $_POST['photoalbum_id'];
        $name = $_POST['photoalbum_name'];
        $nameOfCheckedRadio= $_POST['photoalbum_cover'];
        $allFileNames = json_decode($_POST['all_file_names']);

        $result=array();
        if($id==='new'){
            $result['exists']=$this->model->checkIfAlbumExists($name);
            if(!$result['exists']){
                $this->model->createNewAlbum($name);
                $id = $this->model->getIdViaName($name);
                $this->model->uploadFiles($id, $_FILES, $nameOfCheckedRadio);
                $result['id']=$id;
            }
            echo json_encode($result);
            exit();
        }

        $result['exists']=$this->model->checkIfAlbumExistsWithoutAlbumWithId($name, $id);
        if(!$result['exists']){
            $result['id']=$id;
            $this->model->deleteFiles($id, $allFileNames);
            $this->model->updateFiles($id, $nameOfCheckedRadio);
            $this->model->uploadFiles($id, $_FILES, $nameOfCheckedRadio);
        }

        echo json_encode($result);
    }

    public function getPhotoAlbumAction(){
        $_POST = json_decode(file_get_contents("php://input"), true);
        $id = $_POST['id'];
        $photoAlbumName = $this->model->getAlbumNameViaId($id);
        $listOfImages = $this->model->getListOfImages($id);
        echo json_encode([
            'photo_albums_name'=>$photoAlbumName,
            'images'=>$listOfImages
        ]);
    }

}