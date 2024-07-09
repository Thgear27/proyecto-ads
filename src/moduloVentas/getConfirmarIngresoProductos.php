<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloVentas/controlConfirmarIngresoProductos.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloVentas/panelDetalleConfirmarIngresoProductos.php');

session_start();

$mensajeError = '';

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$rol = $_SESSION['rol'];

if ($rol != "tienda") {
  header('Location: /moduloSeguridad/indexPanelPrincipal.php');
  exit();
}

function validarBoton($boton)
{
  return isset($boton);
}

$btnConfirmarIngreso = $_POST['btnConfirmarIngreso'];
$btnDescargarPdf = $_POST['btnDescargarPdf'];

$idSolicitud = $_POST['id_solicitud'];

if (validarBoton($btnConfirmarIngreso)) {
  $controlConfirmarIngresoProductosObject = new controlConfirmarIngresoProductos();
  $controlConfirmarIngresoProductosObject->confirmarIngresoProductos($idSolicitud);
} elseif (validarBoton($btnDescargarPdf)) {
  $controlConfirmarIngresoProductosObject = new controlConfirmarIngresoProductos();
  $controlConfirmarIngresoProductosObject->generarSolicitudPdf($idSolicitud);
} else {
  $panelDetalleConfirmarIngresoProductosObject = new panelDetalleConfirmarIngresoProductos();
  $panelDetalleConfirmarIngresoProductosObject->panelDetalleConfirmarIngresoProductosShow($idSolicitud);

  $viewMessageSistemaObject = new viewMessageSistema();
  $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'El formulario no ha sido enviado', '/moduloVentas/indexConfirmarIngresoProductos.php');
}
