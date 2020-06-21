<?php
namespace application\main;
use application\libs\DB;

abstract class DataBaseModel{

    protected $db;

    public function __construct(){
        $this->db=new DB;
    }
}