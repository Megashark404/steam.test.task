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
    <form action="index.php?controller=copies&action=update&id=<?php echo $this->data['copy']->getId();?>" method="post">
        <h3>Редактирование экземпляра "<?php echo $this->data['book']->getTitle(); ?>"</h3>
        <hr/>
        <input type="hidden" name="id" value="<?php echo $this->data["copy"]->getId() ?>"/>
        Инвентарный номер: <input type="text" required name="serial" value="<?php echo $this->data["copy"]->getSerial() ?>" class="form-control"/>
        Комментарий: <input type="text" name="comment" value="<?php echo $this->data['copy']->getComment() ?>" class="form-control"/>
        Статус <small>(измените статус, чтобы списать)</small>:
        <select name="active" required class="custom-select" id="inputGroupSelect01">
            <option <?php echo $this->data['copy']->isActive() ? 'selected' : ''?> value="1">В наличии</option>
            <option <?php echo $this->data['copy']->isActive() ? '' : 'selected'?> value="0">Списан</option>
        </select>
        <input type="submit" value="Сохранить" class="btn btn-success"/>
    </form>
    <div class="">
        <a href="index.php?controller=copies&book_id=<?php echo $this->data['book']->getId();?>" class="btn btn-info">Назад</a>
    </div>
</div>
</body>
</html>