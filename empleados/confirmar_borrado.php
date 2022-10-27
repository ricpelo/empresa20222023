<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar borrado</title>
</head>
<body>
    <?php
    require 'auxiliar.php';

    $id = obtener_get('id');

    if (!isset($id)) {
        return volver();
    }

    cabecera();
    ?>
    <p>¿Está seguro de que desea borrar ese empleado?</p>
    <form action="borrar.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <button type="submit">Sí</button>
        <a href="index.php">No</a>
    </form>
</body>
</html>
