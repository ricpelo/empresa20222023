<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar un nuevo departamento</title>
</head>
<body>
    <?php
    require 'auxiliar.php';

    $codigo = obtener_post('codigo');
    $denominacion = obtener_post('denominacion');

    if (isset($codigo, $denominacion)) {
        $pdo = conectar();
        $sent = $pdo->prepare("INSERT
                                 INTO departamentos (codigo, denominacion)
                               VALUES (:codigo, :denominacion)");
        $sent->execute([
            ':codigo' => $codigo,
            ':denominacion' => $denominacion,
        ]);
        return volver();
    }
    ?>
    <div>
        <form action="" method="post">
            <div>
                <label>
                    Código:
                    <input type="text" name="codigo" size="10"
                           value="<?= $codigo ?>">
                </label>
            </div>
            <div>
                <label>
                    Denominación:
                    <input type="text" name="denominacion"
                           value="<?= $denominacion ?>">
                </label>
            </div>
            <div>
                <button type="submit">Insertar</button>
                <a href="index.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
