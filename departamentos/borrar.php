<?php

require 'auxiliar.php';

$id = obtener_post('id');

if (!isset($id)) {
    return volver();
}

// TODO: Validar id
// Comprobar si el departamento tiene empleados

$pdo = conectar();
$pdo->beginTransaction();
$pdo->exec('LOCK TABLE departamentos IN SHARE MODE');
$sent = $pdo->prepare("SELECT COUNT(*)
                         FROM empleados
                        WHERE departamento_id = :id");
$sent->execute([':id' => $id]);
if ($sent->fetchColumn() === 0) {
    $sent = $pdo->prepare("DELETE FROM departamentos WHERE id = :id");
    $sent->execute([':id' => $id]);
}
$pdo->commit();
volver();
