<?php
include($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formAutenticarUsuario.php');
include($_SERVER['DOCUMENT_ROOT'] . '/modelos/conexion.php');

$conexion = new Conexion();
$conexion->conectar();

$formAutenticarUsuario = new formAutenticarUsuario();
$formAutenticarUsuario->formAutenticarUsuarioShow("");

