<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/panelStockAlmacen.php');

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

$panelStockAlmacenObject = new panelStockAlmacen();
$panelStockAlmacenObject->panelStockAlmacenShow($_GET['nombre']);
