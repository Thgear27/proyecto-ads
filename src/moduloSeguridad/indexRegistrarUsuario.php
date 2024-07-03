<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formRegistrarUsuario.php');

session_start();

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$rol = $_SESSION['rol'];

if ($rol != "administrador") {
  header('Location: /moduloSeguridad/indexPanelPrincipal.php');
  exit();
}

$formRegistrarUsuarioObject = new formRegistrarUsuario();
$formRegistrarUsuarioObject->formRegistrarUsuarioShow();
