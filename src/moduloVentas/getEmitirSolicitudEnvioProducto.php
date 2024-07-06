<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloVentas/panelEmitirSolicitudEnvioProducto.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloVentas/controlEmitirSolicitudEnvioProducto.php');

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

function validarBoton($btnRegistrarProducto)
{
  return isset($btnRegistrarProducto);
}

function validarProductos($productos)
{
  global $mensajeError;
  $productos = json_decode($productos, true);

  if (empty($productos)) {
    $mensajeError = 'No se han seleccionado productos';
    return false;
  }
  return true;
}

$btnGenerarSolicitudEnvio = $_POST['btnGenerarSolicitudEnvio'];
$btnBuscar = $_POST['btnBuscar'];

if (validarBoton($btnGenerarSolicitudEnvio)) {
  $productos = $_POST['productos'];

  if (validarProductos($productos)) {
    $productos = json_decode($productos, true);
    $controlEmitirSolicitudEnvioProductoObject = new controlEmitirSolicitudEnvioProducto();
    $controlEmitirSolicitudEnvioProductoObject->generarSolicitudEnvioProductos($productos);
  } else {
    $panelEmitirSolicitudEnvioProductoObject = new panelEmitirSolicitudEnvioProducto();
    $panelEmitirSolicitudEnvioProductoObject->panelEmitirSolicitudEnvioProductoShow();

    $viewMessageSistemaObject = new viewMessageSistema();
    $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', $mensajeError, '/moduloVentas/indexEmitirSolicitudEnvioProducto.php');
  }
} elseif (validarBoton($btnBuscar)) {
  header('Location: /moduloVentas/indexEmitirSolicitudEnvioProducto.php?nombre=' . $_POST['txtNombreProducto']);
} else {
  $panelEmitirSolicitudEnvioProductoObject = new panelEmitirSolicitudEnvioProducto();
  $panelEmitirSolicitudEnvioProductoObject->panelEmitirSolicitudEnvioProductoShow();

  $viewMessageSistemaObject = new viewMessageSistema();
  $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'El formulario no ha sido enviado', '/moduloVentas/indexEmitirSolicitudEnvioProducto.php');
}
