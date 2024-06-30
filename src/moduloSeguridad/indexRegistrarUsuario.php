<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formRegistrarUsuario.php');

session_start();

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$formRegistrarUsuarioObject = new formRegistrarUsuario();
$formRegistrarUsuarioObject->formRegistrarUsuarioShow();
