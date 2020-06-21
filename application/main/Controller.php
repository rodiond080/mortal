<?php
namespace application\main;
use application\main\View;
use application\libs\Utils;

abstract class Controller{

    public $routeParameters;
    public $view;
    public $model;
//    public $dataBaseModel;

    public function __construct($routeParameters){
        $this->routeParameters=$routeParameters;
        $this->view=new View($routeParameters);

        $pathToModel= 'application\models\\'.Utils::subRoute($routeParameters['controller']).'\\'.ucfirst($routeParameters['controller']).'Model';
        $this->model= new $pathToModel;

//        $pathToDataBaseModel = 'application\database_models\\'.ucfirst($routeParameters['controller']).'DataBaseModel';
//        $this->dataBaseModel=new $pathToDataBaseModel;
    }
}