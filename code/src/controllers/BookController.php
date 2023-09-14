<?php

namespace Stream\Testtask\Controllers;

use Stream\Testtask\Connector;
use Stream\Testtask\models\Book;
use Stream\Testtask\models\Author;

class BookController
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
        $books= Book::findAll($this->connection);
        $authors = Author::findAll($this->connection);

        $this->render("index", array(
            'books' => $books,
            'authors' => $authors,
        ));
    }

    public function actionCreate()
    {
        if (isset($_POST["isbn"]) && isset($_POST["title"]) && isset($_POST["year"]) && isset($_POST["author_id"])) {
            $book = new Book($this->connection);
            $book->setTitle($_POST["title"]);
            $book->setIsbn($_POST["isbn"]);
            $book->setYear($_POST["year"]);
            $book->setAuthors($_POST["author_id"]);
            $book->save();
        }
        header('Location: index.php?controller=books');
    }

    public function actionUpdate()
    {
        if (isset($_GET['id']) and !isset($_POST['id'])) {
            $book = Book::findOne($this->connection, $_GET['id']);
            $authors = Author::findAll($this->connection);

//            $book->authors = $book->getAuthors();
            $this->render("update", array(
                'book' => $book,
                'authors' => $authors,
            ));
        }
        else if (isset($_POST["id"]) && isset($_POST["isbn"]) && isset($_POST["title"]) && isset($_POST["year"]) && isset($_POST["author_id"])) {
            $book = Book::findOne($this->connection, (int) $_POST['id']);
            $book->setTitle($_POST["title"]);
            $book->setIsbn($_POST["isbn"]);
            $book->setYear($_POST["year"]);
            $book->setAuthors($_POST["author_id"]);
            $book->update();

            header('Location: index.php?controller=books&action=update&id=' . $book->getId());
        }

    }

    public function actionDelete()
    {
        if (isset($_GET['id'])) {
            $book = Book::findOne($this->connection, $_GET['id']);
            $book->delete();
            header('Location: index.php?controller=books');
        }

    }

    public function render($view,$data)
    {
        $this->data = $data;
        require_once  __DIR__ . "/../views/book/" . $view . ".php";
    }

}