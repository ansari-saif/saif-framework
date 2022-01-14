<?php

$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : '/';

$projectName = "/app";

if ($url == '/') {
    // This is the home page
    // Initiate the home controller
    // and render the home view

    require_once __DIR__ . $projectName . '/Controllers/IndexController.php';

    $indexController = new IndexController;
} else {

    // This is not home page
    // Initiate the appropriate controller
    // and render the required view

    //The first element should be a controller
    $requestedController = $url[0];

    // If a second part is added in the URI, 
    // it should be a method
    $requestedAction = isset($url[1]) ? $url[1] : '';

    // The remain parts are considered as 
    // arguments of the method
    $requestedParams = array_slice($url, 2);

    // Check if controller exists. NB: 
    // You have to do that for the model and the view too
    $ctrlPath = __DIR__ . $projectName . '/Controllers/' . ucfirst($requestedController) . 'Controller.php';

    if (file_exists($ctrlPath)) {

        require_once __DIR__ . $projectName . '/Controllers/' . ucfirst($requestedController) . 'Controller.php';

        $controllerName = ucfirst($requestedController) . 'Controller';

        // If there is a method - Second parameter
        if ($requestedAction != '') {
            (new $controllerName($requestedParams))->$requestedAction();
        } else {
            (new $controllerName($requestedParams))->index();
        }
    } else {

        header('HTTP/1.1 404 Not Found');
        die('404 - The file - ' . $ctrlPath . ' - not found');
        //require the 404 controller and initiate it
        //Display its view
    }
}