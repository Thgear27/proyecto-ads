<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloVentas/panelConfirmarIngresoProductos.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/EsolicitudEnvio.php');

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

$solicitudEnvioObject = new EsolicitudEnvio();
$solicitudes = $solicitudEnvioObject->obtenerSolicitudes();

$panelConfirmarIngresoProductosObject = new panelConfirmarIngresoProductos();
$panelConfirmarIngresoProductosObject->panelConfirmarIngresoProductosShow($solicitudes);
