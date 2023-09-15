<?php

namespace Stream\Testtask\models;

use PDO;

class Author
{
    protected $id;
    protected $name;

    private ?PDO $connection;

    const TABLE = 'authors';
    const BOOKS_CROSS_TABLE = 'books_authors';


    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save()
    {
        $expr = $this->connection->prepare("
            INSERT INTO " . self::TABLE . " (name) 
            VALUES (:name)
        ");
        $result = $expr->execute(array(
            "name" => $this->name,
        ));
        $this->connection = null;

        return $result;
    }

    public function update(){

        $expr = $this->connection->prepare("
            UPDATE " . self::TABLE . " 
            SET 
                name = :name,                
            WHERE id = :id 
        ");

        $result = $expr->execute(array(
            "id" => $this->id,
            "name" => $this->name,
        ));
        $this->connection = null;

        return $result;
    }


    public static function findAll(PDO $connection): array
    {
        $authors = [];
        $expr = $connection->prepare("SELECT * FROM " . self::TABLE);
        $expr->execute();
        $result = $expr->fetchAll();
        foreach ($result as $row) {
            $authors[] = self::findOne($connection, $row['id']);
        }
        $connection = null;

        return $authors;
    }


    public static function findOne(PDO $connection, int $id): self
    {
        $expr = $connection->prepare("SELECT * FROM " . self::TABLE . "  WHERE id = :id");
        $expr->execute(array(
            "id" => $id
        ));
        $data = $expr->fetch();

        $author = (new self($connection))
            ->setName($data['name'])
            ->setId($data['id']);

        $connection = null;
        return $author;
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

    public function hasWrite(Book $book): bool
    {
        $expr = $this->connection->prepare("SELECT * FROM " . self::BOOKS_CROSS_TABLE . "  WHERE author_id = :author_id AND book_id = :book_id");
        $expr->execute(array(
            'author_id' => $this->getId(),
            'book_id' => $book->getId(),
        ));
        $data = $expr->fetch();

        if ($data === false) {
            return false;
        }
        return true;
    }


    /*
     * getters
     */

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }


    /*
     * setters
     */

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
