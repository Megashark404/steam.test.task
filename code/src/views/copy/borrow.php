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
<div class="container-fluid col-lg-5 m-2">
    <form action="index.php?controller=copies&action=borrow&id=<?php echo $this->data['copy']->getId();?>" method="post">
        <h3>Выдать экземпляр "<?php echo $this->data['book']->getTitle(); ?>" читателю</h3>
        <hr/>
        <input type="hidden" name="id" value="<?php echo $this->data["copy"]->getId() ?>"/>
        Читатель:
        <select name="reader_id" required class="custom-select">
            <option value="">Выберите читателя</option>
            <?php foreach ($this->data['readers'] as $reader) {?>
                <option value="<?php echo $reader->getId(); ?>"><?php echo $reader->getName()?></option>
            <?php }?>
        </select>
        Дата возврата: <input type="date" name="due_date" required class="form-control"/>
        <input type="submit" value="Выдать читателю" class="btn btn-success"/>
        <a href="index.php?controller=readers&action=create" class="btn btn-info">Добавить читателя</a>

        <a href="index.php?controller=copies&book_id=<?php echo $this->data['book']->getId();?>" class="btn btn-info">Назад</a>
    </form>
    <div class="">

    </div>
</div>
</body>
</html>