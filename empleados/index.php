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
    require 'auxiliar.php';

    const FMT_FECHA = 'Y-m-d H:i:s';
    ?>
    <!--
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
    -->
    <?php
    $pdo = conectar();
    $pdo->beginTransaction();
    $pdo->exec('LOCK TABLE empleados IN SHARE MODE');
    /*
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
    */
    $where = '';
    $execute = [];
    $sent = $pdo->prepare("SELECT COUNT(*)
                             FROM empleados e JOIN departamentos d
                               ON e.departamento_id = d.id
                           $where");
    $sent->execute($execute);
    $total = $sent->fetchColumn();
    $sent = $pdo->prepare("SELECT e.*, denominacion
                             FROM empleados e JOIN departamentos d
                               ON e.departamento_id = d.id
                           $where
                         ORDER BY numero");
    $sent->execute($execute);
    $pdo->commit();
    $nf = new NumberFormatter('es_ES', NumberFormatter::CURRENCY);
    // $df = new IntlDateFormatter(
    //     'es_ES',
    //     IntlDateFormatter::LONG,
    //     IntlDateFormatter::NONE,
    //     'Europe/Madrid'
    // );
    ?>
    <br>
    <div>
        <table style="margin: auto" border="1">
            <thead>
                <th>Número</th>
                <th>Nombre</th>
                <th>Salario</th>
                <th>Fecha de nac.</th>
                <th>Departamento</th>
                <th colspan="2">Acciones</th>
            </thead>
            <tbody>
                <?php foreach ($sent as $fila): ?>
                    <tr>
                        <td><?= $fila['numero'] ?></td>
                        <td><?= $fila['nombre'] ?></td>
                        <td><?= $nf->format($fila['salario']) ?></td>
                        <td><?= DateTime::createFromFormat(
                            FMT_FECHA,
                            $fila['fecha_nac'],
                            new DateTimeZone('Europe/Madrid')
                        )->format('d-m-Y') ?></td>
                        <td><?= $fila['denominacion'] ?></td>
                        <td><a href="confirmar_borrado.php?id=<?= $fila['id'] ?>">Borrar</a></td>
                        <td><a href="modificar.php?id=<?= $fila['id'] ?>">Modificar</a></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <p>Número total de filas: <?= $total ?></p>
        <a href="insertar.php">Insertar un nuevo empleado</a>
    </div>
</body>
</html>
