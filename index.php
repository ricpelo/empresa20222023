<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamentos</title>
</head>
<body>
    <?php
    $codigo = (isset($_GET['codigo'])) ? trim($_GET['codigo']) : null;
    ?>
    <div>
        <form action="" method="get">
            <label>
                Código:
                <input type="text" name="codigo" size="8" value="<?= $codigo ?>">
            </label>
            <button type="submit">Buscar</button>
        </form>
    </div>
    <?php
    $pdo = new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
    $pdo->beginTransaction();
    $sent = $pdo->query('LOCK TABLE departamentos IN SHARE MODE');
    $sent = $pdo->prepare('SELECT COUNT(*)
                             FROM departamentos
                            WHERE codigo = :codigo');
    $sent->execute([':codigo' => $codigo]);
    $total = $sent->fetchColumn();
    $sent = $pdo->prepare('SELECT *
                             FROM departamentos
                            WHERE codigo = :codigo
                         ORDER BY codigo');
    $sent->execute([':codigo' => $codigo]);
    $pdo->commit();
    ?>
    <div>
        <table style="margin: auto" border="1">
            <thead>
                <th>Código</th>
                <th>Denominación</th>
            </thead>
            <tbody>
                <?php foreach ($sent as $fila): ?>
                    <tr>
                        <td><?= $fila['codigo'] ?></td>
                        <td><?= $fila['denominacion'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <p>Número total de filas: <?= $total ?></p>
    </div>
</body>
</html>
