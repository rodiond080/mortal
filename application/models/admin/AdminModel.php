<?php
namespace application\models;

use application\main\Model;


class AdminModel extends Model{

    public function thePasswordIsCorrect($login, $password){
        if($login=="123" && $password=="123"){
            return true;
        }
        return false;
    }

    public function getGigs(){
        $rowOfGigs = $this->db->makeQuery("SELECT * FROM gigs","");
        return $rowOfGigs;
    }

    public function getGigWithID($id){
        $rowOfGigs = $this->db->makeQuery("SELECT * FROM gigs WHERE gigs_id=:id",["id"=>intval($id)]);
        return $rowOfGigs;
    }

    public function getNews(){
        $rowOfNews = $this->db->makeQuery("SELECT * FROM news", "");
        return $rowOfNews;
    }

    public function getNewsWithId($id){
        $rowOfNews = $this->db->makeQuery("SELECT * FROM news WHERE news_id=:id", ["id"=>intval($id)]);
        return $rowOfNews;
    }


}
