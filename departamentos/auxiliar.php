<?php

require '../comunes/auxiliar.php';

function insertar_departamento($codigo, $denominacion)
{
    $pdo = conectar();
    $sent = $pdo->prepare("INSERT
                             INTO departamentos (codigo, denominacion)
                           VALUES (:codigo, :denominacion)");
    $sent->execute([
        ':codigo' => $codigo,
        ':denominacion' => $denominacion,
    ]);
}
