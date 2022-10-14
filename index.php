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
    $desde_codigo = isset($_GET['desde_codigo']) ? trim($_GET['desde_codigo']) : null;
    $hasta_codigo = isset($_GET['hasta_codigo']) ? trim($_GET['hasta_codigo']) : null;
    $denominacion = isset($_GET['denominacion']) ? trim($_GET['denominacion']) : null;
    ?>
    <div>
        <form action="" method="get">
            <fieldset>
                <legend>Criterios de búsqueda</legend>
                <p>
                    <label>
                        Desde código:
                        <input type="text" name="desde_codigo" size="8" value="<?= $desde_codigo ?>">
                    </label>
                </p>
                <p>
                    <label>
                        Hasta código:
                        <input type="text" name="hasta_codigo" size="8" value="<?= $hasta_codigo ?>">
                    </label>
                </p>
                <p>
                    <label>
                        Denominación:
                        <input type="text" name="denominacion" value="<?= $denominacion ?>">
                    </label>
                </p>
                <button type="submit">Buscar</button>
            </fieldset>
        </form>
    </div>
    <?php
    $pdo = new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
    $pdo->beginTransaction();
    $pdo->exec('LOCK TABLE departamentos IN SHARE MODE');
    $where = [];
    $execute = [];
    if (isset($desde_codigo) && $desde_codigo != '') {
        $where[] = 'codigo >= :desde_codigo';
        $execute[':desde_codigo'] = $desde_codigo;
    }
    if (isset($hasta_codigo) && $hasta_codigo != '') {
        $where[] = 'codigo <= :hasta_codigo';
        $execute[':hasta_codigo'] = $hasta_codigo;
    }
    if (isset($denominacion) && $denominacion != '') {
        $where[] = 'lower(denominacion) LIKE lower(:denominacion)';
        $execute[':denominacion'] = "%$denominacion%";
    }
    $where = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
    $sent = $pdo->prepare("SELECT COUNT(*) FROM departamentos $where");
    $sent->execute($execute);
    $total = $sent->fetchColumn();
    $sent = $pdo->prepare("SELECT * FROM departamentos $where ORDER BY codigo");
    $sent->execute($execute);
    $pdo->commit();
    ?>
    <br>
    <div>
        <table style="margin: auto" border="1">
            <thead>
                <th>Código</th>
                <th>Denominación</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                <?php foreach ($sent as $fila): ?>
                    <tr>
                        <td><?= $fila['codigo'] ?></td>
                        <td><?= $fila['denominacion'] ?></td>
                        <td><a href="confirmar_borrado.php?id=<?= $fila['id'] ?>">Borrar</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <p>Número total de filas: <?= $total ?></p>
    </div>
</body>
</html>
