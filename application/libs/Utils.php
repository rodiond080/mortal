<?php

namespace application\libs;

class Utils{
    public static function nameSpaceAutoload($class){
//        $path = str_replace('\\', '/',$class.'.php');
//        if (file_exists($path)){
//            require $path;
//        }
        echo "s";
    }

    public static function subRoute($controller){
        $controllerRoutes = ['admin', 'main'];
        foreach ($controllerRoutes as $index=>$controllerRoute){
            if (strpos($controller, $controllerRoute)!==false){
                return $controllerRoute;
            }
        }
        return 'main';
    }
}
