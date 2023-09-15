<?php

namespace Stream\Testtask\models;

use PDO;

class Copy
{
    protected $id;
    protected $serial;
    protected $bookId;
    protected $active;
    protected $comment;
    protected $borrowStatus;

    private ?PDO $connection;

    const TABLE = 'book_copies';
    const READERS_CROSS_TABLE = 'book_copies_readers';
    const STATUS_STOCK = 0;    // в наличии в библиотеке
    const STATUS_BORROWED = 1; // выдан читателю
    const DISPOSED = 0; // списан
    const ACTIVE = 1; // не списан

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save()
    {
        $expr = $this->connection->prepare("
            INSERT INTO " . self::TABLE . " (serial,active,comment,borrow_status,book_id) 
            VALUES (:serial,:active,:comment,:borrow_status,:book_id)
        ");
        $result = $expr->execute(array(
            'serial' => $this->serial,
            'active' => $this->active,
            'comment' => $this->comment,
            'borrow_status' => $this->borrowStatus,
            'book_id' => $this->bookId,
        ));
        $this->connection = null;

        return $result;
    }

    public function update(){

        $expr = $this->connection->prepare("
            UPDATE " . self::TABLE . " 
            SET 
                serial = :serial,
                active = :active, 
                comment = :comment,
                borrow_status = :borrow_status
            WHERE id = :id 
        ");

        $result = $expr->execute(array(
            "id" => $this->id,
            "serial" => $this->serial,
            "active" => $this->active,
            "comment" => $this->comment,
            'borrow_status' => $this->borrowStatus
        ));

        $this->connection = null;

        return $result;
    }


    public static function findByBook(PDO $connection, int $bookId): array
    {
        $copies = [];
        $expr = $connection->prepare("SELECT * FROM " . self::TABLE . " WHERE book_id = :book_id");
        $expr->execute(array(
            "book_id" => $bookId
        ));
        $result = $expr->fetchAll();
        foreach ($result as $row) {
            $copies[] = self::findOne($connection, $row['id']);
        }
        $connection = null;

        return $copies;
    }


    public static function findOne(PDO $connection, int $id): self
    {
        $expr = $connection->prepare("SELECT * FROM " . self::TABLE . "  WHERE id = :id");
        $expr->execute(array(
            "id" => $id
        ));
        $data = $expr->fetch();

        $copy = (new self($connection))
            ->setSerial($data['serial'])
            ->setId($data['id'])
            ->setBookId($data['book_id'])
            ->setComment($data['comment'])
            ->setActive($data['active'])
            ->setBorrowStatus($data['borrow_status']);

        $connection = null;
        return $copy;
    }

    public function borrowTo(Reader $reader, string $dueDate)
    {
        $expr = $this->connection->prepare("
            INSERT INTO " . self::READERS_CROSS_TABLE . " (book_copy_id,reader_id, due_date) 
            VALUES (:book_copy_id,:reader_id, :due_date)
        ");

        $result = $expr->execute(array(
            "book_copy_id" => $this->id,
            "reader_id" => $reader->getId(),
            'due_date' => $dueDate,
        ));

        $this->setBorrowStatus(self::STATUS_BORROWED);
        $this->update();
    }


//    public function dispose()
//    {
//        try {
//            $expr = $this->connection->prepare("DELETE FROM " . self::TABLE . " WHERE id = :id");
//            $expr->execute(array(
//                "id" => $this->id
//            ));
//            $connection = null;
//            return true;
//        } catch (\Exception $e) {
//            echo 'Failed DELETE : ' . $e->getMessage();
//            return false;
//        }
//    }

    /*
     * getters
     */

    public function getId()
    {
        return $this->id;
    }

    public function getBookId()
    {
        return $this->bookId;
    }

    public function getSerial()
    {
        return $this->serial;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function isBorrowed()
    {
        return $this->borrowStatus;
    }
    /*
     * setters
     */

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function setBookId($bookId)
    {
        $this->bookId = $bookId;
        return $this;
    }

    public function setSerial($serial)
    {
        $this->serial = $serial;
        return $this;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    public function setBorrowStatus($status)
    {
        $this->borrowStatus = $status;
        return $this;
    }
}
