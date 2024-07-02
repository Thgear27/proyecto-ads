<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formBuscarUsuario.php');

session_start();

$formBuscarUsuarioObject = new formBuscarUsuario();
$formBuscarUsuarioObject->formBuscarUsuarioShow();

