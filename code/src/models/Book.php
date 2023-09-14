<?php

namespace Stream\Testtask\models;

use PDO;

class Book
{
    protected $id;
    protected $isbn;
    protected $title;
    protected $year;
    public array $authors;

    private ?PDO $connection;

    const TABLE = 'books';
    const AUTHORS_CROSS_TABLE = 'books_authors';

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save()
    {
        $expr = $this->connection->prepare("
            INSERT INTO " . self::TABLE . " (isbn,title,year) 
            VALUES (:isbn,:title,:year)
        ");
        $result = $expr->execute(array(
            "isbn" => $this->isbn,
            "title" => $this->title,
            "year" => $this->year,
        ));
        $this->setId($this->connection->lastInsertId());
        $this->saveAuthors();
        $this->connection = null;

        return $result;
    }

    public function update(){

        $expr = $this->connection->prepare("
            UPDATE " . self::TABLE . " 
            SET 
                isbn = :isbn,
                title = :title, 
                year = :year
            WHERE id = :id 
        ");

        $result = $expr->execute(array(
            "id" => $this->id,
            "isbn" => $this->isbn,
            "title" => $this->title,
            "year" => $this->year,
        ));


        $this->saveAuthors();

        $this->connection = null;

        return $result;
    }


    public static function findAll(PDO $connection): array
    {
        $expr = $connection->prepare("SELECT * FROM " . self::TABLE);
        $expr->execute();
        $result = $expr->fetchAll();
        foreach ($result as $row) {
            $books[] = self::findOne($connection, $row['id']);
        }
        $connection = null;

        return $books;
    }


    public static function findOne(PDO $connection, int $id): self
    {
        $expr = $connection->prepare("SELECT * FROM " . self::TABLE . "  WHERE id = :id");
        $expr->execute(array(
            "id" => $id
        ));
        $data = $expr->fetch();

        $book = (new self($connection))
            ->setIsbn($data['isbn'])
            ->setId($data['id'])
            ->setTitle($data['title'])
            ->setYear($data['year']);

        $connection = null;
        return $book;
    }

    public function delete()
    {
        try {
            $expr = $this->connection->prepare("DELETE FROM " . self::TABLE . " WHERE id = :id");
            $expr->execute(array(
                "id" => $this->id
            ));
            $connection = null;
            return true;
        } catch (\Exception $e) {
            echo 'Failed DELETE : ' . $e->getMessage();
            return false;
        }
    }

    /*
     * getters
     */

    public function getId()
    {
        return $this->id;
    }

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getAuthors(): array
    {
        $expr = $this->connection->prepare("SELECT * FROM " . self::AUTHORS_CROSS_TABLE . " WHERE book_id=:id");
        $expr->execute(array(
            "id" => $this->id
        ));
        $result = $expr->fetchAll();
        foreach ($result as $row) {
            $authors[] = \Stream\Testtask\models\Author::findOne($this->connection, $row['author_id']);
        }
        $connection = null;

        return $authors;
    }

    public function getAuthorsNames()
    {
        $authors = $this->getAuthors();
        foreach ($authors as $author) {
            $authorsNames[] = $author->getName();
        }
        $connection = null;

        return implode(',', $authorsNames);
    }

    public function getYear()
    {
        return $this->year;
    }

    /*
     * setters
     */

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setAuthor($id)
    {
        $this->authorId = $id;
        return $this;
    }

    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }

    public function setAuthors(array $ids)
    {
        $this->authors = $ids;
        return $this;
    }

    public function saveAuthors()
    {
        $deleteExpr = $this->connection->prepare("DELETE FROM " . self::AUTHORS_CROSS_TABLE . " WHERE book_id = :id");
        $deleteExpr->execute(array(
            "id" => $this->id
        ));

        $expr = $this->connection->prepare("
            INSERT INTO " . self::AUTHORS_CROSS_TABLE . " (book_id,author_id) 
            VALUES (:book_id,:author_id)
        ");

        foreach ($this->authors as $authorId) {
            $result = $expr->execute(array(
                "book_id" => $this->id,
                "author_id" => $authorId
            ));
        }
    }
}
