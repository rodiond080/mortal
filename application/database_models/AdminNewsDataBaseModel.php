<?php
namespace application\database_models;
use application\main\DataBaseModel;
use application\libs\DB;

class AdminNewsDataBaseModel extends DataBaseModel{
    private $id;
    private $date;
    private $heading;
    private $description;
    private $images;
    private $delete;

    /**
     * OneNews constructor.
     * @param $id
     * @param $date
     * @param $heading
     * @param $description
     */

    public function __construct($id=NULL, $date=NULL, $heading=NULL, $description=NULL, $delete=false){
        $this->id = $id;
        $this->date = $date;
        $this->heading = $heading;
        $this->description = $description;
        $this->delete=$delete;
        $this->images=array();
    }

    public function find($id){
        $db = new DB();

        //text and date inputs
        $this->id=$id;
        $rowOfOneNews = $db->makeQuery("SELECT * FROM news WHERE news_id=:id", ["id"=>intval($id)]);
        if($rowOfOneNews){
            $this->date = $rowOfOneNews[0]['news_date'];
            $this->heading = $rowOfOneNews[0]['news_heading'];
            $this->description = $rowOfOneNews[0]['news_content'];
        }

        //images
        $arrayOfImages=$db->makeQuery('SELECT * FROM news_images WHERE news_id=:id', ["id"=>intval($id)]);
        for($i=0;$i<sizeof($arrayOfImages); $i++){
           $newImageObject = new AdminNewsImageDataBaseModel(
               $arrayOfImages[$i]['news_images_address'],
               $arrayOfImages[$i]['news_cover']
           );
            $this->images[$i]=$newImageObject;
        }
    }


    public function save(){
        switch ($this->id){
            case NULL:
                return $this->createNewOneNews();
            default:
                return $this->saveOneNews();
        }
    }

    public function  saveOneNews(){
        $db = new DB();
        $formerListOfImages = $db->makeQuery("SELECT * FROM news_images WHERE news_id=:news_id", ["news_id"=>intval($this->getId())]);
        $listOfImages = $this->formerDBImgIntoNames();
        foreach ($formerListOfImages as $fImage){
            if(!in_array($fImage['news_images_address'], $listOfImages)){
                $db->makeQuery("DELETE FROM news_images WHERE news_images_address=:news_images_address",
                    [
                        'news_images_address'=>$fImage['news_images_address']
                    ]
                );
            }
        }


        foreach ($this->getImages() as $imageObject){
            if(!in_array($imageObject->getNewsImageAddress(), $this->formerDBImgIntoNames())){
                $isCover = $imageObject->getIsCover()?1:0;
                $db->makeQuery("INSERT INTO news_images (news_id, news_images_address, news_cover)
                VALUES (:news_id,:news_images_address, :news_cover)",
                    [
                        'news_id'=>$this->getId(),
                        'news_images_address'=>$imageObject->getNewsImageAddress(),
                        'news_cover'=>$isCover
                    ]
                );
            }
        }

        $db->makeQuery("UPDATE news SET news_date=:news_date, news_heading=:news_heading, news_content=:news_content WHERE news_id=:news_id",
            [
                'news_id'=>$this->getId(),
                'news_date'=>$this->getDate(),
                'news_heading'=>$this->getHeading(),
                'news_content'=>$this->getDescription()
            ]
        );
    }

    public function formerDBImgIntoNames(){
        $db= new DB();
        $result=array();
        $formerListOfImages = $db->makeQuery("SELECT * FROM news_images WHERE news_id=:id", ["id"=>intval($this->id)]);
        $i=0;
        foreach ($formerListOfImages as $item){
            $result[$i]=$item;
                $i++;
        }
        return $result;
    }

    public function imgObjectsIntoNames(){
        $result = array();
        $i=0;
        foreach ($this->getImages() as $img){
            $result[$i]=$img->getNewsImageAddress();
            $i++;
        }
        return $result;
    }


    public function createNewOneNews(){
        $data = [
            'news_date'=>$this->date,
            'news_heading'=>$this->heading,
            'news_content'=>$this->description
        ];

        $db = new DB();
        $db->makeQuery("INSERT INTO news (news_date, news_heading, news_content)
            VALUES (:news_date, :news_heading, :news_content)", $data);
        $newId = $db->getPDO()->lastInsertId();

        for($i=0; $i<sizeof($this->getImages()); $i++){
            $isCover = ($this->getImages()[$i]->getIsCover())?1:0;
            $db->makeQuery("INSERT INTO news_images (news_id, news_images_address, news_cover)
            VALUES (:news_id, :news_images_address, :news_cover)",
            [
                'news_id'=>$newId,
                'news_images_address'=>$this->getImages()[$i]->getNewsImageAddress(),
                'news_cover'=>$isCover
            ]);
        }

        return $newId;
    }


    private function getImagesToDelete(){
        $db = new DB();
        $formerListOfImages = $db->makeQuery("SELECT * FROM news_images WHERE news_id=:id", ["id"=>intval($this->id)]);
        $arrayOfNewImages = array();
        $arrayOfOldImages = array();
        $arrayOfImagesToDelete=array();

        $counter = 0;
        foreach ($formerListOfImages as $key=>$val){
            $arrayOfOldImages[$counter]=$val;
            $counter++;
        }

        $counter2=0;
        foreach ($this->images as $key=>$val){
            $arrayOfNewImages[$counter2]=$val->getNewsImageAddress();
            $counter2++;
        }

        $counter3=0;
        foreach ($arrayOfOldImages as $key=>$val){
            if (in_array($val, $arrayOfNewImages)==false){
                $arrayOfImagesToDelete[$counter3]=$val;
            }
            $counter3++;
        }
        return $arrayOfImagesToDelete;


    }

    /**
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param array $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    private function setId($id){
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param null $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return null
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * @param null $heading
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isDelete(){
    return $this->delete;
    }

    public function delete(){
         $this->delete=true;
    }

}