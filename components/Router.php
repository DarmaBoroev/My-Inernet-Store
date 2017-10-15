<?php

class Router {
    private $routes;
    
    public function __construct() {
        $routesPath= ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }
    /**
     * Return request string
     */
    private function getURI(){
        if(!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'], '/');
        } 
    }
    
    public function run(){
        //Получить строку запроса
        $uri = $this->getURI();
        
        // Проверить наличие такого запроса в request.php
        foreach ($this->routes as $uriPattern => $path){
            //Сравниваем $uriPattern and $uri
            if(preg_match("~$uriPattern~", $uri)){
                
                //получаем внутренний путь тз внешнего согласно правилу
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                

                //Определяем контроллер и метод, 
                //обрабатывающие запрос
                $segments = explode('/', $internalRoute);
                
                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);
                
                $actionName = 'action'.ucfirst(array_shift($segments));
                
                $parameters = $segments;
                
                
                //Подключаем файл класса-контроллера
                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';
             
                
                if(file_exists($controllerFile)){
                    include_once($controllerFile);
                }
                
                //Создаем объект и вызываем метод
                $controllerObject = new $controllerName;
                
                $result = call_user_func_array(array($controllerObject, $actionName),$parameters);
                if($result != Null){
                    break;
                }
            }
        }
    }
}
