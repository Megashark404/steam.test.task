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
    <div class="col-4">
        <form action="index.php?controller=readers&action=create" method="post" class="col">
            <h3>Добавить читателя</h3>
            <hr/>
            Фамилия, имя, отчество: <input type="text" name="name" class="form-control" required/>
            Читательский билет (номер): <input type="number" name="card" class="form-control" required/>
            <input type="submit" value="Добавить" class="btn btn-success"/>
            <a href="index.php?controller=readers&action=create" class="btn btn-info">Назад</a>
        </form>
    </div>
</div>
</div>
</body>
</html>