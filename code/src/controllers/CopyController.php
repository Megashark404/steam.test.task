<?php

namespace Stream\Testtask\Controllers;

use Stream\Testtask\Connector;
use Stream\Testtask\models\Book;
use Stream\Testtask\models\Copy;

class CopyController
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
            case "index" :
                $this->actionIndex();
                break;
            case "create" :
                $this->actionCreate();
                break;
            case "update" :
                $this->actionUpdate();
                break;
            case "delete" :
                $this->actionDelete();
                break;
            default:
                $this->actionIndex();
                break;
        }
    }

    public function actionIndex()
    {
        if (isset($_GET['book_id'])) {
            $book = Book::findOne($this->connection, $_GET['book_id']);
            $copies = Copy::findByBook($this->connection, $_GET['book_id']);
        }

        $this->render("index", array(
            'copies' => $copies,
            'book' => $book,
        ));
    }

    public function actionCreate()
    {
        if (isset($_POST["book_id"]) && isset($_POST["serial"])) {
            $copy = new Copy($this->connection);
            $copy->setSerial($_POST["serial"]);
            $copy->setBookId($_POST["book_id"]);
            $copy->setComment($_POST["comment"]);
            $copy->setActive(1);
            $copy->save();
            header('Location: index.php?controller=copies&book_id=' . $_POST["book_id"]);
        }
        $this->render("create", array());

    }

    public function actionUpdate()
    {
        if (isset($_GET['id']) and !isset($_POST['id'])) {
            $copy = Copy::findOne($this->connection, $_GET['id']);
            $book = Book::findOne($this->connection, $copy->getBookId());

            $this->render("update", array(
                'copy' => $copy,
                'book' => $book,
            ));
        }

        else if (isset($_POST["id"]) && isset($_POST["active"]) && isset($_POST["comment"])) {
            $copy = Copy::findOne($this->connection, $_POST['id']);
            $copy->setActive($_POST["active"]);
            $copy->setSerial($_POST["serial"]);
            $copy->setComment($_POST["comment"]);
            $copy->update();

            header('Location: index.php?controller=copies&action=update&id=' . $copy->getId());
        }
    }

     public function actionBorrow()
     {
         if (isset($_GET['id'])) {
             $copy = Copy::findOne($this->connection, $_GET['id']);
             $this->render("borrow", array(
                 'copy' => $copy,
             ));
         }
     }

    /*
     * Списание книги
     */
//    public function actionDispose()
//    {
//        if (isset($_GET['id'])) {
//            $copy = Copy::findOne($this->connection, $_GET['id']);
//            $copy->dispose();
//            header('Location: index.php?controller=copies');
//        }
//
//    }

    public function render($view,$data)
    {
        $this->data = $data;
        require_once  __DIR__ . "/../views/copy/" . $view . ".php";
    }

}