<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="v<?php session_start() ?>iewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar borrado</title>
</head>
<body>
    <?php
    require 'auxiliar.php';

    $id = obtener_get('id');

    if (!isset($id)) {
        return volver_principal();
    }

    cabecera();
    ?>
    <p>¿Está seguro de que desea borrar ese departamento?</p>
    <form action="borrar.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <?php token_csrf() ?>
        <button type="submit">Sí</button>
        <a href="index.php">No</a>
    </form>
</body>
</html>
