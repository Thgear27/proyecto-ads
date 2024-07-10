<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloVentas/panelEmitirSolicitudEnvioProducto.php');

session_start();

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$rol = $_SESSION['rol'];

if ($rol != "tienda") {
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

$panelEmitirSolicitudEnvioProductoObject = new panelEmitirSolicitudEnvioProducto();
$panelEmitirSolicitudEnvioProductoObject->panelEmitirSolicitudEnvioProductoShow($productos);
