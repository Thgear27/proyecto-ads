<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/panelStockAlmacen.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/EproductoAlmacen.php');

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

$nombre = $_GET['nombre'];
$productos = null;

if ($nombre != null) {
  $EproductoAlmacenObject = new EproductoAlmacen();
  $productos = $EproductoAlmacenObject->obtenerProductosAlmacenPorNombre($nombre);
} else {
  $EproductoAlmacenObject = new EproductoAlmacen();
  $productos = $EproductoAlmacenObject->obtenerProductosAlmacen();
}

$panelStockAlmacenObject = new panelStockAlmacen();
$panelStockAlmacenObject->panelStockAlmacenShow($productos);
