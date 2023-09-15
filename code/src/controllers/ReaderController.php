<?php

namespace Stream\Testtask\Controllers;

use Stream\Testtask\Connector;
use Stream\Testtask\models\Reader;

class ReaderController
{
    private $connector;
    private $connection;
    private $data;

    public function __construct()
    {
        $this->connector = new Connector();
        $this->connection = $this->connector->connection();
    }

    public function run($action){
        switch($action)
        {
            case "create" :
                $this->actionCreate();
                break;
        }
    }

    public function actionCreate()
    {

        if (isset($_POST["name"])) {
            $reader = new Reader($this->connection);
            $reader->setName($_POST["name"]);
            $reader->setCard($_POST["card"]);
            $reader->save();


            header('Location: index.php?controller=books');
        }
        $this->render("create", array());
    }


    public function render($view,$data)
    {
        $this->data = $data;
        require_once  __DIR__ . "/../views/reader/" . $view . ".php";
    }

}