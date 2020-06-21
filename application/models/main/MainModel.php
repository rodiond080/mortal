<?php
namespace application\models\main;
use application\main\Model;

class MainModel extends Model{

    public function getGigs(){
        $result = $this->db->makeQuery("SELECT * FROM gigs");
        return $result;
    }
}