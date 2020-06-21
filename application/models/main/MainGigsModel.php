<?php
namespace application\models\main;
use application\main\Model;

class MainGigsModel extends Model{

    public function getGigs(){
        $result = $this->db->makeQuery("SELECT * FROM gigs");
        return $result;
    }

    public function getGigsYears(){
        $listOfYears=$this->db->makeQuery("SELECT YEAR(gigs_date) as year FROM gigs GROUP BY year ORDER BY YEAR(gigs_date) DESC");
        return $listOfYears;
    }

    public function getGigsForYear($year){
        $listOfGigs=$this->db->makeQuery("SELECT * FROM gigs WHERE YEAR(gigs_date)=:year GROUP BY gigs_date",
            ['year'=>$year]
            );
        return $listOfGigs;
    }

}