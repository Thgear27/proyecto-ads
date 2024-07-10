<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloVentas/panelDetalleConfirmarIngresoProductos.php');

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

$idSolicitud = $_GET['id'];

$solicitudEnvioObject = new EsolicitudEnvio();
$productos = $solicitudEnvioObject->obtenerProductosSolicitud($idSolicitud);

$solicitudEnvioObject = new EsolicitudEnvio();
$solicitud = $solicitudEnvioObject->obtenerSolicitud($idSolicitud);

$panelDetalleConfirmarIngresoProductosObject = new panelDetalleConfirmarIngresoProductos();
$panelDetalleConfirmarIngresoProductosObject->panelDetalleConfirmarIngresoProductosShow($productos, $solicitud, $idSolicitud);
