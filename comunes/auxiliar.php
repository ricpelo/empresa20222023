<?php

function conectar()
{
    return new PDO('pgsql:host=localhost;dbname=empresa', 'empresa', 'empresa');
}

/**
 * Vuelve al index.php
 */
function volver()
{
    header("Location: index.php");
}

function obtener_get($par)
{
    return obtener_parametro($par, $_GET);
}

function obtener_post($par)
{
    return obtener_parametro($par, $_POST);
}

function obtener_parametro($par, $array)
{
    return isset($array[$par]) ? trim($array[$par]) : null;
}

function validar_digitos($numero, $campo, &$error)
{
    if (!ctype_digit($numero)) {
        insertar_error(
            $campo,
            'Los caracteres del campo no son válidos',
            $error
        );
    }
}

function validar_rango_numerico($numero, $campo, $min, $max, &$error)
{
    if ($numero < $min || $numero > $max) {
        insertar_error(
            $campo,
            'La longitud del campo es incorrecta',
            $error
        );
    }
}

function validar_existe($tabla, $columna, $valor, $campo, &$error)
{
    $pdo = conectar();
    $sent = $pdo->prepare("SELECT COUNT(*)
                             FROM $tabla
                            WHERE $columna = :$columna");
    $sent->execute([":$columna" => $valor]);
    $cuantos = $sent->fetchColumn();
    if ($cuantos !== 0) {
        insertar_error($campo, 'La fila ya existe', $error);
    }
}

function validar_longitud($cadena, $campo, $min, $max, &$error)
{
    $long = mb_strlen($cadena);

    if ($long < $min || $long > $max) {
        insertar_error(
            $campo,
            'La longitud del campo es incorrecta',
            $error
        );
    }
}

function insertar_error($campo, $mensaje, &$error)
{
    if (!isset($error[$campo])) {
        $error[$campo] = [];
    }
    $error[$campo][] = $mensaje;
}

function mostrar_errores($campo, $error)
{
    if (isset($error[$campo])) {
        foreach ($error[$campo] as $mensaje) { ?>
            <ul <?= css_error($campo, $error) ?>>
                <li><?= $mensaje ?></li>
            </ul><?php
        }
    }
}

function comprobar_parametros($codigo, $denominacion)
{
    if (!isset($codigo, $denominacion)) {
        throw new Exception();
    }
}

function comprobar_errores($error)
{
    if (!empty($error)) {
        throw new Exception();
    }
}

function css_error($campo, $error)
{
    return isset($error[$campo]) ? 'class="error"' : '';
}

function css_campo_error($campo, $error)
{
    return isset($error[$campo]) ? 'class="campo-error"' : '';
}
