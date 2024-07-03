<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/formRegistrarProductoAlmacen.php');

session_start();

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$rol = $_SESSION['rol'];

if ($rol != "almacen" && $rol != "administrador") {
  header('Location: /moduloSeguridad/indexPanelPrincipal.php');
  exit();
}

$formRegistrarProductoAlmacenObject = new formRegistrarProductoAlmacen();
$formRegistrarProductoAlmacenObject->formRegistrarProductoAlmacenShow();
