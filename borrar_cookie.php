<?php

session_start();

require 'comunes/auxiliar.php';

setcookie('acepta_cookies', '1', 1, '/');
volver_principal();
