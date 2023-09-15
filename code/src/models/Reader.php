<?php

namespace Stream\Testtask\models;

use PDO;

class Reader
{
    protected $id;
    protected $name;
    protected $card;
    protected $birthday;

    private ?PDO $connection;

    const TABLE = 'readers';
    const BOOKS_CROSS_TABLE = 'book_copies_readers';


    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save()
    {
        $expr = $this->connection->prepare("
            INSERT INTO " . self::TABLE . " (name, card) 
            VALUES (:name, :card)
        ");
        $result = $expr->execute(array(
            'name' => $this->name,
            'card' => $this->card,
        ));
        $this->connection = null;

        return $result;
    }

    public function update(){

        $expr = $this->connection->prepare("
            UPDATE " . self::TABLE . " 
            SET 
                name = :name,     
                card = :card           
            WHERE id = :id 
        ");

        $result = $expr->execute(array(
            'id' => $this->id,
            'name' => $this->name,
            'card' => $this->card,
        ));
        $this->connection = null;

        return $result;
    }


    public static function findAll(PDO $connection): array
    {
        $readers = [];
        $expr = $connection->prepare("SELECT * FROM " . self::TABLE);
        $expr->execute();
        $result = $expr->fetchAll();
        foreach ($result as $row) {
            $readers[] = self::findOne($connection, $row['id']);
        }
        $connection = null;

        return $readers;
    }


    public static function findOne(PDO $connection, int $id): self
    {
        $expr = $connection->prepare("SELECT * FROM " . self::TABLE . "  WHERE id = :id");
        $expr->execute(array(
            "id" => $id
        ));
        $data = $expr->fetch();

        $reader = (new self($connection))
            ->setName($data['name'])
            ->setCard($data['card'])
            ->setId($data['id']);

        $connection = null;
        return $reader;
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

    public function getName()
    {
        return $this->name;
    }

    public function getCard()
    {
        return $this->card;
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

    public function setCard($card)
    {
        $this->card = $card;
        return $this;
    }
}
