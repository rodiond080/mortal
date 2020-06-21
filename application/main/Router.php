<?php

namespace application\main;
use application\main\View;
use application\libs\Utils;

class Router{

    protected $routes = [];
    protected $parameters = [];
    protected $temp = array();

    public function __construct() {
        $arr = require 'application/config/routes.php';
        foreach ($arr as $key => $val) {
            $this->add($key, $val);
        }
    }

    public function add($route, $params){
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route); //{id:\d+}'(?P<\1>\2)'
        $route = '#^'.$route.'$#'; //"#^news/index/(?P\d+)$#"
        $this->routes[$route] = $params;
        //TODO parse "?P" , "<\1>",
        //http://www.php.su/articles/?cat=regexp&page=008
        //http://www.php.su/articles/?cat=regexp&page=006
        //https://uvsoftium.ru/php/regexp.php
        //http://archive-ipq-co.narod.ru/l1/regexp.html
    }

    //TODO basename(); dirname(); strrpos(); wtf; page 378 example 3 protect html from symbols; solid macros;

    private function matches() {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        $url = trim($url, '?');
//        debug($url);
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {

//                debug($route);
//                foreach ($matches as $key => $match) {
//                    if (is_string($key)) {
//                        if (is_numeric($match)) {
//                            $match = (int) $match;
//                        }
//                        $params[$key] = $match;
//                    }
//                }
                $this->parameters = $params;
                return true;
            }
        } 
        return false;
    }


    public function run(){
        if($this->matches()){
            //get the special Controller (e.g. MainController) class
            $pathToController = 'application\controllers\\'
                .Utils::subRoute($this->parameters['controller']).'\\'
                .ucfirst($this->parameters['controller']).'Controller';
            if (class_exists($pathToController)){
                //get the relevant method (e.g. indexAction)
                $action = $this->parameters['action'].'Action';
                if (method_exists($pathToController, $action)){
                    //create controller instance of class and launch the method
                    $controller = new $pathToController($this->parameters);
                    $controller->$action();
                }else{
                    echo "fail. There is no such action";
                }
            }else{
                echo "fail. There is no such controller";
            }
        }else{
            echo "fail. There is no such route";
        }
    }


}