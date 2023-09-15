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
    <div class="mb-3">
        <a href="index.php?controller=books" class="btn btn-info">На главную</a>

    </div>
<div class="row">
    <div class="col-8">
        <div class="">
            <h3>Экземпляры книги "<?php echo $this->data['book']->getTitle(); ?>"    </h3>
            <hr/>
        </div>
        <?php

        ?>
        <section class="pr-2" style="height:400px;overflow-y:scroll;">
            <?php foreach($this->data["copies"] as $copy) {?>
                <b>Инвентарный номер:</b> <?php echo $copy->getSerial(); ?>.
                <b>Статус:</b> <?php echo $copy->isActive() ? 'На балансе' : 'Списан'; ?>.
                <b>Комментарий:</b> <?php echo $copy->getComment(); ?>.
                <div class="right">
                    <a href="index.php?controller=copies&action=borrow&id=<?php echo $copy->getId(); ?>" class="btn btn-success">Выдать читателю</a>
                    <a href="index.php?controller=copies&action=update&id=<?php echo $copy->getId(); ?>" class="btn btn-info">Редактировать</a>
                </div>
                <hr/>
            <?php } ?>
        </section>
    </div>
    <div class="col-4">
        <form action="index.php?controller=copies&action=create" method="post" class="col">
            <h3>Добавить экземпляр</h3>
            <hr/>
            Инвентарный номер: <input type="text" name="serial" class="form-control" required/>
            Комментарий: <input type="text" name="comment" class="form-control"/>
            <input type="hidden" name="book_id" value="<?php echo $this->data['book']->getId()?>"/>
            <input type="submit" value="Добавить" class="btn btn-success"/>
        </form>
    </div>
</div>
</div>
</body>
</html>