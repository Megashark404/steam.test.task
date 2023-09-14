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
    <form action="index.php?controller=books&action=update&id=<?php echo $this->data['book']->getId()?>" method="post">
        <h3>Редактирование книги</h3>
        <hr/>
        <input type="hidden" name="id" value="<?php echo $this->data["book"]->getId() ?>"/>
        Международный номер (ISBN): <input type="text" name="isbn" value="<?php echo $this->data["book"]->getIsbn() ?>" class="form-control"/>
        Наименование: <input type="text" name="title" value="<?php echo $this->data['book']->getTitle() ?>" class="form-control"/>
        Автор <small>(зажмите ctrl для выбора нескольких)</small>:
        <select name="author_id[]" multiple required class="custom-select" id="inputGroupSelect01">
            <?php foreach ($this->data['authors'] as $author) {?>
                <option <?php echo $author->hasWrite($this->data["book"]) ? 'selected' : ''?> value="<?php echo $author->getId(); ?>"><?php echo $author->getName()?></option>
            <?php }?>
        </select>
        Год издания: <input type="text" name="year" value="<?php echo $this->data['book']->getYear() ?>" class="form-control"/>
        <input type="submit" value="Сохранить" class="btn btn-success"/>
    </form>
    <div class="">
        <a href="index.php?controller=books" class="btn btn-info">Назад</a>
    </div>
</div>
</body>
</html>