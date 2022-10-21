<?php

require 'auxiliar.php';

$id = obtener_post('id');

if (!isset($id)) {
    return volver();
}

// TODO: Validar id

$pdo = conectar();
$sent = $pdo->prepare("DELETE FROM departamentos WHERE id = :id");
$sent->execute([':id' => $id]);
volver();
