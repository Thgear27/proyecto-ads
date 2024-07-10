<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/panelEmitirInformeProductosEnviados.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/EsolicitudEnvio.php');

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

$solicitudEnvioObject = new EsolicitudEnvio();
$solicitudes = $solicitudEnvioObject->obtenerSolicitudes();

$panelEmitirInformeProductosEnviadosObject = new panelEmitirInformeProductosEnviados();
$panelEmitirInformeProductosEnviadosObject->panelEmitirInformeProductosEnviadosShow($solicitudes);
