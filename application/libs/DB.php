<?php
namespace application\libs;
use PDO;

class DB{

    protected $pdo;

    public function __construct(){
        $dbConfig = require 'application/config/db.php';
        $this->pdo=new PDO('mysql:host='.$dbConfig['host'].';dbname='.$dbConfig['dbname'], ''.$dbConfig['user'], ''.$dbConfig['password']);
        if (!$this->pdo){
            die("Error connect to DataBase");
        }
    }

//    private function query($statement, $values){
//        $statement=$this->pdo->prepare($statement);
//        if(!empty($values)){
//            foreach ($values as $valueKey=>$value){
//                $statement->bindValue(":".$valueKey, $value);
//            }
//        }
//
//        $statement->execute();
//        return $statement;
//    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':'.$key, $val);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function column($sql, $params = []) {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }

    public function getPDO(){
        return $this->pdo;
    }

//    public function row($sql, $params = []) {
//        $result = $this->query($sql, $params);
//        return $result->fetchAll(PDO::FETCH_ASSOC);
//    }

    public function makeQuery($statement, $values=""){
        return $this->query($statement, $values)->fetchAll(PDO::FETCH_ASSOC);
    }

}