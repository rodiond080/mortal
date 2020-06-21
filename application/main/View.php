<?php
namespace application\main;
use application\libs\Utils;

class View{

    public $pathToSpecificView;
    private $routeParameters;
    public $layout ='default';

    public function __construct($routeParameters){
        $this->routeParameters=$routeParameters;
//        $this->pathToSpecificView = 'application\views\\'.Utils::subRoute($routeParameters['controller']).'\\'.$routeParameters['action'].'.php';
        $this->pathToSpecificView = 'application/views/'.Utils::subRoute($routeParameters['controller']).'/'.$routeParameters['action'].'.php';
    }

    public function render($title, $parameters = []){
        //set the content from the specific view
        extract($parameters);
        ob_start();
        require $this->pathToSpecificView;

        $content = ob_get_contents();
        ob_end_clean();

        $pathToLayout = 'application/views/layouts/'.$this->layout.'.php';
//        $pathToLayout = 'application\views\layouts\\'.$this->layout.'.php';
        require $pathToLayout;
    }

    public static function errorCode($code){
        http_response_code($code);//TODO wtf?
        $path = 'application/views/errors/'.$code.'.php';
        if (file_exists($path)){
            require $path;
        }
        exit;
    }

    public function setPathToSpecificView($path){
        $this->pathToSpecificView=$path;
    }

}