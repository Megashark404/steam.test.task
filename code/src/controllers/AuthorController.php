<?php

namespace Stream\Testtask\Controllers;

use Stream\Testtask\Connector;
use Stream\Testtask\models\Book;
use Stream\Testtask\models\Author;

class AuthorController
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
            $author = new Author($this->connection);
            $author->setName($_POST["name"]);
            $author->save();
            header('Location: index.php?controller=books');
        }
        $this->render("create", array());
    }


    public function render($view,$data)
    {
        $this->data = $data;
        require_once  __DIR__ . "/../views/author/" . $view . ".php";
    }

}