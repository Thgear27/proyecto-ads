<?php
include($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formAutenticarUsuario.php');
include($_SERVER['DOCUMENT_ROOT'] . '/modelos/conexion.php');

$formAutenticarUsuario = new formAutenticarUsuario();
$formAutenticarUsuario->formAutenticarUsuarioShow("");

