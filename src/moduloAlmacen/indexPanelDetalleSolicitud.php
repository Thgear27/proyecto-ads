<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/panelDetalleSolicitud.php');

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

$panelDetalleSolicitudObject = new panelDetalleSolicitud();
$panelDetalleSolicitudObject->panelDetalleSolicitudShow($_GET['id']);