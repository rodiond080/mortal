<?php
namespace application\models\admin;
use application\database_models\AdminNewsImageDataBaseModel;
use application\libs\DB;
use application\main\Model;
use application\database_models\AdminNewsDataBaseModel;
use PDO;


class AdminNewsModel extends Model{

    public function thePasswordIsCorrect($login, $password){
        if ($login == "123" && $password == "123") {
            return true;
        }
        return false;
    }

    public function getNewsForPage($localId, $numberOfNews, $numberOfNewsPerPage){
        $pdo = new PDO('mysql:host=localhost;dbname=mortaldb', 'mvctest', 'mvctest');
        $st=$pdo->prepare("SELECT * FROM news ORDER BY news_date DESC LIMIT :start, :step");
        $st->bindValue(':start', ($localId-1)*$numberOfNewsPerPage, PDO::PARAM_INT);
        $st->bindValue(':step', $numberOfNewsPerPage, PDO::PARAM_INT);
        $st->execute();
        $result=$st->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function addOneNews($date, $heading, $content, $files=NULL, $cover=NULL){
        $oneNews = new AdminNewsDataBaseModel();
        $oneNews->setDate($date);
        $oneNews->setHeading($heading);
        $oneNews->setImages($this->getArrayOfImagesAndUpload($date, $files, $cover));
        $newContent = $this->getNewContent($content);
        $oneNews->setDescription($newContent);
        $id = $oneNews->save();

        $dirNew = 'public/images/news/news'.substr($date, 0, 10).'id'.$id;
        $dirOld = 'public/images/news/news'.substr($date, 0, 10);

        rename($dirOld, $dirNew);
        return $id;
    }

    public function getDateViaId($id){
        return $this->db->makeQuery("SELECT news_date FROM news WHERE news_id=:news_id",
            [
                'news_id'=>$id
            ]
        )[0]['news_date'];
    }

    public function getNewContent($content){
        return $content;//TODO make this method
    }

    public function getArrayOfImagesAndUpload($date,$files, $cover){
        $dir = 'public/images/news/news'.substr($date, 0, 10);
        if(!is_dir($dir)){
            mkdir($dir);
        }

        $arrayOfImages = array();
        for($i=0; $i<sizeof($files); $i++){
            $name = $files['news_image'.$i]['name'];
            $isCover = ($name==$cover);
            $newImgName = substr(strval(time()), 6, 4).$name;
            $arrayOfImages[$i]=new AdminNewsImageDataBaseModel($newImgName, $isCover);
            move_uploaded_file($files['news_image'.$i]['tmp_name'], $dir.'/'.$newImgName);
        }
        return $arrayOfImages;
    }

    public function getLastInsertedId(){
        return $this->db->getPDO()->lastInsertId();
    }

    public function getNews(){
        $rowOfNews = $this->db->makeQuery("LAST_INSERT_ID()", "");
        return $rowOfNews;
    }

    public function getNewsWithId($id){
        $oneNewsDBObject = new AdminNewsDataBaseModel();
        $oneNewsDBObject->find($id);
        $arrayWithDataForOneNewsView = [
            'news_id' => $oneNewsDBObject->getId(),
            'news_date' => $oneNewsDBObject->getDate(),
            'news_heading' => $oneNewsDBObject->getHeading(),
            'news_content' => $oneNewsDBObject->getDescription()
        ];
        return $arrayWithDataForOneNewsView;
    }

    public function getImagesViaNewsId($id){
        $oneNewsDBObject = new AdminNewsDataBaseModel();
        $oneNewsDBObject->find($id);
        $rowOfImagesWithNewsImageObjects = $oneNewsDBObject->getImages();

        $result = array();
        foreach ($rowOfImagesWithNewsImageObjects as $item){
            array_push($result, [
                'news_cover'=>$item->getIsCover(),
                'news_images_address'=>$item->getNewsImageAddress()
            ]);
        }
        return $result;
    }

    public function deleteOneNews($id){
        $oneNewsObject = new AdminNewsDataBaseModel();
        $oneNewsObject->find($id);
        $oneNewsObject->delete();
        $oneNewsObject->save();
    }

    public function countNumberOfNews(){
        return $this->db->makeQuery('SELECT COUNT(*) AS number_of_news FROM news')[0]['number_of_news'];
    }

    public function updateOneNews($id, $date, $heading, $description, $listOfAllFiles, $cover=NULL, $files=NULL){
        if ($listOfAllFiles == null) {
            return $this->updateWithoutFiles($id, $date, $heading, $description);
        } elseif ($listOfAllFiles && !isset($files)) {
            return $this->updateWithoutNewFiles($id, $date, $heading, $description, $listOfAllFiles, $cover);
        } elseif (isset($files)) {
            return $this->updateWithNewFiles($id, $date, $heading, $description, $listOfAllFiles, $cover, $files);
        }
    }


    public function updateWithoutFiles($id, $date, $heading, $description){
        $oneNews = new AdminNewsDataBaseModel();
        $oneNews->find($id);
        $formerDate = $oneNews->getDate();
        $dir = 'public/images/news/news'.substr($formerDate, 0, 10).'id'.$id;
        $oneNews->setDate($date);
        $oneNews->setHeading($heading);
        $oneNews->setDescription($description);
        $oneNews->setImages(array());

        if(is_dir($dir)) {
            $listOfFiles = scandir($dir);
            foreach ($listOfFiles as $file) {
                if($file!='.' && $file!='.:') {
                    unlink($dir . '/' . $file);
                }
            }
            rmdir($dir);
        }
        return $oneNews->save();
    }

    public function updateWithoutNewFiles($id, $date, $heading, $description, $listOfAllFiles, $cover){
        $oneNews = new AdminNewsDataBaseModel();
        $oneNews->find($id);
        $formerDate = $oneNews->getDate();
        $dir = 'public/images/news/news'.substr($formerDate, 0, 10).'id'.$id;
        $oneNews->setDate($date);
        $oneNews->setHeading($heading);
        $oneNews->setDescription($description);

        $arrayOfFiles=array();
        for($i=0; $i<sizeof($listOfAllFiles); $i++){
            $name=$listOfAllFiles[$i];
            $isCover = ($name==$cover);
            if(!in_array($name, $this->formerDBImgIntoNames($id))){
                unlink($dir.'/'.$name);
            }
            $arrayOfFiles[$i]=new AdminNewsImageDataBaseModel($name, $isCover);
        }

        for($i=0; $i<sizeof($this->formerDBImgIntoNames($id)); $i++){
            if(!in_array($this->formerDBImgIntoNames($id)[$i], $listOfAllFiles)){
                unlink($dir.'/'.$this->formerDBImgIntoNames($id)[$i]);
            }
        }

        $oneNews->setImages($arrayOfFiles);
        return $oneNews->save();
    }

    public function updateWithNewFiles($id, $date, $heading, $description, $listOfAllFiles, $cover, $files){
        $oneNews = new AdminNewsDataBaseModel();
        $oneNews->find($id);
        $formerDate = $oneNews->getDate();
        $oneNews->setDate($date);
        $oneNews->setHeading($heading);
        $oneNews->setDescription($description);
        $dir = 'public/images/news/news' . substr($formerDate, 0, 10) . 'id' . $id;
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $arrayOfImgObjects = array();
        $fileCounter=0;
        for ($i = 0; $i < sizeof($listOfAllFiles); $i++) {
            $name = $listOfAllFiles[$i];
            $isCover = ($name == $cover);



            if (in_array($name, $this->filesIntoNames($files))) {
                $newName = substr(strval(time()), 7, 3) . $name;
                move_uploaded_file($files['news_image'.$fileCounter]['tmp_name'], $dir . '/' . $newName);
                $arrayOfImgObjects[$i] = new AdminNewsImageDataBaseModel($newName, $isCover);
                $fileCounter++;
            } else {
                $arrayOfImgObjects[$i] = new AdminNewsImageDataBaseModel($name, $isCover);
            }
        }

        for($i=0; $i<sizeof($this->formerDBImgIntoNames($id)); $i++){
            if(!in_array($this->formerDBImgIntoNames($id)[$i], $listOfAllFiles)){
                unlink($dir.'/'.$this->formerDBImgIntoNames($id)[$i]);
            }
        }

            $oneNews->setImages($arrayOfImgObjects);
            return $oneNews->save();
    }

    public function formerDBImgIntoNames($id){
        $result=array();
        $formerListOfImages = $this->db->makeQuery("SELECT * FROM news_images WHERE news_id=:id", ["id"=>$id]);
        foreach ($formerListOfImages as $item){
            array_push($result, $item['news_images_address']);
        }
        return $result;
    }

    public function filesIntoNames($files){
        $result=array();
        for($i=0;$i<sizeof($files); $i++){
            $result[$i]=$files['news_image'.$i]['name'];
        }
        return $result;
    }
}


//TODO rename folder
///  //TODO process the error
        //TODO trigger to delete pictures
