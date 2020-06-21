<?php
namespace application\models\main;
use application\main\Model;
use PDO;

class MainNewsModel extends Model{

    public function countNumberOfNews(){
        return $this->db->makeQuery('SELECT COUNT(*) AS number_of_news FROM news')[0]['number_of_news'];
    }



    public function getNewsForPage($localId, $numberOfNews, $numberOfNewsPerPage){
//        $result = $this->db->makeQuery('SELECT * FROM news ORDER BY news_date DESC LIMIT :start, :max',
//            [
//                'start'=>($localId-1)*$numberOfNewsPerPage,
//                'max'=>$numberOfNewsPerPage
//            ]);


        $pdo = new PDO('mysql:host=localhost;dbname=mortaldb', 'mvctest', 'mvctest');
        $st=$pdo->prepare("SELECT * FROM news ORDER BY news_date DESC LIMIT :start, :step");
        $st->bindValue(':start', ($localId-1)*$numberOfNewsPerPage, PDO::PARAM_INT);
        $st->bindValue(':step', $numberOfNewsPerPage, PDO::PARAM_INT);

        $st->execute();

        $result=$st->fetchAll(PDO::FETCH_ASSOC);
//        debug($st->fetchAll(PDO::FETCH_ASSOC));

        return $result;
    }



}