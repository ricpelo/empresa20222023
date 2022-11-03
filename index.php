<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresa</title>
</head>
<body>
    <?php
    require 'comunes/auxiliar.php';

    cabecera();
    ?>

    <form action="borrar_cookie.php">
        <button type="submit">Borrar cookie</button>
    </form>

    <?php pie() ?>
</body>
</html>
