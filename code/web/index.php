<?php
require_once '../vendor/autoload.php';

use Stream\Testtask\controllers\AuthorController;
use Stream\Testtask\controllers\BookController;

if (isset($_GET["controller"])) {
    $controller=getController($_GET["controller"]);
    launchAction($controller);
}
else {
    echo 'Страница не найдена';
}

function getController($controller){
    switch ($controller) {
        case 'books':
            $controllerObj=new BookController();
            break;
        case 'authors':
            $controllerObj=new AuthorController();
            break;
    }
    return $controllerObj;
}

function launchAction($controller)
{
    if (isset($_GET["action"])){
        $controller->run($_GET["action"]);
    }
    else{
        $controller->run('index');
    }
}
/*
function cargarControlador($controller){
	// We create the Name of the controller: e.j. userController
    $controlador=ucwords($controller).'Controller';
    // We create the Name of the controller file: e.j. controller / userController.php
    $strFileController='controller/'.$controlador.'.php';
    //If there is no controller with that, we load the one defined by default.
    if(!is_file($strFileController)){
        $strFileController='controller/'.ucwords(CONTROLLER_DEFECTO).'Controller.php';
    }
    //We load the file where the controller is defined:
    require_once $strFileController;
    //We create the object
    $controllerObj=new $controlador();
    return $controllerObj;
}
*/
?>