<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar un nuevo empleado</title>
    <style>
        .error {
            font-size: small;
            color: red;
        }

        .campo-error {
            color: red;
            border-color: red;
        }
    </style>
</head>
<body>
    <?php
    require 'auxiliar.php';

    const PAR = [
        'numero',
        'nombre',
        'salario',
        'fecha_nac',
        'departamento_id',
    ];

    $par = obtener_parametros(PAR, $_POST);
    extract($par);

    $pdo = conectar();
    $error = [];

    if (comprobar_parametros($par)) {
        validar_numero($numero, $error);
        validar_nombre($nombre, $error);
        validar_salario($salario, $error);
        validar_fecha_nac($fecha_nac, $error);
        validar_departamento_id($departamento_id, $error);
        if (!hay_errores($error)) {
            insertar_empleado($par, $pdo);
            return volver();
        }
    }

    $sent = $pdo->query("SELECT id, denominacion
                           FROM departamentos
                       ORDER BY denominacion");
    $departamentos = $sent->fetchAll();

    cabecera();
    ?>
    <div>
        <form action="" method="post">
            <div>
                <label <?= css_campo_error('numero', $error) ?>>
                    Número:
                    <input type="text" name="numero" size="10"
                    value="<?= $numero ?>"
                    <?= css_campo_error('numero', $error) ?>
                    >
                </label>
                <?php mostrar_errores('numero', $error) ?>
            </div>
            <div>
                <label <?= css_campo_error('nombre', $error) ?>>
                    Nombre:
                    <input type="text" name="nombre"
                    value="<?= $nombre ?>"
                    <?= css_campo_error('nombre', $error) ?>
                    >
                </label>
                <?php mostrar_errores('nombre', $error) ?>
            </div>
            <div>
                <label <?= css_campo_error('salario', $error) ?>>
                    Salario:
                    <input type="text" name="salario"
                    value="<?= $salario ?>"
                    <?= css_campo_error('salario', $error) ?>
                    >
                </label>
                <?php mostrar_errores('salario', $error) ?>
            </div>
            <div>
                <label <?= css_campo_error('fecha_nac', $error) ?>>
                    Fecha de nacimiento:
                    <input type="date" name="fecha_nac"
                    value="<?= $fecha_nac ?>"
                    <?= css_campo_error('fecha_nac', $error) ?>
                    >
                </label>
                <?php mostrar_errores('fecha_nac', $error) ?>
            </div>
            <div>
                <label <?= css_campo_error('departamento_id', $error) ?>>
                    Departamento:
                    <select name="departamento_id">
                        <?php foreach ($departamentos as $departamento): ?>
                            <option
                                value="<?= $departamento['id'] ?>"
                                <?= selected($departamento['id'],
                                             $departamento_id) ?>
                            >
                                <?= $departamento['denominacion'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </label>
                <?php mostrar_errores('departamento_id', $error) ?>
            </div>
            <div>
                <button type="submit">Insertar</button>
                <a href="index.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
