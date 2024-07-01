<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formCambiarContrasena.php');

session_start();

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$formCambiarContrasenaObject = new formCambiarContrasena();
$formCambiarContrasenaObject->formCambiarContrasenaShow();
