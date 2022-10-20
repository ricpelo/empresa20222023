<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar un nuevo departamento</title>
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

    try {
        $codigo = obtener_post('codigo');
        $denominacion = obtener_post('denominacion');
        $error = [];
        comprobar_parametros($codigo, $denominacion);
        filtrar_codigo($codigo, $error);
        filtrar_denominacion($denominacion, $error);
        comprobar_errores($error);
        insertar_departamento($codigo, $denominacion);
        return volver();
    } catch (Exception $e) {
        // Vacío
    }
    ?>
    <div>
        <form action="" method="post">
            <div>
                <label <?= css_campo_error('codigo', $error) ?>>
                    Código:
                    <input type="text" name="codigo" size="10"
                    value="<?= $codigo ?>"
                    <?= css_campo_error('codigo', $error) ?>
                    >
                </label>
                <?php mostrar_errores('codigo', $error) ?>
            </div>
            <div>
                <label <?= css_campo_error('denominacion', $error) ?>>
                    Denominación:
                    <input type="text" name="denominacion"
                    value="<?= $denominacion ?>"
                    <?= css_campo_error('denominacion', $error) ?>
                    >
                </label>
                <?php mostrar_errores('denominacion', $error) ?>
            </div>
            <div>
                <button type="submit">Insertar</button>
                <a href="index.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
