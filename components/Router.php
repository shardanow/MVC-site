<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 14:58
 */

class Router {
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);

    }

    /**
     * Returns request string.
     * @return string
     */
    private function getURI()
    {
        if(!empty($_SERVER['REQUEST_URI']))
        {
            return trim(urldecode($_SERVER['REQUEST_URI']), '/');
        }
    }

    public function run()
    {
        // Получить строку запроса.
        $uri = $this->getURI();

        // Проверить наличие такого запроса в routes.php.
        foreach($this->routes as $uriPattern => $path)
        {

            // Сравниваем $uriPattern and $uri.
            if(preg_match_all("~$uriPattern~",$uri))
            {
                //echo $uriPattern.'<br>';
                //echo $uri.'<br>';
                //echo $path.'<br>';

                // Получаем внутренний путь из внешнего согласно правилу.
                $internalRoute = preg_replace("~$uriPattern~",$path,$uri);

                //echo $internalRoute.'<br>';

                // Определить какой контроллер и action обрабатывает запрос.
                $segments = explode('/', $internalRoute);


                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action'.ucfirst(array_shift($segments));

                $parameters = $segments;

                // Подключить файл класса-контроллера.
                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

                if(file_exists($controllerFile))
                {
                    include_once($controllerFile);
                }

                // Создать объект, вызвать метод (т.е. action).
                $controllerObject = new $controllerName;
                error_reporting(E_ERROR | E_PARSE);

                $result = call_user_func_array(array($controllerObject, $actionName),$parameters);

                if($result==false)
                {
                    require_once(ROOT.'/views/not_exist.php');
                    exit;
                }

                if($result!=null)
                {
                    break;
                }

            }
        }

        // Если есть совпадение, определить какой контроллер и action обрабатывает запрос.

        // Подключить файл класса-контроллера.

        // Создать обьект, вызвать метод (т.е. action)
    }

} 