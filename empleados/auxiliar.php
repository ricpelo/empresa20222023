<?php

require '../comunes/auxiliar.php';

function validar_numero($numero, &$error)
{
    validar_digitos($numero, 'numero', $error);
    validar_longitud($numero, 'numero', 1, 4, $error);
    if (!isset($error['numero'])) {
        validar_existe_numero_empleado($numero, $error);
    }
}

function validar_nombre($nombre, &$error)
{
    validar_longitud($nombre, 'nombre', 1, 255, $error);
}

function validar_salario($salario, &$error)
{
    validar_numerico($salario, 'salario', $error);
    validar_formato_salario($salario, $error);
    if (!isset($error['salario'])) {
        validar_rango_numerico(
            $salario,
            'salario',
            -99999.99,
            99999.99,
            $error
        );
    }
}

function validar_fecha_nac($fecha_nac, &$error)
{
    $fecha = [];
    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $fecha_nac, $fecha) === 0) {
        insertar_error(
            'fecha_nac',
            'El campo no tiene un formato válido',
            $error
        );
        return;
    }

    if (!checkdate($fecha[2], $fecha[3], $fecha[1])) {
        insertar_error(
            'fecha_nac',
            'El campo no contiene una fecha válida',
            $error
        );
    }
}

function validar_departamento_id($departamento_id, &$error)
{
    validar_digitos($departamento_id, 'departamento_id', $error);

    if (isset($error['departamento_id'])) {
        return;
    }

    if (!comprobar_existe('departamentos', 'id', $departamento_id)) {
        insertar_error('departamento_id', 'La fila no existe', $error);
    }
}

function validar_formato_salario($numero, &$error)
{
    if (preg_match(
        '/^[-+]?((\d+([.,]?\d{0,2})?)|([.,]\d{1,2}))$/',
        $numero
    ) === 0) {
        insertar_error(
            'salario',
            'El campo no tiene un formato válido',
            $error
        );
    }
}

function validar_existe_numero_empleado($numero, &$error): bool
{
    return validar_existe(
        'empleados',
        'numero',
        $numero,
        'numero',
    $error);
}

function insertar_empleado($par, $pdo)
{
    $columnas = implode(', ', array_keys($par));
    $marcadores = implode(', ', array_map(fn($s) => ":$s", array_keys($par)));

    $sent = $pdo->prepare("INSERT INTO empleados ($columnas)
                           VALUES ($marcadores)");
    $execute = [];
    foreach ($par as $k => $v) {
        $execute[":$k"] = $v;
    }
    $sent->execute($execute);
}
