<!DOCTYPE HTML>
<html lang="es">

<head>
    <meta charset="utf-8"/>
    <title>Сервис библиотеки</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <style>
        input{
            margin-top:5px;
            margin-bottom:5px;
        }
        .right{
            float:right;
        }
    </style>
</head>
<body>
<div class="p-4">
<div class="row">
    <div class="col-8">
        <div class="">
            <h3>Книги</h3>
            <hr/>
        </div>
        <?php

        ?>
        <section class="pr-2" style="height:400px;overflow-y:scroll;">
            <?php foreach($this->data["books"] as $book) {?>
                <?php echo $book->getAuthorsNames(); ?>.
                <?php echo $book->getTitle(); ?>.
                <?php echo $book->getYear(); ?>.
                (ISBN: <?php echo $book->getIsbn(); ?>)
                <div class="right">
                    <a href="index.php?controller=books&action=borrow&id=<?php echo $book->getId(); ?>" class="btn btn-success">Выдать</a>
                    <a href="index.php?controller=books&action=update&id=<?php echo $book->getId(); ?>" class="btn btn-info">Редактировать</a>
                    <a href="index.php?controller=books&action=delete&id=<?php echo $book->getId(); ?>" class="btn btn-info">Удалить</a>
                </div>
                <hr/>
            <?php } ?>
        </section>
    </div>
    <div class="col-4">
        <form action="index.php?controller=books&action=create" method="post" class="col">
            <h3>Добавить книгу</h3>
            <hr/>
            Международный номер (ISBN): <input type="text" name="isbn" class="form-control" required/>
            Наименование: <input type="text" name="title" class="form-control" required/>
            Год издания: <input type="number" name="year" class="form-control" required/>
            Автор <small>(зажмите ctrl для выбора нескольких)</small>:
            <select name="author_id[]" multiple required class="custom-select" id="inputGroupSelect01">
                <!--                <option value="" selected> Выбрать...</option>-->
                <?php foreach ($this->data['authors'] as $author) {?>
                    <option value="<?php echo $author->getId(); ?>"><?php echo $author->getName(); ?></option>
                <?php }?>
            </select>
            <input type="submit" value="Добавить" class="btn btn-success"/>
            <a href="index.php?controller=authors&action=create" class="btn btn-info">Добавить автора</a>
        </form>
    </div>
</div>
</div>
</body>
</html>