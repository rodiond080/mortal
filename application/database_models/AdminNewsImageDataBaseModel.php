<?php
namespace application\database_models;

class AdminNewsImageDataBaseModel{
    private $newsImageAddress;
    private $isCover;

    /**
     * AdminNewsImageDataBaseModel constructor.
     * @param $newsId
     * @param $newsImageAddress
     */
    public function __construct($newsImageAddress=NULL, $isCover=NULL){
        $this->newsImageAddress = $newsImageAddress;
        $this->isCover=$isCover;
    }

    /**
     * @return null
     */
    public function getNewsImageAddress()
    {
        return $this->newsImageAddress;
    }

    /**
     * @param null $newsImageAddress
     */
    public function setNewsImageAddress($newsImageAddress)
    {
        $this->newsImageAddress = $newsImageAddress;
    }

    /**
     * @return null
     */
    public function getIsCover(){
        return $this->isCover;
    }

    /**
     * @param null $isCover
     */
    public function setIsCover($isCover): void{
        $this->isCover = $isCover;
    }

}