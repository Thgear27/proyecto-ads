<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/controlEmitirInformeProductosEnviados.php');
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

function validarBoton($boton)
{
  return isset($boton);
}


$btnEnviarProductos = $_POST['btnEnviarProductos'];
$IdSolicitud = $_POST['id_solicitud'];

if (validarBoton($btnEnviarProductos)) {
  $controlEmitirInformeProductosEnviadosObject = new controlEmitirInformeProductosEnviados();
  $controlEmitirInformeProductosEnviadosObject->cambiarEstadoSolicitud($IdSolicitud, 'enviado');
} else {
  $panelDetalleSolicitudObject = new panelDetalleSolicitud();
  $panelDetalleSolicitudObject->panelDetalleSolicitudShow($IdSolicitud);

  $viewMessageSistemaObject = new viewMessageSistema();
  $viewMessageSistemaObject->viewMessageSistemaShow("error", "Error", "Error, no se pudo completar la acción", "/moduloAlmacen/indexEmitirInformeProductoEnviados.php");
}
